<script setup>
// Pas de logique dynamique — FAQ en HTML natif <details>/<summary>
</script>

<template>
  <section id="bornes" class="py-24 bg-white text-slate-900" aria-labelledby="bornes-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green-dark">Particuliers</span>
        </span>
        <h2 id="bornes-title" class="font-display font-extrabold text-slate-900 uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Borne de recharge <span class="text-ems-green-dark">à domicile</span>
        </h2>
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Du conseil au branchement : nous gérons <strong class="text-slate-900">l'intégralité de votre projet</strong> de borne de recharge, de la vérification de votre tableau électrique jusqu'à la mise en service.
        </p>
      </div>

      <!-- Étapes / Offre -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-20">

        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col gap-4">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0 text-ems-green-dark" aria-hidden="true">
            <!-- Pictogramme Conseil & Choix -->
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-slate-900 text-base uppercase">Conseil & choix</h3>
          <p class="font-body text-sm text-slate-600 leading-relaxed">
            Nous vous guidons vers la solution adaptée à votre véhicule et à votre usage (puissance de 7 kW à 22 kW, pilotage de charge…).
          </p>
        </div>

        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col gap-4">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0 text-ems-green-dark" aria-hidden="true">
            <!-- Pictogramme Audit électrique -->
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-slate-900 text-base uppercase">Audit électrique</h3>
          <p class="font-body text-sm text-slate-600 leading-relaxed">
            Vérification méthodique de votre tableau, de la mise à la terre et de la capacité disponible avant toute intervention.
          </p>
        </div>

        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col gap-4">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0 text-ems-green-dark" aria-hidden="true">
            <!-- Pictogramme Pose certifiée -->
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-slate-900 text-base uppercase">Pose certifiée</h3>
          <p class="font-body text-sm text-slate-600 leading-relaxed">
            Installation conforme aux normes en vigueur (NF C 15-100), câblage sous protection dédiée et finition soignée.
          </p>
        </div>

        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col gap-4">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0 text-ems-green-dark" aria-hidden="true">
            <!-- Pictogramme Mise en service -->
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-slate-900 text-base uppercase">Mise en service</h3>
          <p class="font-body text-sm text-slate-600 leading-relaxed">
            Tests de charge réels, contrôle des sécurités électriques et remise de votre attestation de conformité.
          </p>
        </div>

      </div>

      <!-- FAQ natives <details>/<summary> — accessibles sans JS -->
      <div class="max-w-3xl mx-auto">
        <h3 class="font-display font-extrabold text-slate-900 uppercase tracking-tight text-xl sm:text-2xl text-center mb-10">
          Questions fréquentes
        </h3>

        <div class="flex flex-col gap-4">

          <details class="group bg-white border border-slate-200 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-display font-bold text-slate-900 text-sm uppercase tracking-wide list-none select-none hover:text-ems-green-dark transition-colors">
              Combien coûte l'installation d'une borne à domicile ?
              <svg class="w-5 h-5 flex-shrink-0 text-ems-green transition-transform duration-200 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
            </summary>
            <div class="px-6 pb-5 font-body text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
              Le tarif varie selon la configuration de votre installation électrique, la distance entre le tableau et l'emplacement de la borne, et le modèle choisi (7 kW à 22 kW). Comptez généralement entre <strong>800 € et 1 800 € TTC</strong> (fourniture et pose). Demandez un devis gratuit pour obtenir une estimation personnalisée.
            </div>
          </details>

          <details class="group bg-white border border-slate-200 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-display font-bold text-slate-900 text-sm uppercase tracking-wide list-none select-none hover:text-ems-green-dark transition-colors">
              Ai-je besoin de faire une démarche auprès du gestionnaire de réseau ?
              <svg class="w-5 h-5 flex-shrink-0 text-ems-green transition-transform duration-200 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
            </summary>
            <div class="px-6 pb-5 font-body text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
              Pour une borne ≤ 3,7 kW, aucune démarche spécifique n'est requise. Pour une borne de <strong>7 kW à 22 kW</strong>, nous vérifions si la puissance souscrite auprès de votre fournisseur est suffisante ou si un ajustement de contrat est nécessaire.
            </div>
          </details>

          <details class="group bg-white border border-slate-200 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-display font-bold text-slate-900 text-sm uppercase tracking-wide list-none select-none hover:text-ems-green-dark transition-colors">
              Une prise renforcée ou une borne électrique ?
              <svg class="w-5 h-5 flex-shrink-0 text-ems-green transition-transform duration-200 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
            </summary>
            <div class="px-6 pb-5 font-body text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
              <p>
                <strong>Il n'existe pas une solution unique pour tous les véhicules et tous les foyers.</strong> Prise renforcée et borne de recharge ont des fonctionnalités et des usages différents. Le choix dépend de votre véhicule, de vos habitudes de recharge, de la puissance souhaitée et des caractéristiques de votre installation électrique.
              </p>
              <p>
                <strong>Un technicien qualifié</strong> pourra étudier votre installation et vos besoins afin de vous conseiller la solution la plus adaptée, en toute sécurité et sans surdimensionner votre installation.
              </p>
            </div>
          </details>

          <details class="group bg-white border border-slate-200 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-display font-bold text-slate-900 text-sm uppercase tracking-wide list-none select-none hover:text-ems-green-dark transition-colors">
              Mon installation électrique actuelle est-elle compatible ?
              <svg class="w-5 h-5 flex-shrink-0 text-ems-green transition-transform duration-200 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
            </summary>
            <div class="px-6 pb-5 font-body text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
              Il n'est pas toujours nécessaire de modifier l'ensemble du tableau électrique. Nous réalisons un <strong>diagnostic préalable</strong> pour valider la conformité de l'installation et intégrer votre départ dédié.
            </div>
          </details>

          <details class="group bg-white border border-slate-200 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer font-display font-bold text-slate-900 text-sm uppercase tracking-wide list-none select-none hover:text-ems-green-dark transition-colors">
              Intervenez-vous en copropriété ?
              <svg class="w-5 h-5 flex-shrink-0 text-ems-green transition-transform duration-200 group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
            </summary>
            <div class="px-6 pb-5 font-body text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
              Oui. L'installation en copropriété s'inscrit dans le cadre du droit à la prise. Nous étudions le cheminement des câbles depuis le comptage et préparons le dossier technique pour votre syndic.
            </div>
          </details>

        </div>

        <!-- CTA Devis -->
        <div class="text-center mt-10 flex flex-col items-center gap-4">
          <a href="#contact"
             class="inline-flex items-center justify-center bg-ems-green text-ems-dark font-body font-bold text-sm uppercase tracking-wider px-8 py-4 rounded-full hover:bg-ems-green-alt transition-colors shadow-lg shadow-ems-green/20">
            Obtenir mon devis gratuit &nbsp;→
          </a>

          <!-- CTA discret vers le programme de recommandation (Point 3 de l'arbitrage) -->
          <a href="#recommandation"
             class="font-body text-xs text-slate-500 hover:text-ems-green-dark transition-colors inline-flex items-center gap-1.5 underline decoration-slate-300 hover:decoration-ems-green-dark underline-offset-4">
            <span>Vous connaissez un proche avec un projet de borne ? Découvrez notre programme de recommandation</span>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </a>
        </div>

      </div>

    </div>
  </section>
</template>
