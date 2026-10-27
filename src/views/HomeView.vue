<script setup>
import { defineAsyncComponent } from 'vue'
import HeroSection from '../components/HeroSection.vue'

const BornesSection        = defineAsyncComponent(() => import('../components/BornesSection.vue'))
const DepannageSection     = defineAsyncComponent(() => import('../components/DepannageSection.vue'))
const ExpertiseProsSection = defineAsyncComponent(() => import('../components/ExpertiseProsSection.vue'))
const AboutSection         = defineAsyncComponent(() => import('../components/AboutSection.vue'))
const EngagementsSection   = defineAsyncComponent(() => import('../components/EngagementsSection.vue'))
const ZoneSection          = defineAsyncComponent(() => import('../components/ZoneSection.vue'))
const ParrainageSection    = defineAsyncComponent(() => import('../components/ParrainageSection.vue'))
const ContactSection       = defineAsyncComponent(() => import('../components/ContactSection.vue'))
</script>

<template>
  <main>
    <HeroSection />
    <BornesSection />
    <DepannageSection />
    <ExpertiseProsSection />
    <AboutSection />
    <EngagementsSection />
    <ZoneSection />
    <ParrainageSection />
    <ContactSection />
  </main>
</template>
