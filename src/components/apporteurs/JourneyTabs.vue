<template>
  <!-- ONGLETS JOURNEY : Devenir apporteur / Recommander un client -->
  <section id="formulaires" class="py-20 bg-ems-dark" aria-labelledby="formulaires-title">
    <div class="mx-auto max-w-6xl px-6">
      <p class="section-label">03 / Votre demande</p>
      <h2 id="formulaires-title" class="section-title mb-4">Devenir apporteur EMS</h2>
      <p class="section-sub mb-8">
        Constituez votre dossier professionnel complet.
        Déjà partenaire EMS&nbsp;? Utilisez le formulaire de recommandation client.
      </p>

      <!-- Onglets ARIA -->
      <div
        role="tablist"
        aria-label="Choisir votre démarche"
        class="flex flex-col sm:flex-row gap-2 mb-8"
      >
        <button
          id="choice-devenir"
          role="tab"
          :aria-selected="activeTab === 'devenir'"
          :tabindex="activeTab === 'devenir' ? 0 : -1"
          :aria-controls="ids.panelDevenir"
          class="flex-1 flex flex-col items-start p-4 rounded-xl border transition-all duration-200"
          :class="activeTab === 'devenir'
            ? 'border-ems-green bg-ems-green/10 text-white'
            : 'border-ems-border bg-ems-surface/40 text-ems-muted hover:border-ems-green/40'"
          @click="selectTab('devenir')"
          @keydown="onTabKeydown($event, 'devenir')"
        >
          <strong class="font-body font-bold text-sm">Devenir apporteur</strong>
          <span class="font-body text-xs mt-0.5 opacity-70">Préparer mon contrat et mon dossier</span>
        </button>

        <button
          id="choice-recommander"
          role="tab"
          :aria-selected="activeTab === 'recommander'"
          :tabindex="activeTab === 'recommander' ? 0 : -1"
          :aria-controls="ids.panelRecommander"
          class="flex-1 flex flex-col items-start p-4 rounded-xl border transition-all duration-200"
          :class="activeTab === 'recommander'
            ? 'border-ems-green bg-ems-green/10 text-white'
            : 'border-ems-border bg-ems-surface/40 text-ems-muted hover:border-ems-green/40'"
          @click="selectTab('recommander')"
          @keydown="onTabKeydown($event, 'recommander')"
        >
          <strong class="font-body font-bold text-sm">Recommander un client</strong>
          <span class="font-body text-xs mt-0.5 opacity-70">J'ai déjà mon contrat signé avec EMS</span>
        </button>
      </div>

      <!-- Panneaux -->
      <div
        :id="ids.panelDevenir"
        id="devenir"
        role="tabpanel"
        aria-labelledby="choice-devenir"
        :hidden="activeTab !== 'devenir'"
      >
        <RegistrationForm @open-contract="(page) => $emit('open-contract', page)" />
      </div>

      <div
        :id="ids.panelRecommander"
        id="recommander"
        role="tabpanel"
        aria-labelledby="choice-recommander"
        :hidden="activeTab !== 'recommander'"
      >
        <ReferralForm @open-contract="(page) => $emit('open-contract', page)" />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, useId, onMounted, nextTick } from 'vue'
import RegistrationForm from './RegistrationForm.vue'
import ReferralForm from './ReferralForm.vue'

const props = defineProps({
  /** Onglet initial (depuis l'ancre de l'URL ou prop parent) */
  initialTab: {
    type: String,
    default: 'devenir',
    validator: v => ['devenir', 'recommander'].includes(v),
  },
})

const emit = defineEmits(['open-contract'])

const _id = useId()
const ids = {
  panelDevenir: `${_id}-panel-devenir`,
  panelRecommander: `${_id}-panel-recommander`,
}

const activeTab = ref(props.initialTab)
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches

function selectTab(name, focusHeading = false) {
  activeTab.value = name
  if (focusHeading) {
    nextTick(() => {
      const panel = document.getElementById(name)
      const heading = panel?.querySelector('h3[tabindex="-1"]')
      heading?.focus({ preventScroll: true })
    })
  }
}

function onTabKeydown(event, current) {
  if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return
  event.preventDefault()
  const tabs = ['devenir', 'recommander']
  const currentIdx = tabs.indexOf(current)
  let nextIdx
  if (event.key === 'Home') nextIdx = 0
  else if (event.key === 'End') nextIdx = tabs.length - 1
  else if (event.key === 'ArrowLeft') nextIdx = currentIdx === 0 ? tabs.length - 1 : currentIdx - 1
  else nextIdx = currentIdx === tabs.length - 1 ? 0 : currentIdx + 1

  selectTab(tabs[nextIdx])
  document.getElementById(`choice-${tabs[nextIdx]}`)?.focus()
}

// Activation par lien d'ancre depuis la page
function handleHash() {
  const hash = window.location.hash.slice(1)
  if (hash === 'devenir' || hash === 'recommander') {
    selectTab(hash, false)
  }
}

onMounted(() => {
  handleHash()
  window.addEventListener('hashchange', handleHash)
})
</script>
