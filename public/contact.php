<?php
/**
 * contact.php — Endpoint d'envoi d'email + log JSON Lines pour le formulaire EMS
 * Déployé automatiquement dans dist/ par Vite (dossier public/)
 */

// ── Headers de sécurité ───────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// N'accepter que les POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
    exit;
}

// ── Lecture du corps JSON ────────────────────────────────────────────────────
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Données invalides.']);
    exit;
}

// ── Protection anti-spam : honeypot ─────────────────────────────────────────
// Le champ "_hp" doit rester vide. Les bots le remplissent, les humains non.
if (!empty($data['_hp'])) {
    // On répond 200 pour ne pas alerter le bot, mais on n'envoie rien.
    echo json_encode(['success' => true]);
    exit;
}

// ── Récupération et sanitisation des champs ──────────────────────────────────
$company = isset($data['company']) ? trim(strip_tags($data['company'])) : '';
$email   = isset($data['email'])   ? trim($data['email'])               : '';
$phone   = isset($data['phone'])   ? trim(strip_tags($data['phone']))   : '';
$message = isset($data['message']) ? trim(strip_tags($data['message'])) : '';

// ── Validation des champs obligatoires ───────────────────────────────────────
if ($company === '' || $email === '' || $message === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Champs obligatoires manquants.']);
    exit;
}

// ── Validation de l'email ────────────────────────────────────────────────────
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Adresse email invalide.']);
    exit;
}

// Sanitiser l'email après validation
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// ── Limites de longueur (protection contre les abus) ─────────────────────────
if (strlen($company) > 200 || strlen($message) > 5000 || strlen($phone) > 30) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Contenu trop long.']);
    exit;
}

// ── Collecte des métadonnées de la requête ────────────────────────────────────
$now        = new DateTime('now', new DateTimeZone('Europe/Paris'));
$date_iso   = $now->format(DateTime::ATOM);           // ex: 2026-07-19T18:42:11+02:00
$entry_id   = 'EMS-' . $now->format('Ymd-His');      // ex: EMS-20260719-184211

// Donnée technique de sécurité (base légale : intérêt légitime — RGPD Art. 6-1-f)
$ip         = $_SERVER['REMOTE_ADDR'] ?? 'inconnue';
$user_agent = isset($_SERVER['HTTP_USER_AGENT'])
              ? substr($_SERVER['HTTP_USER_AGENT'], 0, 300)
              : '';
$referer    = isset($_SERVER['HTTP_REFERER'])
              ? substr($_SERVER['HTTP_REFERER'], 0, 500)
              : '';

// ── Fonction : écriture d'une ligne dans contacts.jsonl ──────────────────────
function write_log(array $entry): bool
{
    $data_dir = __DIR__ . '/data';
    $log_file = $data_dir . '/contacts.jsonl';
    $htaccess = $data_dir . '/.htaccess';

    // Créer le dossier data/ s'il n'existe pas
    if (!is_dir($data_dir)) {
        if (!mkdir($data_dir, 0750, true)) {
            return false;
        }
    }

    // Créer le .htaccess de protection si absent
    // Syntaxe Apache 2.4+ : bloque tout accès HTTP direct au fichier de logs
    if (!file_exists($htaccess)) {
        $htaccess_content  = "<Files \"contacts.jsonl\">\n";
        $htaccess_content .= "    Require all denied\n";
        $htaccess_content .= "</Files>\n";
        file_put_contents($htaccess, $htaccess_content, LOCK_EX);
    }

    // Encoder l'entrée en JSON sur une seule ligne (json_encode sécurise nativement
    // les caractères spéciaux : <, >, ", \, caractères Unicode non-ASCII)
    $line = json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($line === false) {
        return false;
    }

    // Appendre la ligne au fichier avec verrou exclusif (protection concurrence)
    return file_put_contents($log_file, $line . "\n", FILE_APPEND | LOCK_EX) !== false;
}

// ── Construction de l'email ───────────────────────────────────────────────────
$to      = 'contact@energeticmaintenances.fr';
$subject = '=?UTF-8?B?' . base64_encode('Nouvelle demande de devis — ' . $company) . '?=';

$body  = "Vous avez reçu une nouvelle demande de devis via le formulaire de contact.\n\n";
$body .= "Réf. : " . $entry_id . "\n";
$body .= "---\n";
$body .= "Entreprise : " . $company . "\n";
$body .= "Email      : " . $email . "\n";
$body .= "Téléphone  : " . ($phone !== '' ? $phone : 'Non renseigné') . "\n";
$body .= "---\n\n";
$body .= "Message :\n" . $message . "\n\n";
$body .= "---\n";
$body .= "Envoyé depuis le formulaire energeticmaintenances.fr\n";

// ── Headers email ─────────────────────────────────────────────────────────────
// From    : l'adresse du site (crédibilité, SPF validé sur le même domaine)
// Reply-To: l'email du visiteur (répondre directement depuis votre client mail)
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "From: EMS Contact <contact@energeticmaintenances.fr>\r\n";
$headers .= "Reply-To: " . $company . " <" . $email . ">\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// ── Envoi email ───────────────────────────────────────────────────────────────
$sent = mail($to, $subject, $body, $headers);

// ── Écriture du log : 1 seule ligne, après l'envoi, avec le résultat réel ────
$log_entry = [
    'id'         => $entry_id,
    'date'       => $date_iso,
    'company'    => $company,
    'email'      => $email,
    'phone'      => $phone !== '' ? $phone : null,
    'message'    => $message,
    'ip'         => $ip,        // Donnée technique de sécurité — voir politique de confidentialité
    'user_agent' => $user_agent,
    'referer'    => $referer !== '' ? $referer : null,
    'mail_sent'  => $sent,      // Résultat réel de mail()
];

$log_written = write_log($log_entry);

// ── Réponse à Vue ─────────────────────────────────────────────────────────────
if ($sent && $log_written) {
    // Cas nominal : email OK + log OK
    echo json_encode(['success' => true]);
} elseif ($sent && !$log_written) {
    // Email envoyé mais log impossible (problème de permissions serveur)
    // La demande est reçue, on retourne succès pour ne pas pénaliser le visiteur
    echo json_encode(['success' => true]);
} else {
    // Email échoué (log écrit avec mail_sent: false si possible)
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi. Merci de nous appeler directement.']);
}
