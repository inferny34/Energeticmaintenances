<script setup>
// Pas de logique dynamique nécessaire
</script>

<template>
  <footer class="bg-[#070e1a] text-slate-400 border-t border-[#1e2f4a] pt-16 pb-8 text-xs font-body" aria-label="Pied de page">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">

      <!-- Colonne 1 : Logo + tagline + Réseaux (5 cols) -->
      <div class="md:col-span-5 flex flex-col gap-6">
        <div class="flex items-center gap-3">
          <img src="/logo.png" alt="Logo Energetic Maintenance Services" class="w-10 h-10 object-contain flex-shrink-0" />
          <span class="font-display font-bold text-white text-sm uppercase tracking-wider leading-tight">
            Energetic Maintenance<br>Services
          </span>
        </div>
        <p class="text-[#8a96a8] leading-relaxed max-w-sm">
          Spécialiste <strong class="text-white">Haute Tension HTA</strong> et <strong class="text-white">IRVE</strong> dans le Sud de France. 20 ans d'expérience en agence d'intervention spécialisée Enedis. Certifié Qualifelec.
        </p>
        <!-- Coordonnées locales -->
        <p class="text-[#8a96a8]/70">
          Maintenance HTA & Bornes IRVE — Sud de France
        </p>
        <!-- Réseaux sociaux -->
        <div class="flex items-center gap-3">
          <a href="#" class="w-8 h-8 rounded-lg bg-[#162035] border border-[#1e2f4a] flex items-center justify-center text-white hover:text-ems-green hover:border-ems-green/55 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-lg bg-[#162035] border border-[#1e2f4a] flex items-center justify-center text-white hover:text-ems-green hover:border-ems-green/55 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
          </a>
        </div>
      </div>

      <!-- Colonne 2 : Liens rapides (3 cols) -->
      <div class="md:col-span-3">
        <h4 class="font-display font-bold text-white uppercase tracking-wider mb-5 text-sm">Liens rapides</h4>
        <ul class="flex flex-col gap-3" role="list">
          <li>
            <a href="#services" class="hover:text-white transition-colors">Services HTA & IRVE</a>
          </li>
          <li>
            <a href="#about" class="hover:text-white transition-colors">À Propos</a>
          </li>
          <li>
            <a href="#engagements" class="hover:text-white transition-colors">Nos Engagements</a>
          </li>
          <li>
            <a href="#zone" class="hover:text-white transition-colors">Zone d'intervention</a>
          </li>
          <li>
            <a href="#contact" class="hover:text-white transition-colors">Demander un devis</a>
          </li>
        </ul>
      </div>

      <!-- Colonne 3 : Contact et badge (4 cols) -->
      <div class="md:col-span-4 flex flex-col gap-6">
        <div>
          <h4 class="font-display font-bold text-white uppercase tracking-wider mb-5 text-sm">Contact</h4>
          <ul class="flex flex-col gap-3 text-[#8a96a8]" role="list">
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 flex-shrink-0 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
              <span>À renseigner</span>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 flex-shrink-0 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
              <a href="mailto:contact@energetic-ms.fr" class="hover:text-white transition-colors">contact@energetic-ms.fr</a>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 flex-shrink-0 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9" /></svg>
              <span>Sud de France <br><span class="text-[10px] text-slate-500 font-normal">Déplacements sur tout le territoire</span></span>
            </li>
          </ul>
        </div>

        <!-- Badge Qualifelec -->
        <div class="bg-[#162035] border border-[#1e2f4a] rounded-xl p-4 flex items-center gap-3 w-fit">
          <svg class="w-6 h-6 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
          <div>
            <span class="block font-display font-extrabold text-white text-xs uppercase tracking-wider">Certifié Qualifelec</span>
            <span class="text-[9px] text-[#8a96a8]">Professionnel certifié RGE / HTA</span>
          </div>
        </div>
      </div>

    </div>

    <!-- Copyright -->
    <div class="max-w-6xl mx-auto px-6 border-t border-[#1e2f4a]/50 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-[#8a96a8]/50">
      <p>© 2026 ENERGETIC MAINTENANCE SERVICES — Tous droits réservés — SIRET : 107 267 486 00010</p>
      <div class="flex items-center gap-4">
        <a href="#" class="hover:text-white transition-colors">Mentions légales</a>
        <span>·</span>
        <a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a>
      </div>
    </div>
  </footer>
</template>
