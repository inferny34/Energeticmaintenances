# Mission : intégrer la page « Programme apporteurs » dans le site EMS (Vue 3)

## Contexte
- Projet : Vue 3 + Vite + Tailwind CSS, site one-page avec ancres, hébergé sur o2switch.
- Déploiement : GitHub Actions (build Vite) puis FTP vers `/public_html/`, branche `master`.
- Contrainte forte : garder les scores PageSpeed actuels (Perf 99-100, Accessibilité ≥ 96, Bonnes pratiques 100, SEO 100). Aucun nouveau domaine externe, aucune police/CDN externe.
- Le bouton « Nous recommander un projet » se trouve dans `ParrainageSection.vue`. Il doit mener à une **nouvelle page** (route dédiée), comme le font déjà les pages mentions légales et politique de confidentialité.
- Le client a fourni une page HTML de démonstration (prototype). Elle a été **découpée et allégée** dans le dossier `migration-apporteurs/` (à la racine du repo). Le fichier d'origine pesait 10 Mo à cause de blobs base64 : ne le demande pas, tout ce qui est utile est déjà extrait.

## Fichiers fournis (`migration-apporteurs/`)
- `source/page-sections.html` : le contenu de la page (hero, comment ça marche, conditions + zone, mini-guide micro-entreprise, formulaires, FAQ) + le `<dialog>` du lecteur de contrat. Le masthead et le footer du prototype ont été retirés exprès (le site a les siens).
- `source/styles.original.css` : les 7 blocs `<style>` du prototype concaténés, **dans l'ordre**, avec beaucoup de surcharges et de CSS mort. C'est une référence visuelle, à ne PAS recopier tel quel.
- `source/app.main.js` : logique principale (lecteur de contrat, validation, champs conditionnels, zone par code postal, soumission). Une IIFE qui utilise `window.EMS_CONFIG` / `window.EMS_CONTRACT`.
- `source/app.journey.js` : onglets « Devenir apporteur » / « Je recommande un client », compteur de pièces, saut vers l'engagement de loyauté.
- `source/contract-pages.json` : 12 pages du contrat (`image` vers `/contrat/...webp` + `text` pour l'accessibilité).
- `public/contrat/` : 12 pages WebP du contrat + `contrat-apporteur-ems-v8.pdf`. À copier dans `public/contrat/` du projet.
- `reference/` : pages légales de démonstration (placeholders). Ne pas les utiliser : le projet a déjà ses vraies pages.

## Étape 0 : explorer avant de coder
Lis le projet et résume en ~10 lignes tes constats et ton plan avant de modifier quoi que ce soit : routeur (est-ce que `vue-router` est installé ? mode history ou hash ?), pages légales existantes et leurs chemins, layout global (header/footer), config Tailwind (couleurs), gestion des `<title>`/meta (unhead ou autre), comportement actuel du bouton dans `ParrainageSection.vue`, gestion des ancres `/#...` depuis une autre page.
Travaille sur une branche `feat/apporteurs`. **Ne merge pas et ne push pas sur `master`** (le push déclenche un déploiement en production). Un commit par étape.

## Étape 1 : route et navigation
1. Ajoute la route `/apporteurs` en chargement paresseux : `component: () => import('../views/ApporteursView.vue')`.
2. Dans `ParrainageSection.vue`, le bouton « Nous recommander un projet » devient un `RouterLink` vers `/apporteurs#recommander`.
3. Ajoute (ou complète) `scrollBehavior` du routeur pour gérer les hash (`#recommander`, `#devenir`, `#guide-micro`, `#lecture-contrat`) avec offset du header fixe éventuel et `prefers-reduced-motion`.
4. Vérifie que les liens d'ancre du header du site (`#contact`, etc.) fonctionnent aussi depuis `/apporteurs` (retour vers `/#ancre`).
5. Les liens « mentions légales » et « politique de confidentialité » du prototype pointent vers les vraies routes du projet (via `RouterLink`).

## Étape 2 : découpage en composants Vue
Crée `src/views/ApporteursView.vue` et des composants dans `src/components/apporteurs/` : `ApporteursHero`, `ApporteursSteps`, `ApporteursConditions` (conditions + zone), `MicroGuide`, `JourneyTabs`, `RegistrationForm`, `ReferralForm`, `ContractReader`, `ApporteursFaq`.
- Composables : `useConditionalFields` (le `updateConditions` du prototype), `useFormSubmit` (la soumission), et `src/constants/zones.js` comme **source unique** des départements (les puces d'affichage ET le contrôle du code postal en dérivent).
- Porte la logique de `app.main.js` / `app.journey.js` en idiomes Vue (refs, `onMounted`, etc.) **sans la réécrire de zéro** : le comportement doit rester identique. Les textes (métier, juridique, contractuel) ne doivent PAS être modifiés ni reformulés.
- Un seul `<h1>` sur la page. Remplace les ids auto-générés du genre `registration-form-21` par `useId()` ou des ids stables. Pas d'ids dupliqués.

### Comportements à conserver à l'identique
- Champs conditionnels : un `fieldset[data-condition]` masqué est aussi `disabled` (donc non envoyé).
- `checkClientContact` (au moins un contact client ; téléphone requis si méthode Téléphone/SMS ; e-mail requis si méthode E-mail).
- Inscription : les 4 pièces (`rib`, `registration_proof`, `vigilance_proof`, `vat_proof`) sont obligatoires ; limite 10 Mo par fichier ; compteur « n / 4 pièces jointes ».
- Retour sur le code postal : message dans/hors zone (voir `zones`), champs date avec `max` = aujourd'hui.
- Soumission : `submission_id` (UUID) conservé tant que le formulaire n'est pas modifié, bouton désactivé + `aria-busy` pendant l'envoi, succès affiché **uniquement** si le serveur répond `{success:true, receipt_id:"..."}` ; sinon message d'erreur et champs conservés. L'endpoint doit être en même origine et en https.
- Honeypot : champ `website` masqué hors écran.
- Accessibilité : onglets ARIA avec flèches / Début / Fin, gestion du focus, `<dialog>` natif pour le lecteur de contrat (clic hors zone, Échap, flèches gauche/droite, swipe tactile), `prefers-reduced-motion`.

## Étape 3 : styles
- Convertis en classes Tailwind avec les couleurs du site. Si la palette du prototype (marine `#102c46`, vert `#78c936`, vert foncé `#397522`) n'a pas d'équivalent dans le thème, ajoute-la au thème Tailwind (`ems-navy`, `ems-green`...) plutôt que de la coder en dur partout.
- Ne recopie pas `styles.original.css`. Supprime le CSS mort : tout `#contract-viewer*`, `.viewer-*`, `.contract-pages*`, `.price`, les doublons de `.reward`, `.steps`, etc. Plus de `!important` sauf nécessité justifiée.
- Aucun texte sous 12 px (le prototype descend à 8-10 px à plusieurs endroits : à corriger). Conserve les `:focus-visible`, le responsive (mobile d'abord) et un style d'impression minimal.

## Étape 4 : nettoyage du mode « aperçu »
Supprime : la bannière `#preview-notice`, `window.EMS_CONFIG`, `isPreview`, `previewURL`, `window.EMS_PREVIEW_*`, et la page `imprimer-contrat.html` (remplace ce lien par l'ouverture du PDF `/contrat/contrat-apporteur-ems-v8.pdf` dans un nouvel onglet). La configuration (endpoints, taille max) passe par `src/config/apporteurs.js` ou `import.meta.env`.

## Étape 5 : lecteur de contrat et assets
- `ContractReader` ne charge les images WebP **qu'à l'ouverture** du lecteur (la page suivante en `preload` léger). Le JSON de textes est importé dynamiquement (`import('../data/contract-pages.json')`).
- Copie `migration-apporteurs/public/contrat/*` vers `public/contrat/` et `source/contract-pages.json` vers `src/data/`.
- Pas de base64 dans le code, aucune image inline lourde.

## Étape 6 : backend PHP (o2switch)
Crée `public/api/apporteurs.php` (copié tel quel dans `dist/` par Vite). Un seul endpoint, paramètre `form` = `registration` | `referral`, POST multipart, réponse JSON `{success:true, receipt_id:"EMS-AAAAMMJJ-XXXXXX"}` ou `{success:false, error:"..."}` avec un code HTTP adapté.
- Validation **côté serveur** de tous les champs (reprends les noms de champs et les `required`/`pattern` du HTML fourni), y compris le contrôle de zone par code postal (même liste que `zones.js`).
- Pièces jointes : max 10 Mo chacune, extensions pdf/jpg/jpeg/png, vérification du vrai type MIME (`finfo`), noms de fichiers aléatoires.
- Anti-abus : honeypot `website`, vérification `Origin`/`Host`, limitation de débit par IP (fichier simple), taille max de requête.
- Stockage : les pièces sont des données sensibles (RIB, attestations). Elles sont rangées **hors de `public_html`** (dossier privé du compte), jamais servies par le web et jamais envoyées en pièces jointes. L'e-mail de notification contient le récapitulatif et le `receipt_id`.
- E-mail : envoi via SMTP Brevo avec PHPMailer (le serveur partagé a déjà eu une IP blacklistée). Identifiants dans un fichier de config **hors repo et hors `public_html`** (ajouter au `.gitignore` un exemple `config.example.php`). Destinataire : `contact@energeticmaintenances.fr`. Confirmation envoyée au partenaire seulement si l'enregistrement a réussi.
- Le déploiement FTP ne doit pas écraser la config serveur : indique clairement ce qu'il faut créer à la main sur o2switch.
- Ajoute un `.htaccess` dans `public/api/` (pas de listing, PHP uniquement pour `apporteurs.php`).

## Étape 7 : SEO / méta
- Titre et description propres à la page via le mécanisme déjà utilisé dans le projet.
- Par défaut : `noindex,nofollow` et **pas d'ajout au sitemap** tant que le client n'a pas décidé. Mets cette décision dans un seul endroit facile à changer (meta de route ou constante) avec un commentaire `TODO client`.

## Étape 8 : points à signaler sans les trancher
- **Zones d'intervention** : le contrat et le prototype listent 11 départements (07, 11, 12, 13, 30, 31, 34, 48, 66, 81, 83) alors que le reste du site en liste 12 (dont 84 et 09, sans le 83). Garde la liste du prototype/contrat dans `zones.js` avec un commentaire `TODO client : à valider`, et liste l'écart dans ton compte rendu.
- **RGPD** : liste ce que la politique de confidentialité devra couvrir pour ces formulaires (données collectées, pièces justificatives, finalité, durée de conservation, destinataires). Ne rédige pas le texte juridique : fais une liste de points à faire valider.

## Vérifications avant de me rendre la main
- `npm run build` sans erreur ni warning bloquant ; poids du chunk de `ApporteursView` indiqué.
- Test manuel à décrire : les 2 parcours (onglets, champs conditionnels, 4 pièces obligatoires, fichier > 10 Mo refusé, zone hors/dans zone, double envoi impossible), lecteur de contrat (souris, clavier, tactile), navigation `/` → `/apporteurs#recommander` → retour.
- Lighthouse mobile sur `/` et `/apporteurs` : indique les scores avant/après pour la home (elle ne doit pas régresser).
- Compte rendu final : fichiers créés/modifiés, points `TODO client`, ce qu'il faut configurer à la main sur o2switch.
