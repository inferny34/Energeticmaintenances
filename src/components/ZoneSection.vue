<script setup>
const villes = [
  'Montpellier', 'Toulouse', 'Nîmes', 'Perpignan',
  'Béziers', 'Carcassonne', 'Sète', 'Narbonne'
]
</script>

<template>
  <section id="zone" class="py-24 bg-[#0f1a2e] relative overflow-hidden" aria-labelledby="zone-title">
    
    <!-- Motif fond grille de points subtile en arrière-plan -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: radial-gradient(#EFF0F2 1px, transparent 1px);
                background-size: 24px 24px;"
         aria-hidden="true">
    </div>

    <div class="relative max-w-4xl mx-auto px-6 text-center flex flex-col items-center z-10">

      <!-- Badge Déplacements -->
      <div class="w-fit mb-6">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Déplacements</span>
        </span>
      </div>

      <!-- Titre de section centré -->
      <h2 id="zone-title" class="font-display font-extrabold text-white text-center uppercase tracking-tight mb-6 leading-none text-2xl sm:text-4xl">
        Intervention dans tout le <span class="text-ems-green">Sud de France</span>
      </h2>

      <!-- Description de la zone d'intervention -->
      <p class="font-body text-[#8a96a8] text-sm max-w-2xl mx-auto leading-relaxed mb-12">
        Notre zone d'intervention principale couvre les départements du <strong class="text-white">Hérault (34)</strong>, du <strong class="text-white">Gard (30)</strong>,
        de l'<strong class="text-white">Aude (11)</strong>, des <strong class="text-white">Pyrénées-Orientales (66)</strong> et de la <strong class="text-white">Haute-Garonne (31)</strong>.
        Des déplacements sont possibles sur l'ensemble de la région sur devis.
      </p>

      <!-- Grille des villes centrée (4 colonnes sur SM, 2 colonnes sur XS) -->
      <ul class="grid grid-cols-2 sm:grid-cols-4 gap-x-8 gap-y-5 mb-12 text-left w-full max-w-2xl border-t border-b border-[#1e2f4a]/50 py-8" aria-label="Villes d'intervention">
        <li v-for="ville in villes" :key="ville"
            class="flex items-center gap-2 font-body text-sm text-[#8a96a8]">
          <svg class="text-ems-green w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          {{ ville }}
        </li>
      </ul>

      <!-- Note et CTA -->
      <p class="font-body text-xs text-[#8a96a8]/70 mb-8">
        Intervention possible hors zone sur devis — nous contacter pour tout projet spécifique.
      </p>

      <a href="#contact" class="inline-flex items-center justify-center bg-ems-green text-ems-dark font-body font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-ems-green-alt transition-colors w-fit">
        Vérifier ma zone
      </a>

    </div>
  </section>
</template>
