<?php
/**
 * apporteurs.php — Endpoint unifié de gestion des formulaires Apporteurs EMS
 *
 * Formats acceptés : POST multipart/form-data
 * Paramètre URL requis : ?form=registration ou ?form=referral
 *
 * Réponse JSON :
 *   Succès : { "success": true, "receipt_id": "EMS-AAAAMMJJ-XXXXXX" } (HTTP 200)
 *   Erreur : { "success": false, "error": "Description du problème" } (HTTP 4xx / 5xx)
 *
 * Déployé automatiquement dans dist/api/ par Vite (dossier public/api/)
 */

declare(strict_types=1);

// ── Chargement autonome de PHPMailer embarqué (sans Composer) ───────────────
require_once __DIR__ . '/lib/Exception.php';
require_once __DIR__ . '/lib/PHPMailer.php';
require_once __DIR__ . '/lib/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ── Headers de sécurité et JSON ──────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

// ── 1. Vérification de la méthode HTTP ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée. Utilisez POST.'], JSON_UNESCAPED_UNICODE);
    exit;
}

// ── 2. Vérification de l'origine (anti-CSRF basique) ─────────────────────────
$host = $_SERVER['HTTP_HOST'] ?? '';
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

if ($origin !== '') {
    $originHost = parse_url($origin, PHP_URL_HOST);
    $currentHost = parse_url('http://' . $host, PHP_URL_HOST);
    if ($originHost !== null && $originHost !== $currentHost) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Origine non autorisée.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// ── 3. Protection Honeypot ───────────────────────────────────────────────────
// Le champ "website" est invisible pour les humains. S'il est rempli, c'est un bot.
// On simule un succès pour ne pas l'alerter sans exécuter aucun traitement.
if (!empty($_POST['website'])) {
    echo json_encode([
        'success'    => true,
        'receipt_id' => 'EMS-' . date('Ymd') . '-OK' . strtoupper(substr(md5(uniqid()), 0, 4)),
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ── 4. Chargement de la configuration externe ────────────────────────────────
// La configuration se trouve HORS de public_html sur o2switch.
$configLocations = [
    dirname(dirname(__DIR__)) . '/apporteurs_config.php',       // /home/<user>/apporteurs_config.php depuis /home/<user>/public_html/api
    dirname(dirname(dirname(__DIR__))) . '/apporteurs_config.php',
    __DIR__ . '/config.local.php',                             // Pour tests locaux
];

$config = [
    'notification_email' => 'contact@energeticmaintenances.fr',
    'mail_from'          => 'contact@energeticmaintenances.fr',
    'mail_from_name'     => 'EMS Programme Apporteurs',
    'storage_dir'        => dirname(dirname(__DIR__)) . '/apporteurs_data',
    'smtp'               => [
        'enabled'    => true,
        'host'       => 'smtp-relay.brevo.com',
        'port'       => 587,
        'username'   => '',
        'password'   => '',
        'encryption' => 'tls',
    ],
    'rate_limit'         => [
        'max_requests'   => 5,
        'window_seconds' => 3600,
    ],
];

foreach ($configLocations as $cfgFile) {
    if (file_exists($cfgFile)) {
        $loaded = include $cfgFile;
        if (is_array($loaded)) {
            $config = array_replace_recursive($config, $loaded);
            break;
        }
    }
}

// Répertoire privé pour les fichiers, rate limits et logs (HORS de public_html)
$storageDir = rtrim($config['storage_dir'], '/\\');
if (!is_dir($storageDir)) {
    @mkdir($storageDir, 0750, true);
}

// ── 5. Limitation de débit par IP (Rate Limiting) avec flock() ──────────────
function checkRateLimit(string $ip, string $storageDir, int $maxRequests, int $windowSeconds): bool {
    $file = $storageDir . '/rate_limits.json';
    $fp = @fopen($file, 'c+');
    if (!$fp) {
        return true;
    }

    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return true;
    }

    $raw = '';
    while (!feof($fp)) {
        $raw .= fread($fp, 8192);
    }

    $limits = json_decode($raw, true) ?: [];
    $now = time();

    // Purge des expirés
    foreach ($limits as $k => $v) {
        if (!isset($v['start']) || ($now - (int)$v['start']) > $windowSeconds) {
            unset($limits[$k]);
        }
    }

    $allowed = true;
    if (!isset($limits[$ip])) {
        $limits[$ip] = ['start' => $now, 'count' => 1];
    } else {
        $limits[$ip]['count']++;
        if ($limits[$ip]['count'] > $maxRequests) {
            $allowed = false;
        }
    }

    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($limits, JSON_UNESCAPED_UNICODE));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);

    return $allowed;
}

$clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$maxRequests = (int)($config['rate_limit']['max_requests'] ?? 5);
$windowSeconds = (int)($config['rate_limit']['window_seconds'] ?? 3600);

if (!checkRateLimit($clientIp, $storageDir, $maxRequests, $windowSeconds)) {
    http_response_code(429);
    echo json_encode([
        'success' => false,
        'error'   => 'Trop de demandes envoyées depuis cette adresse IP. Veuillez patienter avant de renouveler l’opération.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ── 6. Détermination du type de formulaire ──────────────────────────────────
$formType = $_GET['form'] ?? $_POST['form_type'] ?? '';
if (!in_array($formType, ['registration', 'referral'], true)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Type de formulaire invalide ou non précisé (?form=registration ou ?form=referral).',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ── 7. Sanitisation stricte anti-CRLF et protection contre injections ────────
/**
 * Nettoie une chaîne contre les injections CRLF (pour headers email, noms, sujets)
 */
function cleanHeader(string $val, int $maxLen = 200): string {
    $val = str_replace(["\r", "\n", "\0", "%0a", "%0d", "%0A", "%0D"], '', $val);
    $val = trim(strip_tags($val));
    return mb_substr($val, 0, $maxLen, 'UTF-8');
}

/**
 * Nettoie et valide une adresse e-mail
 */
function cleanEmail(string $key): string {
    $val = cleanHeader((string)($_POST[$key] ?? ''), 254);
    $filtered = filter_var($val, FILTER_VALIDATE_EMAIL);
    return $filtered ? (string)$filtered : '';
}

/**
 * Nettoie un champ texte multiligne
 */
function cleanText(string $key, int $maxLen = 2000): string {
    $val = (string)($_POST[$key] ?? '');
    $val = str_replace(["\r\n", "\r"], "\n", $val);
    $val = str_replace("\0", '', $val);
    $val = trim(strip_tags($val));
    return mb_substr($val, 0, $maxLen, 'UTF-8');
}

/**
 * Échappe une chaîne pour affichage sécurisé dans un email HTML
 */
function h(string $val): string {
    return htmlspecialchars($val, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$uploadedFiles = [];
$maxFileBytes = 10 * 1024 * 1024; // 10 Mo
$allowedMimes = [
    'pdf'  => 'application/pdf',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
];

/**
 * Valide et enregistre un fichier uploadé dans le dossier privé hors web
 */
function handleUpload(
    string $field,
    bool $required,
    string $storageDir,
    string $subDir,
    int $maxBytes,
    array $allowedMimes
): ?array {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        if ($required) {
            throw new InvalidArgumentException("La pièce justificative « {$field} » est obligatoire.");
        }
        return null;
    }

    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new InvalidArgumentException("Erreur lors du transfert de la pièce « {$field} » (code : {$file['error']}).");
    }

    if ($file['size'] > $maxBytes) {
        throw new InvalidArgumentException("La pièce « {$field} » dépasse la taille maximale autorisée de 10 Mo.");
    }

    // Vérification MIME réelle avec finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $realMime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $origName = cleanHeader((string)($file['name'] ?? 'document'), 150);
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

    if (!in_array($realMime, array_values($allowedMimes), true)) {
        if ($field === 'consent_evidence' && ($ext === 'eml' || $realMime === 'message/rfc822' || $realMime === 'text/plain')) {
            $ext = 'eml';
        } else {
            throw new InvalidArgumentException("Le format de la pièce « {$field} » n'est pas autorisé (formats acceptés : PDF, JPG, PNG).");
        }
    }

    // Nom aléatoire pour éviter toute collision et empêcher la découverte
    $targetDir = $storageDir . '/' . $subDir;
    if (!is_dir($targetDir)) {
        @mkdir($targetDir, 0750, true);
    }

    $safeName = bin2hex(random_bytes(16)) . '.' . ($ext ?: 'bin');
    $targetPath = $targetDir . '/' . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new RuntimeException("Impossible d'enregistrer le fichier sur le serveur.");
    }

    return [
        'field'         => $field,
        'original_name' => $origName,
        'safe_name'     => $safeName,
        'path'          => $targetPath,
        'mime'          => $realMime,
        'size'          => $file['size'],
    ];
}

// ── 8. Traitement spécifique selon le formulaire ─────────────────────────────
$dateFormatted = date('Ymd');
$uniqueCode = strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
$receiptId = "EMS-{$dateFormatted}-{$uniqueCode}";
$record = [];
$emailSubject = '';
$emailBodyHtml = '';
$emailBodyText = '';
$partnerEmail = '';
$partnerName = '';

try {
    if ($formType === 'registration') {
        // ── Formulaire « Devenir apporteur » ────────────────────────────────
        $partnerName     = cleanHeader((string)($_POST['partner_name'] ?? ''), 160);
        $partnerEmail    = cleanEmail('email');
        $phone           = cleanHeader((string)($_POST['phone'] ?? ''), 30);
        $address         = cleanHeader((string)($_POST['address'] ?? ''), 400);
        $company         = cleanHeader((string)($_POST['company'] ?? ''), 200);
        $legalForm       = cleanHeader((string)($_POST['legal_form'] ?? ''), 100);
        $siret           = cleanHeader((string)($_POST['siret'] ?? ''), 14);
        $partnerSigner   = cleanHeader((string)($_POST['partner_signer'] ?? ''), 160);
        $vatRegime       = cleanHeader((string)($_POST['vat_regime'] ?? ''), 50);
        $vatEffectiveAt  = cleanHeader((string)($_POST['vat_effective_at'] ?? ''), 20);
        $vatRate         = cleanHeader((string)($_POST['vat_rate'] ?? ''), 10);
        $vatNumber       = cleanHeader((string)($_POST['vat_number'] ?? ''), 40);
        $vatOther        = cleanText('vat_other', 1000);
        $profLink        = cleanHeader((string)($_POST['professional_link'] ?? ''), 10);
        $profession      = cleanHeader((string)($_POST['profession'] ?? ''), 160);
        $employer        = cleanHeader((string)($_POST['employer'] ?? ''), 200);
        $notes           = cleanText('notes', 2000);
        $contractRead    = !empty($_POST['contract_read']);
        $checksCompleted = cleanHeader((string)($_POST['checks_completed'] ?? ''), 10);

        if ($partnerName === '' || $partnerEmail === '' || $phone === '' || $address === '') {
            throw new InvalidArgumentException("Veuillez renseigner vos coordonnées complètes (nom, email valide, téléphone, adresse).");
        }
        if ($company === '' || $legalForm === '' || $partnerSigner === '') {
            throw new InvalidArgumentException("Veuillez renseigner les informations de l'entreprise (raison sociale, forme juridique, signataire).");
        }
        if (!preg_match('/^[0-9]{14}$/', $siret)) {
            throw new InvalidArgumentException("Le numéro SIRET doit comporter exactement 14 chiffres.");
        }
        if (!in_array($vatRegime, ['Franchise en base de TVA', 'TVA facturée', 'Autre'], true)) {
            throw new InvalidArgumentException("Veuillez sélectionner un régime de TVA valide.");
        }
        if ($vatRegime === 'TVA facturée' && ($vatRate === '' || $vatNumber === '')) {
            throw new InvalidArgumentException("Le taux de TVA et le numéro de TVA sont obligatoires pour le régime TVA facturée.");
        }
        if ($vatRegime === 'Autre' && $vatOther === '') {
            throw new InvalidArgumentException("Veuillez préciser votre situation fiscale pour le régime de TVA.");
        }
        if ($profession === '') {
            throw new InvalidArgumentException("Veuillez renseigner votre profession / fonction.");
        }
        if (!$contractRead) {
            throw new InvalidArgumentException("Vous devez confirmer avoir pris connaissance du contrat d'apporteur.");
        }
        if ($checksCompleted !== 'Oui') {
            throw new InvalidArgumentException("Vous devez confirmer avoir réalisé les vérifications requises.");
        }

        // Upload des 4 pièces obligatoires
        $subDir = 'registration/' . $receiptId;
        $docKeys = ['rib', 'registration_proof', 'vigilance_proof', 'vat_proof'];
        foreach ($docKeys as $k) {
            $up = handleUpload($k, true, $storageDir, $subDir, $maxFileBytes, $allowedMimes);
            if ($up) $uploadedFiles[$k] = $up;
        }

        $record = [
            'type'              => 'registration',
            'receipt_id'        => $receiptId,
            'submission_id'     => cleanHeader((string)($_POST['submission_id'] ?? ''), 100),
            'model_version'     => cleanHeader((string)($_POST['model_version'] ?? ''), 10),
            'created_at'        => date('c'),
            'ip'                => $clientIp,
            'partner_name'      => $partnerName,
            'email'             => $partnerEmail,
            'phone'             => $phone,
            'address'           => $address,
            'company'           => $company,
            'legal_form'        => $legalForm,
            'siret'             => $siret,
            'partner_signer'    => $partnerSigner,
            'vat_regime'        => $vatRegime,
            'vat_effective_at'  => $vatEffectiveAt,
            'vat_rate'          => $vatRate,
            'vat_number'        => $vatNumber,
            'vat_other'         => $vatOther,
            'professional_link' => $profLink,
            'profession'        => $profession,
            'employer'          => $employer,
            'notes'             => $notes,
            'documents'         => $uploadedFiles,
        ];

        $emailSubject = cleanHeader("[Apporteur EMS] Nouvelle candidature — {$company} ({$receiptId})");

        // Construction version HTML (tous champs échappés avec h())
        $emailBodyHtml = '<h2>Nouvelle demande de candidature au Programme Apporteurs EMS</h2>';
        $emailBodyHtml .= '<p><strong>Référence dossier :</strong> ' . h($receiptId) . '<br>';
        $emailBodyHtml .= '<strong>Date :</strong> ' . date('d/m/Y H:i:s') . '</p>';
        $emailBodyHtml .= '<hr><h3>Identité professionnelle</h3>';
        $emailBodyHtml .= '<ul>';
        $emailBodyHtml .= '<li><strong>Entreprise :</strong> ' . h($company) . ' (' . h($legalForm) . ')</li>';
        $emailBodyHtml .= '<li><strong>SIRET :</strong> ' . h($siret) . '</li>';
        $emailBodyHtml .= '<li><strong>Contact :</strong> ' . h($partnerName) . '</li>';
        $emailBodyHtml .= '<li><strong>Signataire :</strong> ' . h($partnerSigner) . '</li>';
        $emailBodyHtml .= '<li><strong>Email :</strong> ' . h($partnerEmail) . '</li>';
        $emailBodyHtml .= '<li><strong>Téléphone :</strong> ' . h($phone) . '</li>';
        $emailBodyHtml .= '<li><strong>Adresse :</strong> ' . h($address) . '</li>';
        $emailBodyHtml .= '<li><strong>Régime TVA :</strong> ' . h($vatRegime) . '</li>';
        if ($vatRegime === 'TVA facturée') {
            $emailBodyHtml .= '<li><strong>Taux :</strong> ' . h($vatRate) . '% | <strong>N° TVA :</strong> ' . h($vatNumber) . '</li>';
        } elseif ($vatRegime === 'Autre') {
            $emailBodyHtml .= '<li><strong>Précision TVA :</strong> ' . nl2br(h($vatOther)) . '</li>';
        }
        $emailBodyHtml .= '<li><strong>Lien professionnel :</strong> ' . h($profLink) . ' (' . h($profession) . ($employer ? ' / ' . h($employer) : '') . ')</li>';
        $emailBodyHtml .= '</ul>';
        if ($notes !== '') {
            $emailBodyHtml .= '<h3>Précisions apporteur</h3><p>' . nl2br(h($notes)) . '</p>';
        }
        $emailBodyHtml .= '<h3>Pièces justificatives (stockées hors web)</h3><ul>';
        foreach ($uploadedFiles as $k => $f) {
            $emailBodyHtml .= '<li>[' . h($k) . '] ' . h($f['original_name']) . ' (' . (int)$f['size'] . ' octets) &rarr; ' . h($f['safe_name']) . '</li>';
        }
        $emailBodyHtml .= '</ul>';
        $emailBodyHtml .= '<p><em>Note : les pièces ne sont pas jointes par email pour des raisons de conformité RGPD. Elles sont disponibles dans le stockage privé du serveur.</em></p>';

        // Version texte brut
        $emailBodyText = "Nouvelle demande de candidature au Programme Apporteurs EMS\n";
        $emailBodyText .= "========================================================\n\n";
        $emailBodyText .= "Référence : {$receiptId}\n";
        $emailBodyText .= "Date      : " . date('d/m/Y H:i:s') . "\n";
        $emailBodyText .= "Entreprise: {$company} ({$legalForm})\n";
        $emailBodyText .= "SIRET     : {$siret}\n";
        $emailBodyText .= "Contact   : {$partnerName}\n";
        $emailBodyText .= "Email     : {$partnerEmail}\n";
        $emailBodyText .= "Téléphone : {$phone}\n";
        $emailBodyText .= "Adresse   : {$address}\n";
        $emailBodyText .= "Régime TVA: {$vatRegime}\n";
        if ($notes !== '') {
            $emailBodyText .= "\nPrécisions :\n{$notes}\n";
        }

    } else {
        // ── Formulaire « Recommander un client » ────────────────────────────
        $partnerName     = cleanHeader((string)($_POST['partner_name'] ?? ''), 160);
        $partnerSiret    = cleanHeader((string)($_POST['partner_siret'] ?? ''), 14);
        $partnerEmail    = cleanEmail('partner_email');
        $partnerPhone    = cleanHeader((string)($_POST['partner_phone'] ?? ''), 30);
        $contractRef     = cleanHeader((string)($_POST['contract_reference'] ?? ''), 100);
        $clientName      = cleanHeader((string)($_POST['client_name'] ?? ''), 200);
        $clientPhone     = cleanHeader((string)($_POST['client_phone'] ?? ''), 30);
        $clientEmail     = cleanEmail('client_email');
        $siteType        = cleanHeader((string)($_POST['site_type'] ?? ''), 50);
        $address         = cleanHeader((string)($_POST['address'] ?? ''), 400);
        $postalCode      = cleanHeader((string)($_POST['postal_code'] ?? ''), 5);
        $city            = cleanHeader((string)($_POST['city'] ?? ''), 160);
        $plannedUnits    = cleanHeader((string)($_POST['planned_units'] ?? ''), 10);
        $vehicle         = cleanHeader((string)($_POST['vehicle'] ?? ''), 160);
        $need            = cleanText('need', 2000);
        $contactMethod   = cleanHeader((string)($_POST['contact_method'] ?? ''), 30);
        $consentDate     = cleanHeader((string)($_POST['consent_date'] ?? ''), 20);
        $consentEvidenceType = cleanHeader((string)($_POST['consent_evidence_type'] ?? ''), 30);
        $consent         = !empty($_POST['consent']);
        $commissionDisclosed = !empty($_POST['commission_disclosed']);
        $profLink        = cleanHeader((string)($_POST['professional_link'] ?? ''), 10);
        $infoConfirmed   = !empty($_POST['information_confirmed']);
        $checksCompleted = cleanHeader((string)($_POST['checks_completed'] ?? ''), 10);

        if ($partnerName === '' || $partnerEmail === '') {
            throw new InvalidArgumentException("Veuillez renseigner votre identité d'apporteur (nom et email valide).");
        }
        if (!preg_match('/^[0-9]{14}$/', $partnerSiret)) {
            throw new InvalidArgumentException("Votre SIRET d'apporteur doit comporter 14 chiffres.");
        }
        if ($clientName === '' || $address === '' || $postalCode === '' || $city === '') {
            throw new InvalidArgumentException("Veuillez renseigner les informations complètes du client et du chantier.");
        }
        if ($need === '') {
            throw new InvalidArgumentException("Veuillez préciser le besoin exprimé pour ce projet.");
        }

        // Contact client : téléphone ou email
        if ($clientPhone === '' && $clientEmail === '') {
            throw new InvalidArgumentException("Veuillez indiquer au moins un moyen de contact pour le client (téléphone ou email).");
        }
        if (in_array($contactMethod, ['Téléphone', 'SMS'], true) && $clientPhone === '') {
            throw new InvalidArgumentException("Le numéro de téléphone du client est obligatoire pour le moyen de contact choisi.");
        }
        if ($contactMethod === 'E-mail' && $clientEmail === '') {
            throw new InvalidArgumentException("L'adresse email du client est obligatoire pour le moyen de contact choisi.");
        }

        // Contrôle de zone
        $validZones = ['07', '11', '12', '13', '30', '31', '34', '48', '66', '81', '83'];
        $dept = substr($postalCode, 0, 2);
        $isWithinZone = in_array($dept, $validZones, true);

        // Validation consentement & loyauté
        if (!$consent) {
            throw new InvalidArgumentException("Vous devez confirmer que le client a demandé à être contacté par EMS.");
        }
        if (!$commissionDisclosed) {
            throw new InvalidArgumentException("Vous devez confirmer avoir informé le client de la commission potentielle.");
        }
        if (!$infoConfirmed) {
            throw new InvalidArgumentException("Vous devez attester sur l'honneur de la conformité et loyauté de la recommandation.");
        }
        if ($checksCompleted !== 'Oui') {
            throw new InvalidArgumentException("Vous devez confirmer avoir réalisé les vérifications requises.");
        }

        // Fichiers optionnels
        $subDir = 'referral/' . $receiptId;
        $consentUp = handleUpload('consent_evidence', false, $storageDir, $subDir, $maxFileBytes, $allowedMimes);
        if ($consentUp) $uploadedFiles['consent_evidence'] = $consentUp;

        $employerAuthUp = handleUpload('employer_authorization', false, $storageDir, $subDir, $maxFileBytes, $allowedMimes);
        if ($employerAuthUp) $uploadedFiles['employer_authorization'] = $employerAuthUp;

        $record = [
            'type'                  => 'referral',
            'receipt_id'            => $receiptId,
            'submission_id'         => cleanHeader((string)($_POST['submission_id'] ?? ''), 100),
            'model_version'         => cleanHeader((string)($_POST['model_version'] ?? ''), 10),
            'created_at'            => date('c'),
            'ip'                    => $clientIp,
            'partner_name'          => $partnerName,
            'partner_siret'         => $partnerSiret,
            'partner_email'         => $partnerEmail,
            'partner_phone'         => $partnerPhone,
            'contract_reference'    => $contractRef,
            'client_name'           => $clientName,
            'client_phone'          => $clientPhone,
            'client_email'          => $clientEmail,
            'site_type'             => $siteType,
            'address'               => $address,
            'postal_code'           => $postalCode,
            'city'                  => $city,
            'in_contract_zone'      => $isWithinZone,
            'planned_units'         => $plannedUnits,
            'vehicle'               => $vehicle,
            'need'                  => $need,
            'contact_method'        => $contactMethod,
            'consent_date'          => $consentDate,
            'consent_evidence_type' => $consentEvidenceType,
            'professional_link'     => $profLink,
            'documents'             => $uploadedFiles,
        ];

        $zoneAlert = $isWithinZone ? "OUI ({$dept})" : "HORS ZONE ({$dept}) — À examiner";
        $emailSubject = cleanHeader("[Recommandation EMS] Nouveau projet client — {$clientName} ({$receiptId})");

        // Version HTML
        $emailBodyHtml = '<h2>Nouvelle présentation de projet client par un apporteur d\'affaires EMS</h2>';
        $emailBodyHtml .= '<p><strong>Référence dossier :</strong> ' . h($receiptId) . '<br>';
        $emailBodyHtml .= '<strong>Date :</strong> ' . date('d/m/Y H:i:s') . '</p>';
        $emailBodyHtml .= '<hr><h3>Apporteur</h3><ul>';
        $emailBodyHtml .= '<li><strong>Nom :</strong> ' . h($partnerName) . '</li>';
        $emailBodyHtml .= '<li><strong>SIRET :</strong> ' . h($partnerSiret) . ' | <strong>Réf contrat :</strong> ' . h($contractRef ?: 'Non renseignée') . '</li>';
        $emailBodyHtml .= '<li><strong>Email :</strong> ' . h($partnerEmail) . ' | <strong>Tél :</strong> ' . h($partnerPhone ?: 'Non renseigné') . '</li>';
        $emailBodyHtml .= '</ul>';
        $emailBodyHtml .= '<h3>Projet Client</h3><ul>';
        $emailBodyHtml .= '<li><strong>Client :</strong> ' . h($clientName) . '</li>';
        $emailBodyHtml .= '<li><strong>Téléphone client :</strong> ' . h($clientPhone ?: 'Non renseigné') . '</li>';
        $emailBodyHtml .= '<li><strong>Email client :</strong> ' . h($clientEmail ?: 'Non renseigné') . '</li>';
        $emailBodyHtml .= '<li><strong>Type de site :</strong> ' . h($siteType) . '</li>';
        $emailBodyHtml .= '<li><strong>Lieu du chantier :</strong> ' . h($address) . ', ' . h($postalCode) . ' ' . h($city) . '</li>';
        $emailBodyHtml .= '<li><strong>Zone contractuelle :</strong> ' . h($zoneAlert) . '</li>';
        $emailBodyHtml .= '<li><strong>Unités prévues :</strong> ' . h($plannedUnits ?: '1') . ' | <strong>Véhicule :</strong> ' . h($vehicle ?: 'Non précisé') . '</li>';
        $emailBodyHtml .= '<li><strong>Moyen de contact souhaité :</strong> ' . h($contactMethod) . ' (Accord du ' . h($consentDate) . ', preuve : ' . h($consentEvidenceType) . ')</li>';
        $emailBodyHtml .= '<li><strong>Lien professionnel :</strong> ' . h($profLink) . '</li>';
        $emailBodyHtml .= '</ul>';
        $emailBodyHtml .= '<h3>Besoin exprimé</h3><p>' . nl2br(h($need)) . '</p>';
        if (!empty($uploadedFiles)) {
            $emailBodyHtml .= '<h3>Pièces jointes stockées sur le serveur privé</h3><ul>';
            foreach ($uploadedFiles as $k => $f) {
                $emailBodyHtml .= '<li>[' . h($k) . '] ' . h($f['original_name']) . ' &rarr; ' . h($f['safe_name']) . '</li>';
            }
            $emailBodyHtml .= '</ul>';
        }

        // Version texte brut
        $emailBodyText = "Nouvelle présentation de projet client par un apporteur d'affaires EMS\n";
        $emailBodyText .= "===================================================================\n\n";
        $emailBodyText .= "Référence : {$receiptId}\n";
        $emailBodyText .= "Apporteur : {$partnerName} (SIRET : {$partnerSiret})\n";
        $emailBodyText .= "Client    : {$clientName} ({$postalCode} {$city})\n";
        $emailBodyText .= "Contact   : {$contactMethod}\n";
        $emailBodyText .= "Zone      : {$zoneAlert}\n\n";
        $emailBodyText .= "Besoin :\n{$need}\n";
    }

    // ── 9. Sauvegarde du récapitulatif JSON local ────────────────────────────
    $logDir = $storageDir . '/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0750, true);
    }
    $logFile = $logDir . '/' . date('Y-m') . '-submissions.jsonl';
    @file_put_contents($logFile, json_encode($record, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);

    // ── 10. Envoi de l'email via SMTP PHPMailer (AUCUN repli silencieux) ─────
    $adminTo = cleanHeader((string)($config['notification_email'] ?? 'contact@energeticmaintenances.fr'));
    $fromMail = cleanHeader((string)($config['mail_from'] ?? 'contact@energeticmaintenances.fr'));
    $fromName = cleanHeader((string)($config['mail_from_name'] ?? 'EMS Programme Apporteurs'));

    $smtpEnabled = !empty($config['smtp']['enabled']);
    $smtpPassword = (string)($config['smtp']['password'] ?? '');

    // Journalisation d'erreur dédiée
    $errorLogFile = $logDir . '/smtp_errors.log';

    if (!$smtpEnabled || $smtpPassword === '') {
        $msg = "[EMS Apporteurs] Configuration SMTP manquante ou désactivée sur le serveur. Impossible d'expédier le dossier {$receiptId}.";
        error_log($msg);
        @file_put_contents($errorLogFile, '[' . date('c') . '] ' . $msg . "\n", FILE_APPEND | LOCK_EX);
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error'   => "Le service d'envoi d'e-mail n'est pas encore configuré sur le serveur (identifiants SMTP requis). Veuillez contacter EMS directement.",
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $mailer = new PHPMailer(true);
        $mailer->isSMTP();
        $mailer->Host       = cleanHeader((string)($config['smtp']['host'] ?? 'smtp-relay.brevo.com'));
        $mailer->SMTPAuth   = true;
        $mailer->Username   = cleanHeader((string)($config['smtp']['username'] ?? ''));
        $mailer->Password   = $smtpPassword;
        $mailer->SMTPSecure = ($config['smtp']['encryption'] ?? 'tls') === 'ssl'
            ? PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port       = (int)($config['smtp']['port'] ?? 587);
        $mailer->CharSet    = 'UTF-8';
        $mailer->Timeout    = 15;

        $mailer->setFrom($fromMail, $fromName);
        $mailer->addAddress($adminTo);
        if ($partnerEmail !== '') {
            $mailer->addReplyTo($partnerEmail, $partnerName);
        }

        $mailer->isHTML(true);
        $mailer->Subject = $emailSubject;
        $mailer->Body    = $emailBodyHtml;
        $mailer->AltBody = $emailBodyText;

        $mailer->send();

        // Envoi d'un email de confirmation au partenaire
        if ($partnerEmail !== '') {
            try {
                $confirmMailer = clone $mailer;
                $confirmMailer->clearAddresses();
                $confirmMailer->clearReplyTos();
                $confirmMailer->addAddress($partnerEmail, $partnerName);
                $confirmMailer->addReplyTo($adminTo, 'EMS Service Apporteurs');
                $confirmMailer->Subject = cleanHeader("[EMS] Accusé de réception de votre demande — {$receiptId}");
                $confirmMailer->isHTML(true);
                $confirmMailer->Body    = "<p>Bonjour " . h($partnerName) . ",</p>"
                    . "<p>Nous confirmons la bonne réception de votre demande auprès d'<strong>Energetic Maintenances Services</strong>.</p>"
                    . "<p><strong>Référence de votre dossier :</strong> " . h($receiptId) . "</p>"
                    . "<p>Notre équipe étudie vos éléments et reviendra vers vous par écrit sous 7 jours calendaires conformément aux modalités du contrat.</p>"
                    . "<p>Cordialement,<br><strong>L'équipe Energetic Maintenances Services</strong><br><a href=\"https://energeticmaintenances.fr\">energeticmaintenances.fr</a></p>";
                $confirmMailer->AltBody = "Bonjour {$partnerName},\n\nNous confirmons la bonne réception de votre demande auprès d'Energetic Maintenances Services.\nRéférence : {$receiptId}\n\nNous reviendrons vers vous par écrit sous 7 jours calendaires.\n\nEMS — energeticmaintenances.fr\n";
                $confirmMailer->send();
            } catch (\Throwable $confirmEx) {
                error_log("[EMS Apporteurs] Avertissement: échec de l'accusé de réception partenaire : " . $confirmEx->getMessage());
            }
        }
    } catch (\Throwable $smtpEx) {
        $errorMsg = "[EMS Apporteurs] Échec SMTP fatal pour le dossier {$receiptId} : " . $smtpEx->getMessage();
        error_log($errorMsg);
        @file_put_contents($errorLogFile, '[' . date('c') . '] ' . $errorMsg . "\n", FILE_APPEND | LOCK_EX);

        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error'   => "L'envoi sécurisé de votre notification a échoué via le serveur SMTP. Votre dossier n'a pas été transmis. Merci de contacter directement EMS.",
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ── 11. Réponse JSON de succès ───────────────────────────────────────────
    echo json_encode([
        'success'    => true,
        'receipt_id' => $receiptId,
    ], JSON_UNESCAPED_UNICODE);
    exit;

} catch (InvalidArgumentException $e) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
    exit;
} catch (\Throwable $e) {
    error_log("[EMS Apporteurs] Erreur serveur générale : " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => "Une erreur interne est survenue lors de l'enregistrement de votre demande. Veuillez réessayer ou contacter EMS par téléphone.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
