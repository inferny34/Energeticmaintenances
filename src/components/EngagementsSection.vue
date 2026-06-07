<script setup>
const engagements = [
  {
    id: 'qualielec',
    badgeText: 'Qualité',
    tag: 'Certification officielle',
    title: 'Certifié Qualifelec',
    text: 'Qualification professionnelle de <strong>Qualifelec</strong> reconnue dans le domaine d\'activité. Gage de compétence et de sécurité pour vos <strong>installations électriques HTA</strong>.',
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>`
  },
  {
    id: 'experience',
    badgeText: '20 ans',
    tag: 'Assurance Décennale',
    title: "20 ans d'expérience terrain",
    text: "Ancienne agence d'intervention spécialisée <strong>Enedis</strong>. Expertise inégalée sur les <strong>réseaux HTA</strong>, postes clients et infrastructures électriques.",
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>`
  },
  {
    id: 'sud-de-france',
    badgeText: 'Proximité',
    tag: "Zone d'intervention",
    title: 'Intervention dans le Sud de France',
    text: 'Implantation rapide sur tout le <strong>Sud de France</strong>. Proximité et réactivité pour vos urgences et projets d\'<strong>infrastructures électriques</strong>.',
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>`
  },
  {
    id: 'conformite',
    badgeText: 'Normes',
    tag: 'Conformité normes',
    title: 'Conformité aux normes électriques',
    text: 'Toutes nos interventions respectent les normes <strong>NF C 15-100, NF C 13-100, NF C 13-200</strong>, documentation et rapports fournis.',
    svg: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`
  }
]
</script>

<template>
  <section id="engagements" class="py-24 bg-white relative overflow-hidden" aria-labelledby="engagements-title">
    
    <!-- Motif fond grille de points subtile en arrière-plan -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none"
         style="background-image: radial-gradient(#000 1px, transparent 1px);
                background-size: 24px 24px;"
         aria-hidden="true">
    </div>

    <div class="relative max-w-6xl mx-auto px-6 z-10 flex flex-col items-center">

      <!-- En-tête de section -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Nos Engagements</span>
        </span>
        
        <h2 id="engagements-title" class="font-display font-extrabold text-slate-900 text-center uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Pourquoi choisir <span class="text-ems-green">EMS ?</span>
        </h2>
        
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Une expertise unique issue des <strong class="text-slate-900">réseaux Enedis</strong>, des certifications reconnues et une présence locale dans le <strong class="text-slate-900">Sud de France</strong>.
        </p>
      </div>

      <!-- Grille des cartes -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full mb-16">
        <article v-for="item in engagements" :key="item.id"
                 class="relative bg-white border border-slate-200/60 hover:border-ems-green/45 rounded-2xl p-8 transition-all duration-300 shadow-md hover:shadow-lg group overflow-hidden">
          
          <!-- Badge flottant en haut à droite -->
          <span class="absolute top-6 right-6 text-[10px] font-body font-bold bg-[#5dbe3a] text-[#0f1a2e] px-3 py-1 rounded-full uppercase tracking-wider">
            {{ item.badgeText }}
          </span>

          <!-- Conteneur d'icône -->
          <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center mb-6 border border-slate-100" 
               v-html="item.svg"
               aria-hidden="true">
          </div>

          <!-- Titre Engagement -->
          <h3 class="font-display font-bold text-lg text-slate-900 uppercase mb-3">
            {{ item.title }}
          </h3>

          <!-- Description -->
          <p class="font-body text-sm text-slate-600 leading-relaxed mb-6" v-html="item.text"></p>

          <!-- Pied de carte -->
          <div class="flex items-center gap-2 border-t border-slate-100 pt-4" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" class="text-ems-green flex-shrink-0">
              <circle cx="8" cy="8" r="8" fill="rgba(93,190,58,0.15)"/>
              <path d="M5 8.5l2 2 4-4" stroke="#5DBE3A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="font-body text-[11px] text-slate-500 font-bold uppercase tracking-wider group-hover:text-ems-green transition-colors duration-200">
              {{ item.tag }}
            </span>
          </div>

        </article>
      </div>

      <!-- Bas de section : Étoiles et référence -->
      <div class="flex flex-col items-center text-center gap-2 mt-4">
        <span class="font-body text-xs text-slate-500 uppercase tracking-wider font-semibold">référence professionnels dans le Sud de France</span>
        <!-- 5 Étoiles vertes -->
        <div class="flex items-center gap-1.5" aria-label="5 étoiles de notation">
          <svg v-for="i in 5" :key="i" class="w-4 h-4 text-ems-green" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
        </div>
      </div>

    </div>
  </section>
</template>
