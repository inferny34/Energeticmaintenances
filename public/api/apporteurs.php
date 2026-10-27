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
        'enabled'  => false,
        'host'     => 'smtp-relay.brevo.com',
        'port'     => 587,
        'username' => '',
        'password' => '',
        'encryption' => 'tls',
    ],
    'composer_autoload'  => dirname(dirname(__DIR__)) . '/vendor/autoload.php',
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

// Répertoire privé pour les fichiers et logs (hors public_html)
$storageDir = rtrim($config['storage_dir'], '/\\');
if (!is_dir($storageDir)) {
    @mkdir($storageDir, 0750, true);
}

// ── 5. Limitation de débit par IP (Rate Limiting) ───────────────────────────
$clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$rateLimitFile = $storageDir . '/rate_limits.json';
$maxRequests = (int)($config['rate_limit']['max_requests'] ?? 5);
$windowSeconds = (int)($config['rate_limit']['window_seconds'] ?? 3600);
$now = time();

$rateLimits = [];
if (file_exists($rateLimitFile)) {
    $raw = @file_get_contents($rateLimitFile);
    if ($raw) {
        $rateLimits = json_decode($raw, true) ?: [];
    }
}

// Nettoyage des anciennes IP
foreach ($rateLimits as $ip => $data) {
    if ($now - $data['start'] > $windowSeconds) {
        unset($rateLimits[$ip]);
    }
}

if (!isset($rateLimits[$clientIp])) {
    $rateLimits[$clientIp] = ['start' => $now, 'count' => 1];
} else {
    $rateLimits[$clientIp]['count']++;
    if ($rateLimits[$clientIp]['count'] > $maxRequests) {
        http_response_code(429);
        echo json_encode([
            'success' => false,
            'error'   => 'Trop de demandes envoyées depuis cette adresse IP. Veuillez patienter avant de renouveler l’opération.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
@file_put_contents($rateLimitFile, json_encode($rateLimits), LOCK_EX);

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

// ── 7. Helpers de validation et fichiers ─────────────────────────────────────
function clean(string $key, int $maxLen = 500): string {
    $val = $_POST[$key] ?? '';
    if (!is_string($val)) return '';
    $val = trim(strip_tags($val));
    return mb_substr($val, 0, $maxLen, 'UTF-8');
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
 * Valide et enregistre un fichier uploadé dans le dossier privé
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

    $origName = $file['name'] ?? 'document';
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

    if (!in_array($realMime, array_values($allowedMimes), true)) {
        // Tolérance pour .eml (preuvé de contact) si formulaire referral
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
$emailBody = '';
$partnerEmail = '';
$partnerName = '';

try {
    if ($formType === 'registration') {
        // ── Formulaire « Devenir apporteur » ────────────────────────────────
        $partnerName     = clean('partner_name', 160);
        $partnerEmail    = filter_var(clean('email', 254), FILTER_VALIDATE_EMAIL) ?: '';
        $phone           = clean('phone', 30);
        $address         = clean('address', 400);
        $company         = clean('company', 200);
        $legalForm       = clean('legal_form', 100);
        $siret           = clean('siret', 14);
        $partnerSigner   = clean('partner_signer', 160);
        $vatRegime       = clean('vat_regime', 50);
        $vatEffectiveAt  = clean('vat_effective_at', 20);
        $vatRate         = clean('vat_rate', 10);
        $vatNumber       = clean('vat_number', 40);
        $vatOther        = clean('vat_other', 1000);
        $profLink        = clean('professional_link', 10);
        $profession      = clean('profession', 160);
        $employer        = clean('employer', 200);
        $notes           = clean('notes', 2000);
        $contractRead    = !empty($_POST['contract_read']);
        $checksCompleted = clean('checks_completed', 10);

        // Validations obligatoires
        if ($partnerName === '' || $partnerEmail === '' || $phone === '' || $address === '') {
            throw new InvalidArgumentException("Veuillez renseigner vos coordonnées complètes (nom, email, téléphone, adresse).");
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
            'submission_id'     => clean('submission_id', 100),
            'model_version'     => clean('model_version', 10),
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

        $emailSubject = "[Apporteur EMS] Nouvelle candidature d'apporteur — {$company} ({$receiptId})";
        $emailBody = "Nouvelle demande de candidature au Programme Apporteurs EMS\n";
        $emailBody .= "========================================================\n\n";
        $emailBody .= "Référence dossier : {$receiptId}\n";
        $emailBody .= "Date              : " . date('d/m/Y H:i:s') . "\n";
        $emailBody .= "Entreprise        : {$company} ({$legalForm})\n";
        $emailBody .= "SIRET             : {$siret}\n";
        $emailBody .= "Contact           : {$partnerName}\n";
        $emailBody .= "Signataire        : {$partnerSigner}\n";
        $emailBody .= "Email             : {$partnerEmail}\n";
        $emailBody .= "Téléphone         : {$phone}\n";
        $emailBody .= "Adresse           : {$address}\n";
        $emailBody .= "Régime TVA        : {$vatRegime}\n";
        if ($vatRegime === 'TVA facturée') {
            $emailBody .= "  -> Taux : {$vatRate} % | N° TVA : {$vatNumber}\n";
        } elseif ($vatRegime === 'Autre') {
            $emailBody .= "  -> Précision : {$vatOther}\n";
        }
        $emailBody .= "Lien professionnel: {$profLink} (Métier : {$profession}" . ($employer ? " / Employeur : {$employer}" : "") . ")\n\n";
        if ($notes !== '') {
            $emailBody .= "Notes apporteur   :\n{$notes}\n\n";
        }
        $emailBody .= "Pièces justificatives jointes (stockées sur le serveur privé) :\n";
        foreach ($uploadedFiles as $k => $f) {
            $emailBody .= " - [{$k}] {$f['original_name']} ({$f['size']} octets) -> {$f['safe_name']}\n";
        }
        $emailBody .= "\nNote de sécurité : Les pièces sensibles ne sont pas envoyées par email pour des raisons de confidentialité RGPD. Elles sont archivées dans le dossier sécurisé du compte o2switch.\n";

    } else {
        // ── Formulaire « Recommander un client » ────────────────────────────
        $partnerName     = clean('partner_name', 160);
        $partnerSiret    = clean('partner_siret', 14);
        $partnerEmail    = filter_var(clean('partner_email', 254), FILTER_VALIDATE_EMAIL) ?: '';
        $partnerPhone    = clean('partner_phone', 30);
        $contractRef     = clean('contract_reference', 100);
        $clientName      = clean('client_name', 200);
        $clientPhone     = clean('client_phone', 30);
        $clientEmail     = clean('client_email', 254);
        $siteType        = clean('site_type', 50);
        $address         = clean('address', 400);
        $postalCode      = clean('postal_code', 5);
        $city            = clean('city', 160);
        $plannedUnits    = clean('planned_units', 10);
        $vehicle         = clean('vehicle', 160);
        $need            = clean('need', 2000);
        $contactMethod   = clean('contact_method', 30);
        $consentDate     = clean('consent_date', 20);
        $consentEvidenceType = clean('consent_evidence_type', 30);
        $consent         = !empty($_POST['consent']);
        $commissionDisclosed = !empty($_POST['commission_disclosed']);
        $profLink        = clean('professional_link', 10);
        $infoConfirmed   = !empty($_POST['information_confirmed']);
        $checksCompleted = clean('checks_completed', 10);

        if ($partnerName === '' || $partnerEmail === '') {
            throw new InvalidArgumentException("Veuillez renseigner votre identité d'apporteur (nom et email).");
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
            'submission_id'         => clean('submission_id', 100),
            'model_version'         => clean('model_version', 10),
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
        $emailSubject = "[Recommandation EMS] Nouveau projet client — {$clientName} ({$receiptId})";
        $emailBody = "Nouvelle présentation de projet client par un apporteur d'affaires EMS\n";
        $emailBody .= "===================================================================\n\n";
        $emailBody .= "Référence dossier : {$receiptId}\n";
        $emailBody .= "Date              : " . date('d/m/Y H:i:s') . "\n";
        $emailBody .= "Apporteur         : {$partnerName} (SIRET : {$partnerSiret} / Réf contrat : " . ($contractRef ?: 'Non renseignée') . ")\n";
        $emailBody .= "Email apporteur   : {$partnerEmail}\n";
        $emailBody .= "Tél apporteur     : " . ($partnerPhone ?: 'Non renseigné') . "\n\n";
        $emailBody .= "Client présenté   : {$clientName}\n";
        $emailBody .= "Téléphone client  : " . ($clientPhone ?: 'Non renseigné') . "\n";
        $emailBody .= "Email client      : " . ($clientEmail ?: 'Non renseigné') . "\n";
        $emailBody .= "Type de site      : {$siteType}\n";
        $emailBody .= "Lieu du chantier  : {$address}, {$postalCode} {$city}\n";
        $emailBody .= "Zone contractuelle: {$zoneAlert}\n";
        $emailBody .= "Unités prévues    : " . ($plannedUnits ?: '1') . " | Véhicule : " . ($vehicle ?: 'Non précisé') . "\n";
        $emailBody .= "Besoin exprimé    :\n{$need}\n\n";
        $emailBody .= "Moyen de contact  : {$contactMethod} (Accord client du {$consentDate}, preuve : {$consentEvidenceType})\n";
        $emailBody .= "Lien professionnel: {$profLink}\n";
        if (!empty($uploadedFiles)) {
            $emailBody .= "\nPièces jointes stockées sur le serveur privé :\n";
            foreach ($uploadedFiles as $k => $f) {
                $emailBody .= " - [{$k}] {$f['original_name']} -> {$f['safe_name']}\n";
            }
        }
    }

    // ── 9. Sauvegarde du récapitulatif JSON local ────────────────────────────
    $logDir = $storageDir . '/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0750, true);
    }
    $logFile = $logDir . '/' . date('Y-m') . '-submissions.jsonl';
    @file_put_contents($logFile, json_encode($record, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);

    // ── 10. Envoi de l'email via SMTP Brevo (PHPMailer) ou mail() ────────────
    $mailSent = false;
    $adminTo = $config['notification_email'] ?? 'contact@energeticmaintenances.fr';
    $fromMail = $config['mail_from'] ?? 'contact@energeticmaintenances.fr';
    $fromName = $config['mail_from_name'] ?? 'EMS Programme Apporteurs';

    // Vérifier si l'autoloader Composer existe pour charger PHPMailer
    $composerAutoload = $config['composer_autoload'] ?? '';
    if ($composerAutoload !== '' && file_exists($composerAutoload)) {
        require_once $composerAutoload;
    }

    $smtpEnabled = !empty($config['smtp']['enabled']) && !empty($config['smtp']['password']);

    if ($smtpEnabled && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        try {
            $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host       = $config['smtp']['host'] ?? 'smtp-relay.brevo.com';
            $mailer->SMTPAuth   = true;
            $mailer->Username   = $config['smtp']['username'] ?? '';
            $mailer->Password   = $config['smtp']['password'] ?? '';
            $mailer->SMTPSecure = ($config['smtp']['encryption'] ?? 'tls') === 'ssl'
                ? \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
                : \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mailer->Port       = (int)($config['smtp']['port'] ?? 587);
            $mailer->CharSet    = 'UTF-8';

            $mailer->setFrom($fromMail, $fromName);
            $mailer->addAddress($adminTo);
            if ($partnerEmail !== '') {
                $mailer->addReplyTo($partnerEmail, $partnerName);
            }
            $mailer->Subject = $emailSubject;
            $mailer->Body    = $emailBody;

            $mailer->send();
            $mailSent = true;

            // Envoi d'un email de confirmation au partenaire
            if ($partnerEmail !== '') {
                $confirmMailer = clone $mailer;
                $confirmMailer->clearAddresses();
                $confirmMailer->clearReplyTos();
                $confirmMailer->addAddress($partnerEmail, $partnerName);
                $confirmMailer->addReplyTo($adminTo, 'EMS Service Apporteurs');
                $confirmMailer->Subject = "[EMS] Accusé de réception de votre demande — {$receiptId}";
                $confirmMailer->Body    = "Bonjour {$partnerName},\n\nNous confirmons la bonne réception de votre demande auprès d'Energetic Maintenances Services.\n\nRéférence de votre dossier : {$receiptId}\n\nNotre équipe étudie vos éléments et reviendra vers vous par écrit sous 7 jours calendaires conformément aux modalités du contrat.\n\nCordialement,\nL'équipe Energetic Maintenances Services\nhttps://energeticmaintenances.fr\n";
                @$confirmMailer->send();
            }
        } catch (\Throwable $e) {
            error_log("[EMS Apporteurs] Erreur SMTP PHPMailer : " . $e->getMessage());
        }
    }

    // Fallback natif mail() si SMTP non configuré ou échec PHPMailer
    if (!$mailSent) {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";
        $headers .= "From: {$fromName} <{$fromMail}>\r\n";
        if ($partnerEmail !== '') {
            $headers .= "Reply-To: {$partnerName} <{$partnerEmail}>\r\n";
        }
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        $encodedSubject = '=?UTF-8?B?' . base64_encode($emailSubject) . '?=';
        $mailSent = @mail($adminTo, $encodedSubject, $emailBody, $headers);

        // Accusé partenaire
        if ($mailSent && $partnerEmail !== '') {
            $confirmSubj = '=?UTF-8?B?' . base64_encode("[EMS] Accusé de réception — {$receiptId}") . '?=';
            $confirmBody = "Bonjour {$partnerName},\n\nNous confirmons la bonne réception de votre demande auprès d'EMS (Réf : {$receiptId}).\nNous reviendrons vers vous sous 7 jours calendaires.\n\nEMS — energeticmaintenances.fr\n";
            $confirmHeaders = "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\nFrom: {$fromName} <{$fromMail}>\r\nReply-To: {$adminTo}\r\n";
            @mail($partnerEmail, $confirmSubj, $confirmBody, $confirmHeaders);
        }
    }

    // ── 11. Réponse JSON finale ──────────────────────────────────────────────
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
    error_log("[EMS Apporteurs] Erreur serveur : " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => "Une erreur interne est survenue lors de l'enregistrement de votre demande. Veuillez réessayer ou contacter EMS par téléphone.",
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
