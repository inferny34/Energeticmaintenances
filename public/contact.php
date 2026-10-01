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
    echo json_encode(['success' => true]);
    exit;
}

// ── Récupération et sanitisation des champs ──────────────────────────────────
$projectType = isset($data['projectType']) ? trim(strip_tags((string)$data['projectType'])) : '';
$name        = isset($data['name'])        ? trim(strip_tags((string)$data['name']))        : '';
$postalCode  = isset($data['postalCode'])  ? trim(strip_tags((string)$data['postalCode']))  : '';
$email       = isset($data['email'])       ? trim((string)$data['email'])                   : '';
$phone       = isset($data['phone'])       ? trim(strip_tags((string)$data['phone']))       : '';
$referredBy  = isset($data['referredBy'])  ? trim(strip_tags((string)$data['referredBy']))  : '';
$message     = isset($data['message'])     ? trim(strip_tags((string)$data['message']))     : '';
$consent     = !empty($data['consent']) && ($data['consent'] === true || $data['consent'] === 'true' || $data['consent'] === 1 || $data['consent'] === '1');

// Labels lisibles pour le type de besoin
$projectLabels = [
    'borne-domicile' => 'Borne à domicile',
    'depannage'      => 'Dépannage / Conformité',
    'projet-pro'     => 'Projet professionnel (HTA/IRVE)',
];
$projectLabel = $projectLabels[$projectType] ?? 'Non précisé';

// ── Validation du consentement RGPD (obligatoire) ───────────────────────────
if (!$consent) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Le consentement au traitement des données personnelles est obligatoire.']);
    exit;
}

// ── Validation des champs obligatoires ───────────────────────────────────────
if ($name === '' || $postalCode === '' || $message === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Champs obligatoires manquants (nom, code postal, message).']);
    exit;
}

// Au moins un moyen de contact : téléphone OU email obligatoire
if ($phone === '' && $email === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Veuillez renseigner au moins un moyen de contact (téléphone ou email).']);
    exit;
}

// ── Validation de l'email (uniquement s'il est renseigné) ───────────────────
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Adresse email invalide.']);
    exit;
}

// Sanitiser l'email après validation
if ($email !== '') {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
}

// ── Limites de longueur (protection anti-abus) ──────────────────────────────
if (strlen($name) > 200 || strlen($postalCode) > 20 || strlen($referredBy) > 200 || strlen($message) > 5000 || strlen($phone) > 30) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Contenu trop long.']);
    exit;
}

// ── Collecte des métadonnées de la requête ────────────────────────────────────
$now        = new DateTime('now', new DateTimeZone('Europe/Paris'));
$date_iso   = $now->format(DateTime::ATOM);
$entry_id   = 'EMS-' . $now->format('Ymd-His');

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

    if (!is_dir($data_dir)) {
        if (!mkdir($data_dir, 0750, true)) {
            return false;
        }
    }

    if (!file_exists($htaccess)) {
        $htaccess_content  = "<Files \"contacts.jsonl\">\n";
        $htaccess_content .= "    Require all denied\n";
        $htaccess_content .= "</Files>\n";
        file_put_contents($htaccess, $htaccess_content, LOCK_EX);
    }

    $line = json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($line === false) {
        return false;
    }

    return file_put_contents($log_file, $line . "\n", FILE_APPEND | LOCK_EX) !== false;
}

// ── Construction de l'email ───────────────────────────────────────────────────
$to      = 'contact@energeticmaintenances.fr';
$subject = '=?UTF-8?B?' . base64_encode('Nouvelle demande [' . $projectLabel . '] — ' . $name) . '?=';

$body  = "Vous avez reçu une nouvelle demande de devis via le formulaire energeticmaintenances.fr\n\n";
$body .= "Réf.         : " . $entry_id . "\n";
$body .= "Date         : " . $date_iso . "\n";
$body .= "---\n";
$body .= "Besoin       : " . $projectLabel . "\n";
$body .= "Nom          : " . $name . "\n";
$body .= "Code Postal  : " . $postalCode . "\n";
$body .= "Téléphone    : " . ($phone !== '' ? $phone : 'Non renseigné') . "\n";
$body .= "Email        : " . ($email !== '' ? $email : 'Non renseigné') . "\n";
$body .= "Recommandé par : " . ($referredBy !== '' ? $referredBy : 'Aucun parrain') . "\n";
$body .= "Consentement : Validé le " . $date_iso . "\n";
$body .= "---\n\n";
$body .= "Message :\n" . $message . "\n\n";
$body .= "---\n";
$body .= "Envoyé depuis energeticmaintenances.fr\n";

// ── Headers email ─────────────────────────────────────────────────────────────
$replyTo = $email !== '' ? ($name !== '' ? '"' . addcslashes($name, '"') . '" <' . $email . '>' : $email) : 'contact@energeticmaintenances.fr';

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "From: EMS Contact <contact@energeticmaintenances.fr>\r\n";
$headers .= "Reply-To: " . $replyTo . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// ── Envoi email ───────────────────────────────────────────────────────────────
$sent = mail($to, $subject, $body, $headers);

// ── Écriture du log avec consentement RGPD horodaté ───────────────────────────
$log_entry = [
    'id'           => $entry_id,
    'date'         => $date_iso,
    'projectType'  => $projectType !== '' ? $projectType : null,
    'name'         => $name,
    'postalCode'   => $postalCode,
    'phone'        => $phone !== '' ? $phone : null,
    'email'        => $email !== '' ? $email : null,
    'referredBy'   => $referredBy !== '' ? $referredBy : null,
    'consent'      => true,
    'consent_date' => $date_iso,
    'message'      => $message,
    'ip'           => $ip,
    'user_agent'   => $user_agent,
    'referer'      => $referer !== '' ? $referer : null,
    'mail_sent'    => $sent,
];

$log_written = write_log($log_entry);

// ── Réponse JSON ──────────────────────────────────────────────────────────────
if ($sent && $log_written) {
    echo json_encode(['success' => true]);
} elseif ($sent && !$log_written) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi. Merci de nous contacter directement par téléphone.']);
}
