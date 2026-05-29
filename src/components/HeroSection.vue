<script setup>
// Pas de logique dynamique dans cette section, données inline dans le template
</script>

<template>
  <section id="hero"
           class="relative min-h-screen flex items-center bg-ems-dark overflow-hidden pt-16">

    <!-- Motif fond grille de points -->
    <div class="absolute inset-0 opacity-30"
         style="background-image: radial-gradient(#162035 1px, transparent 1px);
                background-size: 28px 28px;"
         aria-hidden="true">
    </div>

    <!-- Lueur verte diffuse -->
    <div class="absolute top-0 right-0 w-1/2 h-1/2 opacity-[0.06]"
         style="background: radial-gradient(circle at 80% 20%, #5DBE3A 0%, transparent 65%);"
         aria-hidden="true">
    </div>

    <div class="relative max-w-4xl mx-auto px-6 py-20 flex flex-col items-center text-center w-full z-10">

      <!-- Badge -->
      <div class="flex items-center gap-2 bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1.5 mb-6">
        <span class="w-2 h-2 rounded-full bg-ems-green inline-block animate-pulse" aria-hidden="true"></span>
        <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Certifié Qualielec · 20 ans Enedis</span>
      </div>

      <!-- H1 — UNIQUE SUR TOUTE LA PAGE -->
      <h1 class="font-display font-extrabold uppercase leading-none text-ems-text mb-6"
          style="font-size: clamp(2.4rem, 6vw, 4.8rem);">
        Expert Électricité<br>
        <span class="text-ems-green">Haute Tension HTA</span>
      </h1>

      <!-- Sous-titre -->
      <p class="font-body text-lg sm:text-xl text-ems-muted max-w-2xl leading-relaxed mb-8">
        Installation et maintenance de postes HTA et bornes IRVE en Occitanie. 
        <span class="text-ems-text font-medium block mt-2">Solutions exclusivement dédiées aux professionnels, industries et collectivités.</span>
      </p>

      <!-- 3 avantages stylisés en ligne centrée -->
      <ul class="flex flex-col sm:flex-row flex-wrap justify-center gap-x-8 gap-y-3 mb-10 text-left sm:text-center" aria-label="Nos spécialités">
        <li class="flex items-center gap-2">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" class="flex-shrink-0">
            <path d="M3 8l3.5 3.5L13 4.5" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="font-body text-sm text-ems-muted">Poste client HTA</span>
        </li>
        <li class="flex items-center gap-2">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" class="flex-shrink-0">
            <path d="M3 8l3.5 3.5L13 4.5" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="font-body text-sm text-ems-muted">Bornes de recharge IRVE</span>
        </li>
        <li class="flex items-center gap-2">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" class="flex-shrink-0">
            <path d="M3 8l3.5 3.5L13 4.5" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="font-body text-sm text-ems-muted">Expertise Enedis</span>
        </li>
      </ul>

      <!-- Boutons -->
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <a href="#contact" class="btn-primary" aria-label="Demander un devis gratuit">
          Demander un devis
        </a>
        <a href="#services" class="btn-outline" aria-label="Voir nos services">
          Nos services
        </a>
      </div>

      <!-- Réassurance -->
      <div class="flex flex-wrap justify-center gap-x-8 gap-y-3 pt-6 border-t border-ems-border/60 w-full max-w-2xl"
           aria-label="Points forts">
        <span class="flex items-center gap-2 text-xs text-ems-muted font-body">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Intervention rapide
        </span>
        <span class="flex items-center gap-2 text-xs text-ems-muted font-body">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Devis gratuit
        </span>
        <span class="flex items-center gap-2 text-xs text-ems-muted font-body">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Qualielec certifié
        </span>
        <span class="flex items-center gap-2 text-xs text-ems-muted font-body">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z" stroke="#5DBE3A" stroke-width="2"/>
            <circle cx="12" cy="10" r="3" stroke="#5DBE3A" stroke-width="2"/>
          </svg>
          Occitanie
        </span>
      </div>

    </div>
  </section>
</template>
