<script setup>
import NavBar             from './components/NavBar.vue'
import HeroSection        from './components/HeroSection.vue'
import ServicesSection    from './components/ServicesSection.vue'
import AboutSection       from './components/AboutSection.vue'
import EngagementsSection from './components/EngagementsSection.vue'
import ZoneSection        from './components/ZoneSection.vue'
import ContactSection     from './components/ContactSection.vue'
import FooterSection      from './components/FooterSection.vue'
</script>

<template>
  <NavBar />
  <main>
    <HeroSection />
    <ServicesSection />
    <AboutSection />
    <EngagementsSection />
    <ZoneSection />
    <ContactSection />
  </main>
  <FooterSection />
</template>
