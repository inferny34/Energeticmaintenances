<script setup>
const services = [
  {
    id: 'hta',
    badge: { text: 'Cœur de métier', classes: 'bg-ems-green text-ems-dark' },
    title: 'Poste Client Haute Tension HTA',
    description: "Installation, maintenance de postes clients HTA et mise en conformité. Expertise issue de 20 ans d'intervention spécialisée chez Enedis en région Occitanie.",
    items: ['Postes préfabriqués', 'Transformateurs HTA/BT', 'Cellules HTA', 'Conformité réseaux']
  },
  {
    id: 'irve',
    badge: { text: 'Certifié P1/P2', classes: 'border border-ems-green text-ems-green' },
    title: 'Installation & Maintenance Borne IRVE',
    description: "Pose et maintenance de bornes de recharge IRVE pour professionnels et collectivités. Certification IRVE P1/P2 obligatoire — nous l'avons.",
    items: ['Installation IRVE P1/P2', 'Bornes AC & DC', 'Maintenance préventive', 'Mise en service']
  },
  {
    id: 'maintenance',
    badge: null,
    title: 'Maintenance & Dépannage Électrique',
    description: "Contrats de maintenance préventive et corrective sur installations HTA et IRVE. Intervention rapide sur toute l'Occitanie.",
    items: ['Maintenance préventive', 'Dépannage urgent', 'Télésurveillance', "Rapport d'intervention"]
  }
]
</script>

<template>
  <section id="services" class="py-24 bg-ems-dark" aria-labelledby="services-title">

    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-14 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Ce que nous faisons</span>
        </span>
        <h2 id="services-title" class="section-title mb-4">Nos expertises</h2>
        <p class="font-body text-ems-muted text-base max-w-xl mx-auto">
          HTA, IRVE et maintenance électrique — des prestations complètes pour professionnels et collectivités.
        </p>
      </div>

      <!-- Grille de cartes -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <article v-for="service in services" :key="service.id"
                 class="card relative flex flex-col gap-4">

          <!-- Badge -->
          <span v-if="service.badge"
                :class="['absolute top-4 right-4 text-xs font-body font-medium px-3 py-1 rounded-full', service.badge.classes]">
            {{ service.badge.text }}
          </span>

          <!-- Icône SVG selon le service -->
          <div class="w-11 h-11" aria-hidden="true">
            <!-- HTA : transformateur / éclairs -->
            <svg v-if="service.id === 'hta'" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22 6L14 22h8l-4 16 14-18h-8l4-14z" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="22" cy="22" r="18" stroke="#5DBE3A" stroke-width="1.5" stroke-opacity="0.3"/>
            </svg>
            <!-- IRVE : prise de recharge -->
            <svg v-else-if="service.id === 'irve'" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="12" y="8" width="20" height="28" rx="4" stroke="#5DBE3A" stroke-width="2"/>
              <path d="M17 20h10M17 24h10" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round"/>
              <circle cx="22" cy="30" r="2" fill="#5DBE3A"/>
              <path d="M18 8V5M26 8V5" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <!-- Maintenance : clé à molette -->
            <svg v-else viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M30 8a8 8 0 00-10.9 10.9L8 30a3 3 0 004.2 4.2l11.1-11.1A8 8 0 0030 8z" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="29" cy="10" r="2" fill="#5DBE3A"/>
            </svg>
          </div>

          <!-- Titre H3 -->
          <h3 class="font-display font-bold text-ems-text text-xl uppercase">
            {{ service.title }}
          </h3>

          <!-- Description -->
          <p class="font-body text-sm text-ems-muted leading-relaxed flex-1">
            {{ service.description }}
          </p>

          <!-- Liste -->
          <ul class="flex flex-col gap-2" :aria-label="'Détails ' + service.title">
            <li v-for="item in service.items" :key="item"
                class="flex items-center gap-2 font-body text-sm text-ems-muted">
              <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 8l3.5 3.5L13 4.5" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              {{ item }}
            </li>
          </ul>

          <!-- Lien -->
          <a :href="'#contact'" :aria-label="'En savoir plus sur ' + service.title"
             class="font-body text-sm text-ems-green hover:underline mt-auto pt-2 inline-flex items-center gap-1">
            En savoir plus
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
              <path d="M3 8h10M9 4l4 4-4 4" stroke="#5DBE3A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </article>
      </div>
    </div>
  </section>
</template>
