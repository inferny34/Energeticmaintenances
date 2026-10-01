<script setup>
import { ref, onMounted, onUnmounted, nextTick, defineAsyncComponent } from 'vue'
import NavBar             from './components/NavBar.vue'
import HeroSection        from './components/HeroSection.vue'

const BornesSection        = defineAsyncComponent(() => import('./components/BornesSection.vue'))
const DepannageSection     = defineAsyncComponent(() => import('./components/DepannageSection.vue'))
const ExpertiseProsSection = defineAsyncComponent(() => import('./components/ExpertiseProsSection.vue'))
const AboutSection         = defineAsyncComponent(() => import('./components/AboutSection.vue'))
const EngagementsSection   = defineAsyncComponent(() => import('./components/EngagementsSection.vue'))
const ZoneSection          = defineAsyncComponent(() => import('./components/ZoneSection.vue'))
const ParrainageSection    = defineAsyncComponent(() => import('./components/ParrainageSection.vue'))
const ContactSection       = defineAsyncComponent(() => import('./components/ContactSection.vue'))
const FooterSection        = defineAsyncComponent(() => import('./components/FooterSection.vue'))
const MentionsLegales      = defineAsyncComponent(() => import('./components/MentionsLegales.vue'))
const PolitiqueConfidentialite = defineAsyncComponent(() => import('./components/PolitiqueConfidentialite.vue'))

// Section masquée (en attente de photos et autorisations)
// const RealisationsSection = defineAsyncComponent(() => import('./components/RealisationsSection.vue'))

const currentView = ref('home')

function handleHashChange() {
  const hash = window.location.hash
  if (hash === '#mentions') {
    currentView.value = 'mentions'
    window.scrollTo({ top: 0, behavior: 'instant' })
  } else if (hash === '#privacy') {
    currentView.value = 'privacy'
    window.scrollTo({ top: 0, behavior: 'instant' })
  } else {
    const wasHome = currentView.value === 'home'
    currentView.value = 'home'

    // Si on vient d'une page légale et qu'il y a un hash, attente du rendu DOM
    if (!wasHome && hash) {
      nextTick(() => {
        const element = document.querySelector(hash)
        if (element) {
          element.scrollIntoView({ behavior: 'smooth' })
        }
      })
    }
  }
}

onMounted(() => {
  window.addEventListener('hashchange', handleHashChange)
  handleHashChange()
})

onUnmounted(() => {
  window.removeEventListener('hashchange', handleHashChange)
})
</script>

<template>
  <NavBar />
  <main v-if="currentView === 'home'">
    <HeroSection />
    <BornesSection />
    <DepannageSection />
    <ExpertiseProsSection />
    <AboutSection />
    <EngagementsSection />
    <ZoneSection />
    <ParrainageSection />
    <!-- <RealisationsSection /> -->
    <ContactSection />
  </main>
  <MentionsLegales v-else-if="currentView === 'mentions'" />
  <PolitiqueConfidentialite v-else-if="currentView === 'privacy'" />
  <FooterSection />
</template>
