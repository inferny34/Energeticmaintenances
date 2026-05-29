<script setup>
const metrics = [
  { value: '20 ans', label: "D'expérience Enedis" },
  { value: 'P1/P2',  label: 'Certifié IRVE' },
  { value: '48h',    label: "Délai d'intervention" },
  { value: 'Occitanie', label: "Zone d'intervention" }
]

const certifs = [
  'Qualielec',
  'Habilitation HTA',
  'Certifié IRVE P1/P2',
  'Ex-Enedis 20 ans'
]
</script>

<template>
  <section id="about" class="py-24 bg-ems-dark" aria-labelledby="about-title">
    <div class="max-w-6xl mx-auto px-6">

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <!-- Texte -->
        <div class="flex flex-col gap-6">
          <div class="w-fit">
            <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-1">
              <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Qui sommes-nous</span>
            </span>
          </div>
          <h2 id="about-title" class="section-title">
            20 ans d'expertise au service de votre installation électrique
          </h2>
          <p class="font-body text-ems-muted text-base leading-relaxed">
            Energetic Maintenance Services est une entreprise spécialisée dans les installations
            électriques Haute Tension (HTA) et les infrastructures de recharge de véhicules électriques (IRVE) <strong class="text-ems-text">exclusivement dédiées aux entreprises, industriels, professionnels et collectivités</strong> en Occitanie.
          </p>
          <p class="font-body text-ems-muted text-base leading-relaxed">
            Fort de 20 années d'expérience acquises au sein d'Enedis, nous intervenons sur l'ensemble
            de la région pour l'installation, la maintenance et la mise en conformité de vos postes clients HTA, assurant la continuité d'activité de vos infrastructures.
          </p>
          <p class="font-body text-ems-muted text-base leading-relaxed">
            Certifié Qualielec et IRVE P1/P2, nous garantissons des prestations conformes aux normes
            en vigueur pour le compte exclusif des professionnels, avec un professionnalisme rigoureux. <em class="text-ems-green text-xs block mt-1 not-italic">EMS n'intervient pas auprès des particuliers.</em>
          </p>
          <a href="#contact" class="btn-primary w-fit" aria-label="Nous contacter pour un devis B2B">
            Espace Professionnel
          </a>
        </div>

        <!-- Métriques 2x2 -->
        <div class="grid grid-cols-2 gap-4">
          <div v-for="m in metrics" :key="m.value"
               class="bg-ems-surface border border-ems-border rounded-lg p-5 text-center">
            <span class="font-display font-extrabold text-2xl text-ems-green block">{{ m.value }}</span>
            <span class="font-body text-xs text-ems-muted mt-1 block">{{ m.label }}</span>
          </div>
        </div>
      </div>

      <!-- Bandeau certifications -->
      <div class="mt-16 pt-12 border-t border-ems-border">
        <p class="font-body text-xs text-ems-muted uppercase tracking-widest text-center mb-8">
          Certifications & agréments
        </p>
        <div class="flex flex-wrap justify-center gap-5">
          <div v-for="c in certifs" :key="c"
               class="flex items-center gap-2 bg-ems-surface border border-ems-green/40 rounded-md px-5 py-3">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 12l2 2 4-4" stroke="#5DBE3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="font-display font-bold text-ems-text text-sm">{{ c }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
