<?php
/**
 * contact.php — Endpoint d'envoi d'email pour le formulaire de contact EMS
 * Déployé automatiquement dans dist/ par Vite (dossier public/)
 */

// ── Headers de sécurité et CORS (même domaine) ──────────────────────────────
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

// ── Construction de l'email ───────────────────────────────────────────────────
$to      = 'contact@energeticmaintenances.fr';
$subject = '=?UTF-8?B?' . base64_encode('Nouvelle demande de devis — ' . $company) . '?=';

$body  = "Vous avez reçu une nouvelle demande de devis via le formulaire de contact.\n\n";
$body .= "---\n";
$body .= "Entreprise : " . $company . "\n";
$body .= "Email      : " . $email . "\n";
$body .= "Téléphone  : " . ($phone !== '' ? $phone : 'Non renseigné') . "\n";
$body .= "---\n\n";
$body .= "Message :\n" . $message . "\n\n";
$body .= "---\n";
$body .= "Envoyé depuis le formulaire energetic-ms.fr\n";

// ── Headers email ─────────────────────────────────────────────────────────────
// From    : l'adresse du site (crédibilité, SPF validé sur le même domaine)
// Reply-To: l'email du visiteur (répondre directement depuis votre client mail)
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "From: EMS Contact <contact@energeticmaintenances.fr>\r\n";
$headers .= "Reply-To: " . $company . " <" . $email . ">\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// ── Envoi ─────────────────────────────────────────────────────────────────────
$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi. Merci de nous appeler directement.']);
}
