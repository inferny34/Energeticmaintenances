<template>
  <!-- GUIDE MICRO-ENTREPRISE -->
  <section id="guide-micro" class="py-20 bg-ems-dark micro-guide" aria-labelledby="guide-micro-title">
    <div class="mx-auto max-w-6xl px-6">
      <p class="section-label">Avant de nous rejoindre</p>
      <h2 id="guide-micro-title" class="section-title mb-4">
        Créer sa micro-entreprise&nbsp;: plus simple qu'on ne l'imagine.
      </h2>
      <p class="section-sub mb-12 max-w-2xl">
        Pas besoin de créer une société&nbsp;: la micro-entreprise est un régime simplifié de
        l'entreprise individuelle. La demande se fait en ligne, en quelques étapes, avec vos
        justificatifs. On vous explique l'essentiel.
      </p>

      <!-- 3 étapes -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <article
          v-for="step in steps"
          :key="step.num"
          class="card reveal space-y-4"
        >
          <span
            class="inline-block font-display font-extrabold text-3xl text-ems-green/20"
            aria-hidden="true"
          >{{ step.num }}</span>
          <h3 class="font-display font-bold text-white uppercase text-base">{{ step.title }}</h3>
          <p class="font-body text-sm text-ems-muted leading-relaxed">{{ step.body }}</p>
          <a
            :href="step.link"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-1 font-body text-sm text-ems-green hover:text-white transition-colors"
          >
            {{ step.linkLabel }} <span aria-hidden="true">↗</span>
          </a>
        </article>
      </div>

      <!-- Encart "0 € de cotisations" -->
      <div class="flex items-start gap-4 rounded-xl border border-ems-green/20 bg-ems-surface/50 p-6 mb-6">
        <span aria-hidden="true" class="text-ems-green text-xl flex-shrink-0 mt-0.5">✓</span>
        <div>
          <h3 class="font-display font-bold text-white uppercase text-base mb-2">
            Pas de chiffre d'affaires encaissé&nbsp;?
          </h3>
          <p class="font-body text-sm text-ems-muted leading-relaxed">
            Dans le régime micro-social, un chiffre d'affaires nul entraîne en principe
            <strong class="text-white">0&nbsp;€ de cotisations sociales</strong>, sauf option pour
            des cotisations minimales. Vous devez tout de même déclarer
            <strong class="text-white">0&nbsp;€</strong> à chaque échéance.
          </p>
        </div>
      </div>

      <p class="font-body text-xs text-ems-muted/70 leading-relaxed mb-6 max-w-3xl">
        Cela ne signifie pas « aucun frais ni aucune obligation »&nbsp;: impôt sur le revenu, CFE,
        assurance et autres frais éventuels dépendent de votre situation. Les commissions encaissées
        font partie du chiffre d'affaires à déclarer. Être micro-entrepreneur ne dispense pas des
        engagements de loyauté liés à un emploi et ne garantit pas l'acceptation par EMS.
      </p>

      <!-- Détails liens officiels -->
      <details class="rounded-xl border border-ems-border bg-ems-dark p-5 mb-8 group">
        <summary class="font-body text-sm font-medium text-ems-green cursor-pointer list-none flex items-center gap-2">
          <span>Les liens officiels pour vous guider</span>
          <span aria-hidden="true" class="transition-transform group-open:rotate-90">›</span>
        </summary>
        <div class="mt-4 flex flex-col gap-2">
          <a
            v-for="link in officialLinks"
            :key="link.href"
            :href="link.href"
            target="_blank"
            rel="noopener noreferrer"
            class="font-body text-sm text-ems-muted hover:text-ems-green transition-colors"
          >
            {{ link.label }} <span aria-hidden="true">↗</span>
          </a>
        </div>
        <p class="mt-4 font-body text-xs text-ems-muted/60">
          Repères vérifiés le 26/10/2026. Les sites officiels précisent les conditions et les
          évolutions applicables à votre situation.
        </p>
      </details>

      <a
        href="#devenir"
        class="btn-primary inline-flex"
        @click.prevent="scrollToDevenir"
      >
        Déjà un SIRET&nbsp;? Transmettez vos informations →
      </a>
    </div>
  </section>
</template>

<script setup>
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches

function scrollToDevenir() {
  const el = document.getElementById('devenir')
  if (el) el.scrollIntoView({ behavior: reduced ? 'instant' : 'smooth', block: 'start' })
}

const steps = [
  {
    num: '01',
    title: 'Une demande, en ligne',
    body: "Préparez vos justificatifs puis déclarez votre activité réelle de mise en relation sur le Guichet unique. Vous pouvez faire la démarche vous-même. L'immatriculation est gratuite dans la plupart des cas\u00a0; l'attribution du SIRET intervient après traitement du dossier.",
    link: 'https://formalites.entreprises.gouv.fr/',
    linkLabel: 'Déclarer mon activité au Guichet unique',
  },
  {
    num: '02',
    title: 'Votre SIRET, puis le contrat',
    body: "Une fois votre SIRET obtenu, transmettez vos informations à EMS. Nous vous guidons sur les pièces à fournir pour préparer votre contrat. Vous avez déjà une entreprise\u00a0? Vérifiez simplement que cette activité est bien déclarée.",
    link: 'https://annuaire-entreprises.data.gouv.fr/',
    linkLabel: 'Retrouver mon SIRET et mon justificatif',
  },
  {
    num: '03',
    title: 'Des déclarations régulières',
    body: "Vous facturez à EMS les commissions dues, puis déclarez le chiffre d'affaires encaissé à l'Urssaf chaque mois ou trimestre. Les cotisations micro-sociales sont calculées sur ce chiffre d'affaires\u00a0: vous ne payez pas sur des commissions que vous n'avez pas encore encaissées.",
    link: 'https://www.autoentrepreneur.urssaf.fr/portail/accueil/une-question/toutes-les-fiches-pratiques/declarer-et-payer-mes-cotisation.html',
    linkLabel: 'Comprendre mes déclarations Urssaf',
  },
]

const officialLinks = [
  {
    href: 'https://entreprendre.service-public.gouv.fr/vosdroits/F36746',
    label: 'Comprendre les démarches de création',
  },
  {
    href: 'https://formalites.entreprises.gouv.fr/',
    label: 'Déclarer votre activité au Guichet unique',
  },
  {
    href: 'https://www.autoentrepreneur.urssaf.fr/portail/accueil/sinformer-sur-le-statut/lessentiel-du-statut.html',
    label: 'Comprendre les déclarations et cotisations Urssaf',
  },
  {
    href: 'https://entreprendre.service-public.gouv.fr/vosdroits/F36232',
    label: 'Vérifier les règles de cotisations sociales',
  },
]
</script>
