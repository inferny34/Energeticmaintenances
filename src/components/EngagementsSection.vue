<script setup>
const engagements = [
  {
    id: 'qualielec',
    value: 'Qualielec',
    tag: 'Certification officielle',
    title: 'Certifié Qualielec',
    text: 'Qualification professionnelle <strong>Qualielec</strong> reconnue par les donneurs d\'ordre. Gage de compétence et de sécurité pour vos <strong>installations électriques HTA</strong>.',
    // Icône Ruban / Badge de certification
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>`
  },
  {
    id: 'experience',
    value: '20 ans',
    tag: 'Expérience Enedis',
    title: "20 ans d'expérience Enedis",
    text: 'Ancienne agence d\'intervention spécialisée <strong>Enedis</strong>. Expertise inégalée sur les <strong>réseaux HTA</strong>, postes clients et infrastructures électriques.',
    // Icône Clé à molette / Outil
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>`
  },
  {
    id: 'occitanie',
    value: 'Occitanie',
    tag: "Zone d'intervention",
    title: 'Intervention en Occitanie',
    text: 'Intervention rapide sur toute la <strong>région Occitanie</strong>. Proximité et réactivité pour vos urgences et projets d\'<strong>infrastructure électrique</strong>.',
    // Icône Pin de localisation
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>`
  },
  {
    id: 'conformite',
    value: '100%',
    tag: 'Conformité normes',
    title: 'Conformité aux normes électriques',
    text: 'Toutes nos interventions respectent les normes <strong>NF C 13-100, IRVE, UTE C 15-722</strong>. Documentation et rapports fournis.',
    // Icône Double Check / Validation
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`
  }
]
</script>

<template>
  <section id="engagements" class="py-24 bg-ems-dark relative overflow-hidden" aria-labelledby="engagements-title">
    
    <!-- Motif fond grille de points subtile en arrière-plan -->
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: radial-gradient(#EFF0F2 1px, transparent 1px);
                background-size: 24px 24px;"
         aria-hidden="true">
    </div>

    <div class="relative max-w-6xl mx-auto px-6 z-10">

      <!-- En-tête de section style Premium -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Nos Engagements</span>
        </span>
        
        <h2 id="engagements-title" class="font-display font-extrabold text-ems-text text-center uppercase tracking-tight mb-4 leading-none"
            style="font-size: clamp(2rem, 4vw, 3rem);">
          Pourquoi choisir <span class="text-ems-green">EMS ?</span>
        </h2>
        
        <p class="font-body text-ems-muted text-base max-w-2xl mx-auto leading-relaxed">
          Une expertise pointue issue des <strong class="text-ems-text">réseaux Enedis</strong>, des certifications reconnues et une présence locale en <strong class="text-ems-text">Occitanie</strong>.
        </p>
      </div>

      <!-- Grille des cartes d'engagements premium -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <article v-for="item in engagements" :key="item.value"
                 class="relative bg-ems-surface border border-ems-border hover:border-ems-green/40 rounded-2xl p-8 transition-all duration-300 shadow-xl group overflow-hidden">
          
          <!-- Badge flottant en haut à droite en forme de pilule verte -->
          <span class="absolute top-6 right-6 text-xs font-body font-semibold bg-ems-green text-ems-dark px-3 py-1 rounded-full shadow-lg transition-transform duration-300 group-hover:scale-105">
            {{ item.value }}
          </span>

          <!-- Conteneur d'icône arrondi sombre en arrière-plan -->
          <div class="w-16 h-12 bg-ems-dark rounded-xl flex items-center justify-center mb-6 border border-ems-border" 
               v-html="item.svg"
               aria-hidden="true">
          </div>

          <!-- Titre Engagement -->
          <h3 class="font-display font-bold text-xl text-ems-text uppercase mb-3">
            {{ item.title }}
          </h3>

          <!-- Description de l'engagement avec style HTML fort géré -->
          <p class="font-body text-sm text-ems-muted leading-relaxed mb-6" v-html="item.text"></p>

          <!-- Checkbox d'engagement en pied de carte -->
          <div class="flex items-center gap-2 border-t border-ems-border/50 pt-4" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" class="text-ems-green flex-shrink-0">
              <circle cx="8" cy="8" r="8" fill="rgba(93,190,58,0.15)"/>
              <path d="M5 8.5l2 2 4-4" stroke="#5DBE3A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="font-body text-xs text-ems-muted font-medium uppercase tracking-wider group-hover:text-ems-green transition-colors duration-200">
              {{ item.tag }}
            </span>
          </div>

        </article>
      </div>

    </div>
  </section>
</template>
