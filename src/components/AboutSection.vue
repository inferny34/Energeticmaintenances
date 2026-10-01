<script setup>
const metrics = [
  { value: '20 ans', label: "D'expérience Enedis" },
  { value: 'NIV1/2/3', label: 'Certifié IRVE' },
  { value: '48h', label: 'Réponse ouvrée' },
  { value: '12 dép.', label: "Zone d'intervention" }
]

const certifs = [
  'Qualifelec',
  'Habilitation HTA',
  'Certifié IRVE NIV1/2/3',
  'IRVE MA1/A2/A3',
  '20 ans de métier'
]
</script>

<template>
  <section id="about" class="py-24 bg-[#0f1a2e] text-[#8a96a8] relative overflow-hidden" aria-labelledby="about-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête de section centré -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Qui sommes-nous</span>
        </span>
        <h2 id="about-title" class="font-display font-extrabold text-white uppercase tracking-tight leading-none text-2xl sm:text-4xl">
          Une solide expérience au service de votre installation électrique
        </h2>
      </div>

      <!-- Contenu principal en deux colonnes -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center mb-16">

        <!-- Texte (7 colonnes) -->
        <div class="lg:col-span-7 flex flex-col gap-6 text-left">
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Energetic Maintenances Services est une entreprise spécialisée dans les installations
            électriques Haute Tension (HTA) et les infrastructures de recharge de véhicules électriques (IRVE), au service des <strong class="text-white">particuliers, professionnels et collectivités</strong> en Occitanie et départements limitrophes.
          </p>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Fort de 20 années d'expérience technique acquises au sein d'Enedis en intervention spécialisée, nous mettons ce savoir-faire au service de vos bornes de recharge résidentielles et de vos postes clients industriels.
          </p>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Certifiés Qualifelec et IRVE NIV1/2/3, nous garantissons des réalisations sécurisées, durables et strictement conformes aux normes électriques françaises.
          </p>
          <a href="#contact" class="inline-flex items-center justify-center bg-ems-green text-ems-dark font-body font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-ems-green-alt transition-colors w-fit mt-2">
            Demander un devis
          </a>
        </div>

        <!-- Métriques 2x2 (5 colonnes) -->
        <div class="lg:col-span-5 grid grid-cols-2 gap-4">
          <div v-for="m in metrics" :key="m.value"
               class="bg-[#162035] border border-[#1e2f4a] rounded-xl p-6 text-center flex flex-col justify-center min-h-[120px] shadow-lg">
            <span class="font-display font-extrabold text-2xl text-ems-green block mb-1">{{ m.value }}</span>
            <span class="font-body text-xs text-white/80">{{ m.label }}</span>
          </div>
        </div>

      </div>

      <!-- Bandeau certifications horizontal centré -->
      <div class="border-t border-[#1e2f4a]/50 pt-10 flex flex-col items-center gap-6">
        <span class="font-body text-[10px] text-[#8a96a8] uppercase tracking-widest font-bold">Certifications & Agréments</span>
        <div class="flex flex-wrap justify-center gap-3 w-full">
          <div v-for="c in certifs" :key="c"
               class="flex items-center gap-2 bg-[#162035]/30 border border-[#1e2f4a] rounded-lg px-4 py-2 text-white">
            <svg class="w-4 h-4 text-ems-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-body font-bold text-xs text-white/90">{{ c }}</span>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>
