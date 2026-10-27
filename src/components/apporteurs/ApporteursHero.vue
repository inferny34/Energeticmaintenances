<template>
  <!-- HERO -->
  <header
    id="programme"
    class="relative overflow-hidden bg-ems-dark py-20 md:py-28"
    aria-labelledby="apporteurs-title"
  >
    <!-- Fond décoratif -->
    <div class="pointer-events-none absolute inset-0 bg-glow-green-tr" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-0 bg-dot-grid bg-dot opacity-30" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-6xl px-6">
      <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-16 items-center">

        <!-- Texte hero -->
        <div>
          <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-ems-green/20 bg-ems-green/10 px-4 py-1">
            <span class="font-display text-xs font-bold uppercase tracking-wider text-ems-green">
              Le Programme Apporteurs EMS
            </span>
          </div>

          <!-- Un seul h1 sur la page -->
          <h1
            id="apporteurs-title"
            class="mb-6 font-display font-extrabold uppercase leading-none tracking-tight text-white
                   text-3xl sm:text-4xl lg:text-5xl"
          >
            Une recommandation.<br>
            Un projet qui avance.<br>
            <span class="text-ems-green">Une énergie partagée.</span>
          </h1>

          <p class="mb-8 font-body text-base leading-relaxed text-ems-muted max-w-lg">
            Vous connaissez quelqu'un qui souhaite installer une borne de recharge&nbsp;?
            Mettez-nous en relation. EMS accompagne le projet, vous êtes rémunéré.
          </p>

          <div class="flex flex-wrap gap-4">
            <a
              href="#recommander"
              class="btn-primary"
              @click.prevent="scrollTo('recommander')"
            >
              Je recommande un client
            </a>
            <a
              href="#devenir"
              class="btn-outline"
              @click.prevent="scrollTo('devenir')"
            >
              Devenir apporteur
            </a>
          </div>
        </div>

        <!-- Encart rémunération -->
        <aside
          aria-label="Votre rémunération"
          class="rounded-2xl border border-ems-green/20 bg-ems-surface p-8 flex flex-col gap-4"
        >
          <div class="flex items-center justify-between">
            <span class="font-body text-xs uppercase tracking-widest text-ems-green">
              Le Programme Apporteurs EMS
            </span>
            <span aria-hidden="true" class="text-ems-green text-lg">↗</span>
          </div>

          <p class="font-display text-xl font-bold text-white leading-snug">
            Votre mise en relation,<br>notre reconnaissance.
          </p>

          <div class="flex items-baseline gap-2">
            <strong class="font-display font-extrabold text-white" style="font-size: clamp(2.5rem, 6vw, 4rem);">100</strong>
            <span class="font-body text-ems-green text-2xl font-bold">
              €<small class="block text-xs text-ems-muted font-normal">par borne</small>
            </span>
          </div>

          <p class="font-body text-sm text-ems-muted">
            Puis <strong class="text-white">130&nbsp;€</strong> à partir de la 11<sup>e</sup> borne
          </p>

          <p class="font-body text-xs text-ems-muted/70 leading-relaxed">
            100&nbsp;€ pour chacune des 10 premières bornes éligibles, puis 130&nbsp;€ à partir de la 11<sup>e</sup>.
            Forfait total, TVA comprise lorsqu'elle s'applique.
          </p>

          <div class="flex items-start gap-3 rounded-lg border border-ems-border bg-ems-dark/50 p-4">
            <span aria-hidden="true" class="text-ems-green mt-0.5">✓</span>
            <div>
              <strong class="font-body text-sm text-white">Un virement sous 30&nbsp;jours</strong>
              <span class="block font-body text-xs text-ems-muted">
                après installation et encaissement complet, selon le contrat
              </span>
            </div>
          </div>

          <button
            type="button"
            class="font-body text-sm text-ems-green underline text-left hover:text-white transition-colors"
            @click="$emit('open-contract', 0)"
          >
            Consulter les conditions du programme <span aria-hidden="true">↗</span>
          </button>
        </aside>

      </div>
    </div>
  </header>
</template>

<script setup>
import { useReveal } from '@/composables/useReveal.js'

defineEmits(['open-contract'])

const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches

function scrollTo(id) {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: reduced ? 'instant' : 'smooth', block: 'start' })
}

useReveal()
</script>
