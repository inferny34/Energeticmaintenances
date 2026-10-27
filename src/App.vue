<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import NavBar from './components/NavBar.vue'
import FooterSection from './components/FooterSection.vue'

const router = useRouter()

onMounted(() => {
  // Rétrocompatibilité : si l'utilisateur arrive avec /#mentions ou /#privacy
  const hash = window.location.hash
  if (hash === '#mentions') {
    router.replace('/mentions')
  } else if (hash === '#privacy') {
    router.replace('/privacy')
  }
})
</script>

<template>
  <NavBar />
  <RouterView />
  <FooterSection />
</template>
