<script setup>
// Section Programme de recommandation pour les particuliers
</script>

<template>
  <section id="recommandation" class="py-24 bg-[#0f1a2e] text-[#8a96a8] relative overflow-hidden" aria-labelledby="recommandation-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Programme Particuliers</span>
        </span>
        <h2 id="recommandation-title" class="font-display font-extrabold text-white uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Recommandez-nous et <span class="text-ems-green">recevez une commission</span>
        </h2>
        <p class="font-body text-[#8a96a8] text-base max-w-2xl mx-auto leading-relaxed">
          Vous connaissez un particulier souhaitant installer une borne de recharge à son domicile ? Partagez ses coordonnées ou invitez-le à nous contacter de votre part.
        </p>
      </div>

      <!-- 3 étapes simples -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

        <!-- Étape 1 -->
        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-8 flex flex-col gap-4 relative">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center text-ems-green flex-shrink-0" aria-hidden="true">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
          <span class="font-display font-extrabold text-xs text-ems-green tracking-widest uppercase">Étape 1</span>
          <h3 class="font-display font-bold text-white text-lg uppercase">Vous nous recommandez</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Un proche, un voisin ou un collègue a un projet de borne de recharge électrique chez lui ? Invitez-le à nous contacter en indiquant votre nom lors de sa demande.
          </p>
        </div>

        <!-- Étape 2 -->
        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-8 flex flex-col gap-4 relative">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center text-ems-green flex-shrink-0" aria-hidden="true">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
          </div>
          <span class="font-display font-extrabold text-xs text-ems-green tracking-widest uppercase">Étape 2</span>
          <h3 class="font-display font-bold text-white text-lg uppercase">Nous étudions son projet</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Energetic Maintenance prend contact avec la personne recommandée pour échanger sur son besoin, réaliser l'audit électrique préalable et établir un devis sur-mesure.
          </p>
        </div>

        <!-- Étape 3 -->
        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-8 flex flex-col gap-4 relative">
          <div class="w-12 h-12 rounded-xl bg-ems-green/10 flex items-center justify-center text-ems-green flex-shrink-0" aria-hidden="true">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <span class="font-display font-extrabold text-xs text-ems-green tracking-widest uppercase">Étape 3</span>
          <h3 class="font-display font-bold text-white text-lg uppercase">Vous recevez votre commission</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Dès que la recommandation aboutit à la signature d'un contrat et à l'installation de la borne, vous recevez votre commission selon les conditions du programme.
          </p>
        </div>

      </div>

      <!-- Encadré action & mention des conditions -->
      <div class="bg-[#162035] border border-ems-green/20 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
        <div class="flex flex-col gap-1.5 max-w-xl">
          <p class="font-display font-bold text-white text-base uppercase">
            Votre contact souhaite faire poser une borne ?
          </p>
          <p class="font-body text-xs text-[#8a96a8] leading-relaxed">
            Invitez-le à remplir le formulaire de contact en renseignant votre nom dans le champ prévu à cet effet.
          </p>
          <p class="font-body text-[11px] text-[#8a96a8]/70 mt-1">
            * Versement de la commission sous réserve de validation du chantier et selon les <a href="#contact" class="underline hover:text-ems-green">conditions générales du programme de recommandation</a>.
          </p>
        </div>
        <a href="#contact"
           class="inline-flex items-center justify-center bg-ems-green text-ems-dark font-body font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-ems-green-alt transition-colors flex-shrink-0">
          Nous recommander un projet &nbsp;→
        </a>
      </div>

    </div>
  </section>
</template>
