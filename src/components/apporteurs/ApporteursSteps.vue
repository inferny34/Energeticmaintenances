<template>
  <!-- COMMENT ÇA MARCHE -->
  <section id="fonctionnement" class="py-20 bg-ems-dark-alt" aria-labelledby="fonctionnement-title">
    <div class="mx-auto max-w-6xl px-6">
      <p class="section-label">01 / Un parcours simple</p>
      <h2 id="fonctionnement-title" class="section-title mb-4">Comment ça marche&nbsp;?</h2>
      <p class="section-sub mb-12 max-w-2xl">
        Quatre étapes, aucun objectif imposé, aucun frais à verser à EMS.
        Programme réservé aux professionnels avec SIRET.
      </p>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="step in steps"
          :key="step.index"
          class="card"
        >
          <div class="flex items-center gap-3 mb-4">
            <span class="font-display font-extrabold text-2xl text-ems-green/30" aria-hidden="true">
              {{ step.index }}
            </span>
            <span class="text-2xl" aria-hidden="true">{{ step.symbol }}</span>
          </div>
          <h3 class="font-display font-bold text-white uppercase text-base mb-2">
            {{ step.title }}
          </h3>
          <p class="font-body text-sm text-ems-muted leading-relaxed">
            {{ step.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const steps = [
  {
    index: '01',
    symbol: '✎',
    title: 'Vous lisez et signez',
    description:
      "Renseignez vos informations professionnelles. EMS prépare le contrat\u00a0; vous signez en premier, EMS contresigne et vous remet votre exemplaire.",
  },
  {
    index: '02',
    symbol: '↗',
    title: 'Vous présentez un client',
    description:
      "Le client a demandé à être contacté par EMS. Présentez-le par écrit\u00a0; EMS vous répond sous 7 jours calendaires.",
  },
  {
    index: '03',
    symbol: '⚡',
    title: 'Nous faisons le reste',
    description: 'Visite technique, devis, installation de la borne.',
  },
  {
    index: '04',
    symbol: '✓',
    title: 'Vous êtes payé',
    description:
      "Après installation et encaissement complet du chantier, vous facturez la commission à EMS\u00a0: 100\u00a0€, puis 130\u00a0€ à partir de la 11\u1d49 borne, selon le contrat.",
  },
]
</script>
