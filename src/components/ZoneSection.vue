<script setup>
const departements = [
  { code: '34', nom: 'Hérault' },
  { code: '30', nom: 'Gard' },
  { code: '13', nom: 'Bouches-du-Rhône' },
  { code: '84', nom: 'Vaucluse' },
  { code: '07', nom: 'Ardèche' },
  { code: '48', nom: 'Lozère' },
  { code: '12', nom: 'Aveyron' },
  { code: '81', nom: 'Tarn' },
  { code: '11', nom: 'Aude' },
  { code: '66', nom: 'Pyrénées-Orientales' },
  { code: '09', nom: 'Ariège' },
  { code: '31', nom: 'Haute-Garonne' }
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
        Intervention sur <span class="text-ems-green">12 départements</span>
      </h2>

      <!-- Description de la zone d'intervention -->
      <p class="font-body text-[#8a96a8] text-sm max-w-2xl mx-auto leading-relaxed mb-10">
        Basés à Poussan dans l'Hérault, nous nous déplaçons rapidement pour l'installation de votre borne de recharge et vos besoins électriques en Occitanie et départements limitrophes.
      </p>

      <!-- Grille des 12 départements sous forme de badges lisibles -->
      <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-10 w-full max-w-3xl" aria-label="Départements couverts">
        <li v-for="d in departements" :key="d.code"
            class="bg-[#162035] border border-[#1e2f4a] rounded-xl px-4 py-3 flex items-center gap-3 text-left hover:border-ems-green/40 transition-colors">
          <span class="font-display font-bold text-xs bg-ems-green/10 text-ems-green px-2 py-1 rounded-md flex-shrink-0">
            {{ d.code }}
          </span>
          <span class="font-body font-semibold text-xs text-white/90 truncate">
            {{ d.nom }}
          </span>
        </li>
      </ul>

      <!-- Note et CTA -->
      <p class="font-body text-xs text-[#8a96a8]/70 mb-8">
        Vous avez un doute sur votre localisation ? Contactez-nous pour vérifier notre disponibilité sur votre commune.
      </p>

      <a href="#contact" class="inline-flex items-center justify-center bg-ems-green text-ems-dark font-body font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-ems-green-alt transition-colors w-fit">
        Vérifier mon projet
      </a>

    </div>
  </section>
</template>
