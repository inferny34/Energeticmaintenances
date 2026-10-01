<script setup>
// Pas de logique dynamique nécessaire
</script>

<template>
  <section id="hero"
           class="relative min-h-screen flex flex-col justify-between bg-ems-dark overflow-hidden pt-24 pb-8">

    <!-- Image de fond bien visible avec dégradés équilibrés -->
    <div class="absolute inset-0 z-0">
      <img src="/hero_bg.webp" alt="Installation électrique professionnelle et bornes de recharge" class="w-full h-full object-cover object-center opacity-65 md:opacity-75" fetchpriority="high" />
      <!-- Voile sombre léger pour unifier les contrastes sans cacher l'image -->
      <div class="absolute inset-0 bg-ems-dark/40"></div>
      <!-- Dégradés doux haut/bas pour intégrer la navbar et le bas de section -->
      <div class="absolute inset-0 bg-gradient-to-t from-ems-dark via-transparent to-ems-dark/70"></div>
    </div>

    <!-- Conteneur centré pour le contenu principal -->
    <div class="relative max-w-4xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center z-10 w-full">

      <!-- Badge de localisation -->
      <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 mb-6">
        <span class="w-2.5 h-2.5 rounded-full bg-ems-green inline-block animate-pulse"></span>
        <span class="font-body font-medium text-xs text-white/90">Zone d'intervention : Occitanie & départements limitrophes</span>
      </div>

      <!-- Logo & Nom de marque (identité visuelle, hors H1) -->
      <div class="flex items-center gap-3 mb-6 justify-center">
        <img src="/logo.webp" alt="Logo Energetic Maintenances Services" class="w-12 h-12 sm:w-14 sm:h-14 object-contain" fetchpriority="high" />
        <span class="font-display font-extrabold text-sm sm:text-base text-white uppercase tracking-widest leading-tight text-left">
          Energetic<br><span class="text-ems-green">Maintenances Services</span>
        </span>
      </div>

      <!-- H1 — Titre SEO principal -->
      <h1 class="font-display font-extrabold leading-tight text-white tracking-tight text-3xl sm:text-5xl uppercase mb-6 max-w-3xl">
        Installation et maintenances éléctriques HT/BT
      </h1>

      <!-- Sous-titre explicite -->
       <p class="font-body text-base sm:text-lg text-white/95 max-w-2xl leading-relaxed mb-8">Votre partenaire <strong class="text-ems-green">Qualifelec</strong>
      </p>
      <ul class="font-body text-base sm:text-lg text-white/95 space-y-3 mb-8">
        <li class="flex items-center gap-3">
          <span class="text-ems-green">✓</span>
          <span>Pose et maintenance bornes IRVE</span>
        </li>
        <li class="flex items-center gap-3">
          <span class="text-ems-green">✓</span>
          <span>Maintenance HTA/BT</span>
        </li>
        <li class="flex items-center gap-3">
          <span class="text-ems-green">✓</span>
          <span>Électricité générale</span>
        </li>
        <li class="flex items-center gap-3">
          <span class="text-ems-green">✓</span>
          <span>Mise en conformité</span>
        </li>
      </ul>

      <!-- Boutons d'action -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-md sm:max-w-none">
        <a href="#contact"
           class="btn-primary w-full sm:w-auto px-8 py-3.5 rounded-full font-bold text-base shadow-lg shadow-ems-green/20 hover:scale-[1.02] transition-transform">
          Demander mon devis &nbsp;→
        </a>
        <a href="tel:+33743708495"
           class="inline-flex items-center justify-center gap-2 bg-white/10 border border-white/20 text-white font-body font-semibold text-base px-8 py-3.5 rounded-full hover:bg-white/20 transition-all w-full sm:w-auto hover:scale-[1.02]">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Parler à un installateur
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
          Devis gratuit & réponse en 48h ouvrées
        </span>
        <span class="flex items-center gap-2 text-xs sm:text-sm text-white/70 font-body">
          <svg class="text-ems-green w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          Certifié Qualifelec IRVE
        </span>
        <span class="flex items-center gap-2 text-xs sm:text-sm text-white/70 font-body">
          <svg class="text-ems-green w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          Particuliers & Professionnels
        </span>
        <span class="flex items-center gap-2 text-xs sm:text-sm text-white/70 font-body">
          <svg class="text-ems-green w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          Garantie décennale
        </span>
      </div>

      <!-- Indicateur de défilement -->
      <a href="#bornes" class="flex flex-col items-center gap-1.5 text-center text-white/40 hover:text-white/80 transition-colors py-2 group">
        <span class="font-body text-[10px] tracking-widest uppercase">Découvrir</span>
        <svg class="w-4 h-4 animate-bounce group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
      </a>
    </div>
  </section>
</template>
