<template>
  <!-- FAQ -->
  <section id="questions" class="py-20 bg-ems-surface/20" aria-labelledby="faq-title">
    <div class="mx-auto max-w-4xl px-6">
      <p class="section-label">04 / Les réponses utiles</p>
      <h2 id="faq-title" class="section-title mb-10">Questions fréquentes</h2>

      <div class="space-y-3">
        <details
          v-for="item in faq"
          :key="item.question"
          class="group rounded-xl border border-ems-border bg-ems-dark overflow-hidden"
        >
          <summary
            class="flex items-center justify-between gap-4 px-6 py-4 cursor-pointer list-none
                   font-body font-medium text-sm text-ems-text hover:text-white transition-colors"
          >
            {{ item.question }}
            <span
              aria-hidden="true"
              class="text-ems-green flex-shrink-0 text-lg transition-transform duration-200 group-open:rotate-45"
            >+</span>
          </summary>
          <div class="px-6 pb-5">
            <p class="font-body text-sm text-ems-muted leading-relaxed">{{ item.answer }}</p>
          </div>
        </details>
      </div>
    </div>
  </section>
</template>

<script setup>
const faq = [
  {
    question: 'Faut-il être professionnel pour devenir apporteur\u00a0?',
    answer: 'Oui. Le programme est réservé aux entreprises et micro-entreprises disposant d\u2019un SIRET. Les particuliers sont exclus et ne sont pas rémunérés. Chaque commission est réglée sur facture conforme.',
  },
  {
    question: '100\u00a0€ ou 130\u00a0€\u00a0: comment fonctionne le palier\u00a0?',
    answer: 'Les 10 premières bornes ouvrant droit à commission sont à 100\u00a0€. À partir de la 11\u1d49 borne, le forfait passe à 130\u00a0€. Le compteur suit le contrat, renouvellements compris. Ces montants incluent la TVA lorsqu\u2019elle s\u2019applique.',
  },
  {
    question: 'Quand suis-je payé\u00a0?',
    answer: 'Après installation et encaissement complet de la facture du chantier, sous 30 jours calendaires selon le contrat, sur facture et avec les documents requis. Aucun acompte client ne déclenche de commission partielle.',
  },
  {
    question: 'Un contact lié à mon emploi est-il possible\u00a0?',
    answer: 'Déclarez l\u2019origine du contact et vos liens professionnels. EMS examine la situation selon l\u2019article\u00a07. La fiche client et l\u2019engagement de loyauté signés, avec les autorisations nécessaires, restent demandés pour les projets concernés.',
  },
  {
    question: 'Et si le client ne signe pas ou ne paie pas\u00a0?',
    answer: 'Aucune commission n\u2019est due si le client ne signe pas, annule ou ne paie pas. Il doit signer son devis dans les 12 mois suivant la présentation complète retenue, selon le contrat.',
  },
  {
    question: 'Puis-je arrêter quand je veux\u00a0?',
    answer: 'Oui, par écrit, avec un préavis de 30 jours calendaires à compter de la réception, sous réserve des dispositions du contrat et des règles impératives. Les présentations acceptées avant la fin gardent leurs droits selon l\u2019article\u00a05.',
  },
]
</script>
