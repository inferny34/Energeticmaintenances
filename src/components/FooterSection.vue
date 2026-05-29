<script setup>
const links = [
  { label: 'Services',    href: '#services'    },
  { label: 'Engagements', href: '#engagements' },
  { label: 'Zone',        href: '#zone'        },
  { label: 'Contact',     href: '#contact'     },
]
const certifs = ['Qualielec', 'IRVE P1/P2', 'Habilitation HTA']
</script>

<template>
  <footer class="bg-[#070E1A] border-t border-ems-border" aria-label="Pied de page">
    <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">

      <!-- Colonne 1 : Logo + tagline -->
      <div class="flex flex-col gap-3">
        <div class="flex items-center gap-3">
          <img src="/logo.png" alt="Logo Energetic Maintenance Services" class="w-10 h-10 object-contain flex-shrink-0" />
          <span class="font-body text-ems-muted text-xs leading-tight">
            Energetic Maintenance<br>Services
          </span>
        </div>
        <p class="font-body text-xs text-ems-muted/70 leading-relaxed max-w-xs">
          Votre expert électricité HTA & IRVE en Occitanie.
          Certifié Qualielec, 20 ans d'expérience Enedis.
        </p>
      </div>

      <!-- Colonne 2 : Navigation -->
      <nav aria-label="Navigation rapide du footer">
        <p class="font-body text-xs text-ems-muted uppercase tracking-widest mb-4">Navigation</p>
        <ul class="flex flex-col gap-2" role="list">
          <li v-for="link in links" :key="link.href">
            <a :href="link.href"
               :aria-label="'Aller à la section ' + link.label"
               class="font-body text-sm text-ems-muted/70 hover:text-ems-text transition-colors duration-200">
              {{ link.label }}
            </a>
          </li>
        </ul>
      </nav>

      <!-- Colonne 3 : Certifications -->
      <div>
        <p class="font-body text-xs text-ems-muted uppercase tracking-widest mb-4">Agréments</p>
        <ul class="flex flex-col gap-2" role="list">
          <li v-for="c in certifs" :key="c"
              class="flex items-center gap-2 font-body text-sm text-ems-muted/70">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#5DBE3A" stroke-width="2"/>
            </svg>
            {{ c }}
          </li>
        </ul>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-ems-border/40 py-4 text-center">
      <p class="font-body text-xs text-ems-muted/40">
        © 2025 Energetic Maintenance Services · Tous droits réservés ·
        <a href="#" class="hover:text-ems-muted transition-colors" aria-label="Mentions légales">Mentions légales</a>
        · SIRET [À RENSEIGNER]
      </p>
    </div>
  </footer>
</template>
