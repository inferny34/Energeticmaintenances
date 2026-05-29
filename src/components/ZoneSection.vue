<script setup>
const villes = [
  'Montpellier', 'Toulouse',
  'Nîmes',       'Perpignan',
  'Béziers',     'Carcassonne',
  'Sète',        'Narbonne'
]
</script>

<template>
  <section id="zone" class="py-24 bg-ems-dark relative overflow-hidden" aria-labelledby="zone-title">
    
    <!-- Motif fond grille de points subtile en arrière-plan -->
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: radial-gradient(#EFF0F2 1px, transparent 1px);
                background-size: 24px 24px;"
         aria-hidden="true">
    </div>

    <div class="relative max-w-4xl mx-auto px-6 text-center flex flex-col items-center z-10">

      <!-- Badge premium centré -->
      <div class="w-fit mb-6">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Déplacements</span>
        </span>
      </div>

      <!-- Titre de section centré -->
      <h2 id="zone-title" class="font-display font-extrabold text-ems-text text-center uppercase tracking-tight mb-6 leading-none"
          style="font-size: clamp(2rem, 4vw, 3rem);">
        Intervention sur toute <span class="text-ems-green">l'Occitanie</span>
      </h2>

      <!-- Description de la zone d'intervention -->
      <p class="font-body text-ems-muted text-base max-w-2xl mx-auto leading-relaxed mb-10">
        Notre zone d'intervention principale couvre les départements du <strong class="text-ems-text">Hérault (34)</strong>, du <strong class="text-ems-text">Gard (30)</strong>,
        de l' <strong class="text-ems-text">Aude (11)</strong>, des <strong class="text-ems-text">Pyrénées-Orientales (66)</strong> et de la <strong class="text-ems-text">Haute-Garonne (31)</strong>.
        Des déplacements sont possibles sur l'ensemble de la région sur devis.
      </p>

      <!-- Grille des villes centrée -->
      <ul class="grid grid-cols-2 sm:grid-cols-4 gap-x-8 gap-y-4 mb-10 text-left w-full max-w-2xl border-t border-b border-ems-border/40 py-8" aria-label="Villes d'intervention">
        <li v-for="ville in villes" :key="ville"
            class="flex items-center gap-2 font-body text-sm text-ems-muted">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="text-ems-green flex-shrink-0">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z" stroke="#5DBE3A" stroke-width="2"/>
            <circle cx="12" cy="10" r="3" stroke="#5DBE3A" stroke-width="2"/>
          </svg>
          {{ ville }}
        </li>
      </ul>

      <!-- Note et CTA -->
      <em class="font-body text-xs text-ems-muted/70 not-italic mb-6 block">
        Intervention possible hors zone sur devis — nous contacter pour tout projet spécifique.
      </em>

      <a href="#contact" class="btn-primary" aria-label="Vérifier notre zone d'intervention">
        Vérifier ma zone
      </a>

    </div>
  </section>
</template>
