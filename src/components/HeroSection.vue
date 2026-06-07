<script setup>
// Pas de logique dynamique nécessaire
</script>

<template>
  <section id="hero"
           class="relative min-h-screen flex flex-col justify-between bg-ems-dark overflow-hidden pt-24 pb-8">

    <!-- Image de fond avec masques dégradés premium -->
    <div class="absolute inset-0 z-0">
      <img src="/hero_bg.png" alt="Lignes haute tension" class="w-full h-full object-cover object-center opacity-40" />
      <div class="absolute inset-0 bg-gradient-to-t from-ems-dark via-ems-dark/80 to-transparent"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-ems-dark/80 via-transparent to-ems-dark"></div>
    </div>

    <!-- Conteneur centré pour le contenu principal -->
    <div class="relative max-w-4xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center z-10 w-full">
      
      <!-- Badge de localisation -->
      <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 mb-8">
        <span class="w-2.5 h-2.5 rounded-full bg-ems-green inline-block animate-pulse"></span>
        <span class="font-body font-medium text-xs text-white/90">Zone d'intervention : Sud de France</span>
      </div>

      <!-- Logo & Titre de l'entreprise -->
      <div class="flex items-center gap-4 mb-6 text-left max-w-md sm:max-w-2xl">
        <img src="/logo.png" alt="EMS Logo" class="w-16 h-16 sm:w-20 sm:h-20 object-contain" />
        <h1 class="font-display font-extrabold leading-none text-white tracking-tight text-3xl sm:text-5xl uppercase">
          ENERGETIC<br>
          <span class="text-ems-green">MAINTENANCE<br>SERVICES</span>
        </h1>
      </div>

      <!-- Sous-titre descriptif -->
      <p class="font-body text-base sm:text-lg text-white/80 max-w-2xl leading-relaxed mb-6">
        Spécialiste <strong class="text-white">Haute Tension HTA</strong> et <strong class="text-ems-green">bornes de recharge IRVE</strong> dans le Sud de France. Poste client HTA, installation et maintenance — intervention rapide et devis gratuit.
      </p>

      <!-- Badge Expérience Enedis -->
      <div class="inline-flex items-center gap-2 bg-[#D17A22]/10 border border-[#D17A22]/20 rounded-lg px-4 py-2 mb-10 max-w-xl text-left">
        <svg class="w-5 h-5 text-[#D17A22] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <span class="font-body text-xs sm:text-sm text-[#D17A22] font-semibold">20 ans d'expérience — ancienne agence d'intervention spécialisée Enedis</span>
      </div>

      <!-- Boutons d'action -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-md sm:max-w-none">
        <a href="#contact" class="btn-primary w-full sm:w-auto px-8 py-3.5 rounded-full font-bold text-base shadow-lg shadow-ems-green/20 hover:scale-[1.02] transition-transform">
          Demander un devis gratuit &nbsp; →
        </a>
        <a href="tel:+33400000000" class="inline-flex items-center justify-center gap-2 bg-white/10 border border-white/20 text-white font-body font-semibold text-base px-8 py-3.5 rounded-full hover:bg-white/20 transition-all w-full sm:w-auto hover:scale-[1.02]">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Nous appeler
        </a>
      </div>

    </div>

    <!-- Réassurance et Indicateur de défilement (bas de page) -->
    <div class="relative z-10 w-full max-w-4xl mx-auto px-6">
      
      <!-- Liste des points forts -->
      <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-3 py-6 border-t border-white/10 w-full max-w-2xl mx-auto mb-6">
        <span class="flex items-center gap-2 text-xs sm:text-sm text-white/70 font-body">
          <svg class="text-ems-green w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          Réponse rapide
        </span>
        <span class="flex items-center gap-2 text-xs sm:text-sm text-white/70 font-body">
          <svg class="text-ems-green w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          Certifié Qualifelec
        </span>
        <span class="flex items-center gap-2 text-xs sm:text-sm text-white/70 font-body">
          <svg class="text-ems-green w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          20 ans d'expérience Enedis
        </span>
      </div>

      <!-- Indicateur de défilement -->
      <a href="#services" class="flex flex-col items-center gap-1.5 text-center text-white/40 hover:text-white/80 transition-colors py-2 group">
        <span class="font-body text-[10px] tracking-widest uppercase">Découvrir</span>
        <svg class="w-4 h-4 animate-bounce group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
      </a>
    </div>
  </section>
</template>
