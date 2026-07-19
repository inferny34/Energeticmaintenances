<script setup>
// Pas de logique spécifique
</script>

<template>
  <section class="py-28 bg-ems-dark text-ems-text font-body" aria-labelledby="privacy-title">
    <div class="max-w-4xl mx-auto px-6">
      
      <!-- Back button -->
      <a href="#" class="inline-flex items-center gap-2 text-ems-green hover:text-white transition-colors duration-200 mb-8 text-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour à l'accueil
      </a>

      <!-- Title -->
      <div class="mb-12">
        <span class="section-label">Règlement RGPD</span>
        <h1 id="privacy-title" class="section-title text-4xl sm:text-5xl">Politique de Confidentialité</h1>
        <p class="section-sub mt-2">Dernière mise à jour : 19 juillet 2026</p>
      </div>

      <!-- Privacy Content -->
      <div class="space-y-10 text-ems-muted leading-relaxed">
        
        <!-- Introduction -->
        <div class="border-b border-ems-border/50 pb-8">
          <p>
            Nous accordons une grande importance à la protection et à la confidentialité de vos données personnelles. 
            Cette politique de confidentialité a pour but de vous expliquer de manière claire et transparente comment nous collectons, utilisons, stockons et protégeons vos données à caractère personnel lorsque vous utilisez notre formulaire de contact sur le site <strong>https://energeticmaintenances.fr</strong>.
          </p>
        </div>

        <!-- Données collectées -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">1. Données personnelles collectées</h2>
          <p>Lorsque vous utilisez notre formulaire de demande de devis et de contact, nous collectons les informations suivantes :</p>
          <ul class="list-disc pl-5 mt-4 space-y-2 text-ems-text">
            <li><strong>Nom de l'entreprise ou nom de famille :</strong> pour vous identifier et qualifier votre projet.</li>
            <li><strong>Adresse e-mail :</strong> pour répondre à votre message et vous envoyer le devis.</li>
            <li><strong>Numéro de téléphone (facultatif) :</strong> pour vous recontacter par téléphone si nécessaire afin d'échanger sur votre projet HTA ou IRVE.</li>
            <li><strong>Votre message :</strong> pour comprendre la nature et les contraintes techniques de votre demande.</li>
          </ul>
          
          <h3 class="font-display text-lg text-white uppercase tracking-wider mt-6 mb-3">Données techniques et de sécurité</h3>
          <p>
            Afin d'assurer la sécurité du service et la traçabilité des formulaires (notamment pour lutter contre les spams et les attaques de robots), nous collectons automatiquement les données techniques suivantes à chaque soumission :
          </p>
          <ul class="list-disc pl-5 mt-2 space-y-2 text-ems-text">
            <li><strong>Adresse IP :</strong> collectée à des fins de sécurité (blocage des adresses IP malveillantes en cas d'abus).</li>
            <li><strong>Date et heure de la soumission.</strong></li>
            <li><strong>User-Agent du navigateur :</strong> informations techniques sur votre navigateur pour le diagnostic en cas d'erreur de soumission.</li>
            <li><strong>Page de provenance (Referer) :</strong> pour savoir depuis quelle section de notre site le formulaire a été envoyé.</li>
          </ul>
        </div>

        <!-- Finalités de la collecte -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">2. Finalités et base légale du traitement</h2>
          <p>Les données que vous nous transmettez sont traitées pour les finalités suivantes :</p>
          <ul class="list-disc pl-5 mt-4 space-y-2 text-ems-text">
            <li><strong>Gestion de la relation client :</strong> réponse à vos questions, prise de contact et suivi de votre dossier (base légale : intérêt légitime ou mesures précontractuelles).</li>
            <li><strong>Établissement de devis personnalisés :</strong> étude de faisabilité pour vos installations Haute Tension HTA ou bornes de recharge IRVE (base légale : exécution de mesures précontractuelles).</li>
            <li><strong>Sécurité du site internet :</strong> prévention de la fraude, détection des abus et blocage du spam par le biais de la vérification de l'adresse IP et d'un système de protection honeypot invisible (base légale : intérêt légitime RGPD Art. 6-1-f).</li>
          </ul>
        </div>

        <!-- Durée de conservation -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">3. Durée de conservation des données</h2>
          <p class="text-ems-text bg-ems-surface border border-ems-border/50 rounded-lg p-5">
            Les données relatives aux demandes de contact sont conservées pendant une durée maximale de 3 ans à compter du dernier contact avec le prospect, sauf obligation légale contraire.
          </p>
        </div>

        <!-- Destinataires des données -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">4. Destinataires des données</h2>
          <p>
            Vos données personnelles sont uniquement destinées aux services internes d'<strong>Energetic Maintenance Services</strong> en charge du traitement des devis et de la relation client. 
            Aucune donnée personnelle n'est vendue, cédée, ou partagée avec des tiers à des fins publicitaires ou commerciales.
          </p>
        </div>

        <!-- Vos droits -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">5. Vos droits sur vos données</h2>
          <p>Conformément à la réglementation européenne sur la protection des données (RGPD), vous disposez des droits suivants concernant vos données personnelles :</p>
          <ul class="list-disc pl-5 mt-4 space-y-2 text-ems-text">
            <li><strong>Droit d'accès :</strong> vous pouvez demander une copie des données vous concernant.</li>
            <li><strong>Droit de rectification :</strong> vous pouvez demander la mise à jour ou la correction de données inexactes.</li>
            <li><strong>Droit à l'effacement (droit à l'oubli) :</strong> vous pouvez demander la suppression de vos données personnelles.</li>
            <li><strong>Droit à la limitation et d'opposition au traitement :</strong> vous pouvez vous opposer à certains traitements ou demander à ce qu'ils soient limités temporairement.</li>
          </ul>
          
          <h3 class="font-display text-lg text-white uppercase tracking-wider mt-6 mb-3">Comment exercer vos droits ?</h3>
          <p>
            Pour exercer l’un de ces droits, vous pouvez nous adresser votre demande à tout moment à l’adresse e-mail suivante : 
            <a href="mailto:contact@energeticmaintenances.fr" class="text-ems-green hover:underline">contact@energeticmaintenances.fr</a>. 
            Nous vous répondrons dans un délai maximal de 30 jours conformément à la réglementation.
          </p>
        </div>

      </div>

    </div>
  </section>
</template>
