<script setup>
const services = [
  {
    id: 'hta',
    iconBg: 'bg-[#1b2a4a]',
    iconColor: 'text-[#eff0f2]',
    title: 'Poste client Haute Tension HTA',
    description: "Maintenance de postes clients HTA et mise en conformité. Expertise issue de 20 ans d'intervention spécialisée chez Enedis dans le Sud de France.",
    tags: ['Poste préfabriqué', 'Transformateur HTA/BT', 'Cellule HTA', "Contrat d'entretien"],
    svg: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>`
  },
  {
    id: 'irve',
    iconBg: 'bg-[#5dbe3a]',
    iconColor: 'text-white',
    title: 'Installation & maintenance borne IRVE',
    description: "Pose et maintenance de bornes de recharge IRVE pour professionnels et collectivités. Certification IRVE NIV1/2/3. (Intégration de bornes de 7kW à 150kW).",
    tags: ['Intégration AC & DC', 'Borne AC & DC', 'Supervision opérateur', 'Mise en service'],
    svg: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>` // On peut utiliser une icône de plug
  },
  {
    id: 'maintenance',
    iconBg: 'bg-[#2e7d32]',
    iconColor: 'text-white',
    title: 'Maintenance & dépannage électrique',
    description: "Contrats de maintenance préventive et curative sur vos installations HTA et BT. Intervention rapide sur tout le Sud de France.",
    tags: ['Maintenance préventive', 'Dépannage urgent', 'Télé-assistance', "Rapport d'intervention"],
    svg: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>`
  }
]
</script>

<template>
  <section id="services" class="py-24 bg-white text-slate-900" aria-labelledby="services-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête de section -->
      <div class="text-center mb-16 flex flex-col items-center">
        <!-- Badge -->
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Nos Services</span>
        </span>
        
        <h2 id="services-title" class="font-display font-extrabold text-slate-900 text-center uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Expertise <span class="text-ems-green">HTA & IRVE</span> dans le <span class="text-ems-green">Sud de France</span>
        </h2>
        
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Des prestations spécialisées pour les professionnels et collectivités, issues de <strong class="text-slate-900">20 ans d'expérience terrain Enedis</strong>.
        </p>
      </div>

      <!-- Cartes des services -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <article v-for="service in services" :key="service.id"
                 class="bg-white border border-slate-100 rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
          
          <div>
            <!-- Conteneur Icône -->
            <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-6 shadow-sm', service.iconBg, service.iconColor]"
                 v-html="service.svg"
                 aria-hidden="true">
            </div>

            <!-- Titre du service -->
            <h3 class="font-display font-bold text-xl text-slate-900 uppercase mb-4 leading-snug group-hover:text-ems-green transition-colors duration-200">
              {{ service.title }}
            </h3>

            <!-- Description -->
            <p class="font-body text-sm text-slate-600 leading-relaxed mb-6">
              {{ service.description }}
            </p>

            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-8">
              <span v-for="tag in service.tags" :key="tag"
                    class="font-body text-xs bg-slate-50 text-slate-600 px-3 py-1 rounded-md border border-slate-100">
                {{ tag }}
              </span>
            </div>
          </div>

          <!-- Lien Devis -->
          <a href="#contact"
             class="font-body font-bold text-sm text-slate-800 hover:text-ems-green transition-colors inline-flex items-center gap-1.5 mt-auto self-start border-b border-transparent hover:border-ems-green pb-0.5">
            Demander un devis
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </a>

        </article>
      </div>

    </div>
  </section>
</template>
