<script setup>
import NavBar             from './components/NavBar.vue'
import HeroSection        from './components/HeroSection.vue'
import ServicesSection    from './components/ServicesSection.vue'
import EngagementsSection from './components/EngagementsSection.vue'
import AboutSection       from './components/AboutSection.vue'
import ZoneSection        from './components/ZoneSection.vue'
import ContactSection     from './components/ContactSection.vue'
import FooterSection      from './components/FooterSection.vue'
</script>

<template>
  <NavBar />
  <main>
    <HeroSection />
    <ServicesSection />
    <EngagementsSection />
    <AboutSection />
    <ZoneSection />
    <ContactSection />
  </main>
  <FooterSection />
</template>
