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
    <ParrainageSection />
    <DepannageSection />
    <ExpertiseProsSection />
    <AboutSection />
    <EngagementsSection />
    <ZoneSection />
    <ContactSection />
  </main>
</template>

<style scoped>
/* Les cartes gardent leurs couleurs propres ; les en-têtes suivent le fond. */
:deep(:is(#pros, #engagements, #contact) > div > .text-center > h2) {
  color: #fff;
}
:deep(:is(#pros, #engagements, #contact) > div > .text-center > p) {
  color: #aab6c6;
}
:deep(:is(#pros, #engagements, #contact) > div > .text-center .text-ems-green-dark) {
  color: #5dbe3a;
}
:deep(#contact > div > .text-center strong) {
  color: #fff;
}
:deep(#pros > div > .text-center > span) {
  background: rgb(93 190 58 / .1);
  border-color: rgb(93 190 58 / .2);
}
:deep(#pros > div > .text-center > span > span) {
  color: #5dbe3a;
}
:deep(#engagements > div > .text-center:last-child .text-slate-500) {
  color: #aab6c6;
}
</style>
