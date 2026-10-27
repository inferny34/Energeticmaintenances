<template>
  <!-- CONDITIONS + ZONE -->
  <section
    id="conditions"
    class="py-20 bg-ems-surface/30"
    aria-labelledby="conditions-title"
  >
    <div class="mx-auto max-w-6xl px-6">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        <!-- Colonne gauche : conditions + callouts -->
        <div class="lg:col-span-2 space-y-10">
          <div>
            <p class="section-label">02 / Le cadre du partenariat</p>
            <h2 id="conditions-title" class="section-title">Les conditions en bref</h2>
          </div>

          <!-- 6 cartes de conditions -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <article
              v-for="cond in conditions"
              :key="cond.tag"
              class="rounded-xl border border-ems-border bg-ems-dark p-6 flex flex-col gap-2"
            >
              <span class="font-body text-xs uppercase tracking-widest text-ems-green">
                {{ cond.tag }}
              </span>
              <h3 class="font-display font-bold text-white text-base uppercase" v-html="cond.title"></h3>
              <p class="font-body text-sm text-ems-muted leading-relaxed">{{ cond.body }}</p>
            </article>
          </div>

          <!-- Callout lecture contrat -->
          <aside
            id="lecture-contrat"
            class="rounded-xl border border-ems-green/20 bg-ems-dark p-6 space-y-3"
          >
            <span class="section-label">À lire avant de vous engager</span>
            <h3 class="font-display font-bold text-white text-lg uppercase">
              Le contrat fixe les règles.
            </h3>
            <p class="font-body text-sm text-ems-muted leading-relaxed">
              Lisez attentivement les conditions générales du contrat d'apporteur avant de signer&nbsp;:
              éligibilité du client, zone, délais, commission et obligations de chacun.
              Cette page en présente seulement un résumé.
            </p>
            <button
              type="button"
              class="btn-primary text-sm"
              @click="$emit('open-contract', 0)"
            >
              Lire le contrat vierge ↗
            </button>
            <p class="font-body text-xs text-ems-muted/60 leading-relaxed">
              Consultez le modèle complet ici, puis demandez votre contrat à compléter.
              La lecture du modèle ne vaut pas signature.
            </p>
          </aside>

          <!-- Note professionnels -->
          <aside class="rounded-xl border border-ems-border bg-ems-dark p-6 space-y-3">
            <h3 class="font-display font-bold text-white text-base uppercase">
              Vous exercez en entreprise ou en micro-entreprise&nbsp;?
            </h3>
            <p class="font-body text-sm text-ems-muted leading-relaxed">
              Un SIRET et une facture conforme sont nécessaires. Déclarez votre régime de TVA et
              remettez les justificatifs prévus au contrat. Un contact lié à votre emploi ou à un
              mandant doit être déclaré&nbsp;: les engagements de loyauté et les autorisations
              nécessaires restent applicables à chaque client présenté.
            </p>
            <p class="font-body text-sm">
              <a
                href="#recommander"
                class="text-ems-green underline hover:text-white transition-colors"
                @click.prevent="$emit('jump-loyalty')"
              >
                Contact lié à un emploi&nbsp;? Comprendre l'engagement de loyauté →
              </a>
            </p>
          </aside>
        </div>

        <!-- Colonne droite : zone -->
        <div>
          <div class="sticky top-24 rounded-xl border border-ems-border bg-ems-dark p-6 space-y-5">
            <h3 class="font-display font-bold text-white uppercase text-base">
              Notre zone d'intervention
            </h3>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="zone in zones"
                :key="zone.code"
                class="inline-flex items-center gap-1.5 rounded-full bg-ems-green/10 border border-ems-green/20
                       px-3 py-1 font-body text-sm text-ems-text"
              >
                <b class="font-bold text-ems-green">{{ zone.code }}</b>
                {{ zone.label }}
              </span>
            </div>
            <p class="font-body text-xs text-ems-muted/70 leading-relaxed">
              Le lieu du chantier compte, pas votre adresse.
              Les éventuels frais de déplacement sont précisés dans le devis adressé au client.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ZONES } from '@/constants/zones.js'

defineEmits(['open-contract', 'jump-loyalty'])

const zones = ZONES

const conditions = [
  {
    tag: '01 / La commission',
    title: '<strong>100&nbsp;€</strong> puis <strong>130&nbsp;€</strong>',
    body: '100&nbsp;€ pour les 10 premières bornes éligibles, puis 130&nbsp;€ à partir de la 11e. TVA comprise si applicable.',
  },
  {
    tag: '02 / Votre statut',
    title: 'Un SIRET, une facture',
    body: 'Entreprises et micro-entreprises uniquement. Les particuliers ne sont pas rémunérés.',
  },
  {
    tag: '03 / Le bon projet',
    title: 'Une borne de 7 à 22&nbsp;kW',
    body: 'Installation en courant alternatif. Les travaux liés sont inclus dans le forfait borne\u00a0; la HTA est exclue.',
  },
  {
    tag: '04 / Le délai client',
    title: '12 mois pour signer',
    body: 'Le client doit signer son devis dans les 12 mois de la présentation complète retenue.',
  },
  {
    tag: '05 / La présentation',
    title: 'Un écrit, une réponse',
    body: 'La première présentation complète reçue fait foi. EMS répond sous 7 jours calendaires\u00a0; son silence ne vaut pas acceptation.',
  },
  {
    tag: '06 / Votre rôle',
    title: 'Vous faites le lien',
    body: 'Pas de négociation ni de signature au nom d\u2019EMS. Nous prenons le relais pour le devis et les travaux.',
  },
]
</script>
