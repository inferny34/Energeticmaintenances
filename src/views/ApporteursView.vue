<script setup>
import { ref, onMounted, nextTick } from 'vue'
import ApporteursHero from '../components/apporteurs/ApporteursHero.vue'
import ApporteursSteps from '../components/apporteurs/ApporteursSteps.vue'
import ApporteursConditions from '../components/apporteurs/ApporteursConditions.vue'
import MicroGuide from '../components/apporteurs/MicroGuide.vue'
import JourneyTabs from '../components/apporteurs/JourneyTabs.vue'
import ApporteursFaq from '../components/apporteurs/ApporteursFaq.vue'
import ContractReader from '../components/apporteurs/ContractReader.vue'
import '../assets/css/apporteurs.css'

const contractReaderRef = ref(null)
const journeyTabsRef = ref(null)

function onOpenContract(page = 0) {
  contractReaderRef.value?.open(page)
}

function onJumpLoyalty() {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  // Bascule sur l'onglet recommander
  const choiceBtn = document.getElementById('choice-recommander')
  if (choiceBtn) {
    choiceBtn.click()
  }
  nextTick(() => {
    const section = document.getElementById('engagement-loyaute')
    if (section) {
      section.scrollIntoView({ behavior: reduced ? 'instant' : 'smooth', block: 'start' })
      const title = document.getElementById('loyalty-title')
      title?.focus({ preventScroll: true })
    }
  })
}

onMounted(() => {
  // Gestion du hash initial si l'utilisateur arrive directement avec #lecture-contrat
  if (window.location.hash === '#lecture-contrat') {
    onOpenContract(0)
  }
})
</script>

<template>
  <div class="apporteurs-page">
    <ApporteursHero @open-contract="onOpenContract" />
    <ApporteursSteps />
    <ApporteursConditions
      @open-contract="onOpenContract"
      @jump-loyalty="onJumpLoyalty"
    />
    <MicroGuide />
    <JourneyTabs
      ref="journeyTabsRef"
      @open-contract="onOpenContract"
    />
    <ApporteursFaq />

    <!-- Lecteur de contrat en modal dialog natif -->
    <ContractReader ref="contractReaderRef" />
  </div>
</template>
