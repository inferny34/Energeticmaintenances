<script setup>
const htaItems = [
  'Maintenance et dépannage de postes clients HTA',
  'Transformateurs HTA/BT et cellules de coupure',
  'Contrats d\'entretien périodiques et préventifs',
  'Mise en conformité selon les normes NF C 13-100 et NF C 13-200',
  'Intervention sur réseaux privés professionnels',
]

const irveItems = [
  'Installation de bornes de recharge de 7 kW à 22 kW',
  'Maintenance de bornes AC/DC jusqu\'à 50 kW',
  'Étude technique et raccordement au tableau général',
  'Infrastructures pour flottes d\'entreprises et copropriétés',
  'Contrats de maintenance préventive et curative',
]

const certifs = [
  'Qualifelec',
  'IRVE NIV1/2/3',
  'IRVE MA1/A2/A3',
  'Habilitation HTA',
]
</script>

<template>
  <section id="pros" class="py-24 bg-white text-slate-900" aria-labelledby="pros-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête unique et direct -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-[#1b2a4a]/10 border border-[#1b2a4a]/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-[#1b2a4a]">Professionnels & Collectivités</span>
        </span>
        <h2 id="pros-title" class="font-display font-extrabold text-slate-900 uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Solutions <span class="text-ems-green-dark">HTA & IRVE</span> pour les professionnels
        </h2>
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Pour les entreprises, gestionnaires de flottes, syndics de copropriété et collectivités : installation, maintenance et mise en conformité de vos infrastructures électriques.
        </p>
      </div>

      <!-- Deux colonnes : Haute Tension HTA | IRVE Entreprises -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">

        <!-- Haute Tension HTA -->
        <article class="bg-[#0f1a2e] rounded-2xl p-8 flex flex-col gap-6 border border-[#1e2f4a]">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#1b2a4a] flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <h3 class="font-display font-extrabold text-white text-xl uppercase">Poste client Haute Tension HTA</h3>
          </div>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Entretien et vérification de vos postes clients HTA, cellules et transformateurs. Nous assurons la continuité de service et la sécurité de vos installations industrielles et tertiaires.
          </p>
          <ul class="flex flex-col gap-2.5">
            <li v-for="item in htaItems" :key="item" class="flex items-center gap-2.5 font-body text-sm text-[#8a96a8]">
              <svg class="w-4 h-4 text-ems-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              {{ item }}
            </li>
          </ul>
          <a href="#contact"
             class="font-body font-bold text-sm text-ems-green hover:text-white transition-colors inline-flex items-center gap-1.5 mt-auto self-start border-b border-transparent hover:border-white pb-0.5">
            Demander un devis HTA
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </a>
        </article>

        <!-- IRVE Professionnel -->
        <article class="bg-[#0f1a2e] rounded-2xl p-8 flex flex-col gap-6 border border-[#1e2f4a]">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-ems-green flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <h3 class="font-display font-extrabold text-white text-xl uppercase">Infrastructures IRVE Entreprises</h3>
          </div>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Équipement de parkings d'entreprise et copropriétés : installation certifiée de bornes de recharge de 7 kW à 22 kW, et maintenance spécialisée de bornes AC/DC jusqu'à 50 kW.
          </p>
          <ul class="flex flex-col gap-2.5">
            <li v-for="item in irveItems" :key="item" class="flex items-center gap-2.5 font-body text-sm text-[#8a96a8]">
              <svg class="w-4 h-4 text-ems-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              {{ item }}
            </li>
          </ul>
          <a href="#contact"
             class="font-body font-bold text-sm text-ems-green hover:text-white transition-colors inline-flex items-center gap-1.5 mt-auto self-start border-b border-transparent hover:border-white pb-0.5">
            Demander un devis IRVE Pro
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </a>
        </article>

      </div>

      <!-- Bandeau certifications & agréments -->
      <div class="bg-slate-50 border border-slate-100 rounded-2xl px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex flex-col gap-1">
          <span class="font-body text-[10px] text-slate-400 uppercase tracking-widest font-bold">Certifications & Habilitations</span>
          <div class="flex flex-wrap gap-2 mt-2">
            <span v-for="c in certifs" :key="c"
                  class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-lg px-3 py-1.5 font-body font-bold text-xs text-slate-800">
              <svg class="w-3.5 h-3.5 text-ems-green flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
              {{ c }}
            </span>
          </div>
        </div>
        <div class="bg-white rounded-xl p-3 border border-slate-200 flex items-center justify-center flex-shrink-0">
          <img src="/logo-qualifelec.webp" alt="Logo certification Qualifelec" class="w-14 h-auto object-contain" width="250" height="300" loading="lazy" />
        </div>
      </div>

    </div>
  </section>
</template>
