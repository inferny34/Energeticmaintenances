<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const scrolled  = ref(false)
const menuOpen  = ref(false)

function onScroll() { scrolled.value = window.scrollY > 50 }
function toggleMenu() { menuOpen.value = !menuOpen.value }
function closeMenu() { menuOpen.value = false }

onMounted(()  => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))

const links = [
  { label: 'Services',     href: '#services'     },
  { label: 'Engagements',  href: '#engagements'  },
  { label: 'Zone',         href: '#zone'         },
  { label: 'Contact',      href: '#contact'      },
]
</script>

<template>
  <nav
    :class="[
      'fixed top-0 w-full z-50 transition-all duration-300',
      scrolled
        ? 'bg-ems-dark/95 backdrop-blur-sm border-b border-ems-border shadow-lg'
        : 'bg-transparent'
    ]"
    aria-label="Navigation principale"
  >
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

      <!-- LOGO -->
      <a href="#hero" aria-label="Energetic Maintenance Services - Retour accueil"
         class="flex items-center gap-3">
        <img src="/logo.png" alt="Logo Energetic Maintenance Services" class="w-10 h-10 object-contain" />
        <span class="hidden sm:block font-body text-ems-muted text-xs leading-tight">
          Energetic Maintenance<br>Services
        </span>
      </a>

      <!-- LIENS DESKTOP -->
      <ul class="hidden md:flex items-center gap-8" role="list">
        <li v-for="link in links" :key="link.href">
          <a :href="link.href"
             :aria-label="'Aller à la section ' + link.label"
             class="font-body text-sm text-ems-muted hover:text-ems-text transition-colors duration-200">
            {{ link.label }}
          </a>
        </li>
      </ul>

      <!-- CTA + BURGER -->
      <div class="flex items-center gap-4">
        <a href="#contact"
           aria-label="Demander un devis gratuit"
           class="hidden md:inline-flex btn-primary text-sm py-2 px-5">
          Devis gratuit
        </a>

        <!-- Burger -->
        <button @click="toggleMenu"
                :aria-expanded="menuOpen"
                aria-controls="mobile-menu"
                aria-label="Ouvrir le menu de navigation"
                class="md:hidden text-ems-text p-1">
          <svg v-if="!menuOpen" width="22" height="22" viewBox="0 0 22 22" fill="none"
               xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <rect x="2" y="5"  width="18" height="2" rx="1" fill="currentColor"/>
            <rect x="2" y="10" width="18" height="2" rx="1" fill="currentColor"/>
            <rect x="2" y="15" width="18" height="2" rx="1" fill="currentColor"/>
          </svg>
          <svg v-else width="22" height="22" viewBox="0 0 22 22" fill="none"
               xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <line x1="4" y1="4" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="18" y1="4" x2="4"  y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- MENU MOBILE -->
    <div v-show="menuOpen" id="mobile-menu"
         class="md:hidden bg-ems-surface border-t border-ems-border px-6 py-4">
      <ul class="flex flex-col gap-4" role="list">
        <li v-for="link in links" :key="link.href">
          <a :href="link.href" @click="closeMenu"
             :aria-label="'Aller à la section ' + link.label"
             class="block font-body text-ems-muted hover:text-ems-text transition-colors duration-200 py-1">
            {{ link.label }}
          </a>
        </li>
        <li>
          <a href="#contact" @click="closeMenu"
             class="btn-primary inline-block text-sm text-center w-full mt-2">
            Devis gratuit
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>
