/**
 * Configuration du module apporteurs.
 * Les endpoints sont lus depuis les variables d'environnement Vite
 * (définies dans .env.local sur le serveur, jamais commitées).
 *
 * Sur o2switch : créer public/api/apporteurs.php (voir Étape 6).
 * L'endpoint doit être en HTTPS et en même origine.
 */
export const APPORTEURS_CONFIG = {
  /** Endpoint POST multipart pour l'inscription (formulaire "Devenir apporteur") */
  registrationEndpoint: import.meta.env.VITE_APPORTEURS_REGISTRATION_ENDPOINT || '/api/apporteurs.php?form=registration',

  /** Endpoint POST multipart pour la recommandation (formulaire "Recommander un client") */
  referralEndpoint: import.meta.env.VITE_APPORTEURS_REFERRAL_ENDPOINT || '/api/apporteurs.php?form=referral',

  /** Taille max par fichier (10 Mo) */
  maxFileBytes: 10 * 1024 * 1024,

  /** Version du contrat */
  contractVersion: 'V8',
  contractDate: '27/10/2026',

  /** Identifiant de version de formulaire transmis au serveur */
  formVersion: 'EMS-WEB-PRO-CONTRAT-8',
}
