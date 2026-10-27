<?php
/**
 * config.example.php — Modèle de configuration pour l'API Apporteurs EMS
 *
 * À copier sur le serveur o2switch dans un dossier HORS DE public_html :
 *   Exemple : /home/moncompte/apporteurs_config.php
 *
 * Ce fichier NE DOIT JAMAIS être versionné ni placé dans public_html.
 */

return [
    // Destinataire principal des notifications internes
    'notification_email' => 'contact@energeticmaintenances.fr',

    // Expéditeur des emails envoyés par le serveur
    'mail_from' => 'contact@energeticmaintenances.fr',
    'mail_from_name' => 'EMS Programme Apporteurs',

    // Dossier privé de stockage des justificatifs et uploads sensibles (HORS de public_html)
    // Par défaut, si vide : /home/<user>/apporteurs_data
    'storage_dir' => dirname(__DIR__) . '/apporteurs_data',

    // Configuration SMTP Brevo (recommandé sur o2switch pour éviter le blacklistage d'IP partagée)
    'smtp' => [
        'enabled'  => true,
        'host'     => 'smtp-relay.brevo.com',
        'port'     => 587,
        'username' => 'votre-login-brevo@domaine.com',
        'password' => 'votre-cle-smtp-master-brevo',
        'encryption' => 'tls', // 'tls' ou 'ssl'
    ],

    // Chemin vers l'autoloader Composer si PHPMailer est installé (facultatif)
    'composer_autoload' => dirname(__DIR__) . '/vendor/autoload.php',

    // Limitation de débit (anti-spam) : nombre max de requêtes par IP par fenêtre de temps (en secondes)
    'rate_limit' => [
        'max_requests' => 5,
        'window_seconds' => 3600, // 1 heure
    ],
];
