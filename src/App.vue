<script setup>
import { onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import NavBar from './components/NavBar.vue'
import FooterSection from './components/FooterSection.vue'

const router = useRouter()

function checkLegalHash() {
  const hash = window.location.hash
  if (hash === '#mentions') {
    router.replace('/mentions')
  } else if (hash === '#privacy') {
    router.replace('/privacy')
  }
}

onMounted(() => {
  window.addEventListener('hashchange', checkLegalHash)
  checkLegalHash()
})

onUnmounted(() => {
  window.removeEventListener('hashchange', checkLegalHash)
})
</script>

<template>
  <NavBar />
  <main class="min-h-[calc(100vh-4rem)] flex flex-col">
    <RouterView />
  </main>
  <FooterSection />
</template>
