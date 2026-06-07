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
  { label: 'Services',          href: '#services'     },
  { label: 'À Propos',          href: '#about'        },
  { label: 'Nos Engagements',   href: '#engagements'  },
  { label: "Zone d'intervention", href: '#zone'       },
  { label: 'Contact',           href: '#contact'      },
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
        <li v-for="link in links" :key="link.label">
          <a :href="link.href"
             :aria-label="'Aller à la section ' + link.label"
             class="font-body text-sm text-ems-muted hover:text-ems-text transition-colors duration-200">
            {{ link.label }}
          </a>
        </li>
      </ul>

      <!-- CTA + BURGER -->
      <div class="flex items-center gap-6">
        <!-- Nous contacter (Téléphone) -->
        <a href="tel:+33400000000" class="hidden md:flex items-center gap-2 text-sm font-body text-ems-muted hover:text-ems-text transition-colors">
          <svg class="text-ems-green w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Nous contacter
        </a>

        <a href="#contact"
           aria-label="Demander un devis gratuit"
           class="hidden md:inline-flex bg-ems-green text-ems-dark font-body font-bold text-xs px-5 py-2 rounded-full hover:bg-ems-green-alt transition-colors duration-200">
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
        <li v-for="link in links" :key="link.label">
          <a :href="link.href" @click="closeMenu"
             :aria-label="'Aller à la section ' + link.label"
             class="block font-body text-ems-muted hover:text-ems-text transition-colors duration-200 py-1">
            {{ link.label }}
          </a>
        </li>
        <li>
          <a href="tel:+33400000000" class="flex items-center gap-2 font-body text-ems-muted hover:text-ems-text py-1">
            <svg class="text-ems-green w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Nous contacter
          </a>
        </li>
        <li>
          <a href="#contact" @click="closeMenu"
             class="btn-primary inline-block text-sm text-center w-full mt-2 rounded-full">
            Devis gratuit
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>
