<script setup>
// Section désactivée — en attente de photos de chantiers et d'avis clients vérifiables.
// Pour activer : décommenter dans App.vue et retirer le commentaire d'import.
</script>

<template>
  <section id="realisations" class="py-24 bg-slate-50 text-slate-900" aria-labelledby="realisations-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green-dark">Réalisations & Avis</span>
        </span>
        <h2 id="realisations-title" class="font-display font-extrabold text-slate-900 uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Nos chantiers <span class="text-ems-green-dark">& avis clients</span>
        </h2>
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Découvrez quelques-unes de nos installations chez des particuliers et professionnels dans le Sud de France.
        </p>
      </div>

      <!-- Galerie photos — À remplir avec de vraies photos (WebP, lazy, dimensionnées) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
        <!--
          MODÈLE À UTILISER POUR CHAQUE PHOTO :
          <figure class="rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
            <img
              src="/photos/chantier-nom.webp"
              alt="Installation borne de recharge à domicile - [Ville]"
              class="w-full h-56 object-cover"
              width="600" height="400"
              loading="lazy"
            />
            <figcaption class="px-4 py-3 bg-white font-body text-xs text-slate-500">
              Installation borne 7 kW — [Ville], [Mois Année]
            </figcaption>
          </figure>
        -->

        <!-- Placeholder visible en développement -->
        <div v-for="n in 3" :key="n"
             class="rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 bg-white h-64 flex flex-col items-center justify-center gap-3 text-slate-400">
          <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <span class="font-body text-sm font-medium">Photo à venir</span>
        </div>
      </div>

      <!-- Avis clients — À remplir avec de vrais avis (Google, vérifiables) -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!--
          MODÈLE À UTILISER POUR CHAQUE AVIS :
          <blockquote class="bg-white border border-slate-100 rounded-2xl p-6 flex flex-col gap-4 shadow-sm">
            <div class="flex gap-1" aria-label="5 étoiles sur 5">
              <svg v-for="i in 5" :key="i" class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            </div>
            <p class="font-body text-sm text-slate-700 leading-relaxed italic">"Texte de l'avis ici."</p>
            <footer class="flex items-center gap-3 mt-auto">
              <div class="w-8 h-8 rounded-full bg-ems-green/10 flex items-center justify-center font-display font-bold text-ems-green-dark text-sm">
                P
              </div>
              <div>
                <span class="block font-body font-bold text-slate-800 text-xs">Prénom N.</span>
                <span class="block font-body text-[10px] text-slate-400">Source : Google — Vérifié</span>
              </div>
            </footer>
          </blockquote>
        -->

        <!-- Placeholders -->
        <div v-for="n in 3" :key="n"
             class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-6 h-44 flex flex-col items-center justify-center gap-2 text-slate-400">
          <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
          </svg>
          <span class="font-body text-sm font-medium">Avis à venir</span>
        </div>
      </div>

    </div>
  </section>
</template>
