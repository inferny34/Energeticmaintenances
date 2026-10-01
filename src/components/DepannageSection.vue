<script setup>
// Pas de logique dynamique
</script>

<template>
  <section id="depannage" class="py-24 bg-[#0f1a2e] text-[#8a96a8]" aria-labelledby="depannage-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-16 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Dépannage & Conformité</span>
        </span>
        <h2 id="depannage-title" class="font-display font-extrabold text-white uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Une panne ? <span class="text-ems-green">On intervient.</span>
        </h2>
        <p class="font-body text-[#8a96a8] text-base max-w-2xl mx-auto leading-relaxed">
          Borne en erreur, disjoncteur qui saute, câblage défectueux — nous diagnostiquons et réparons rapidement vos installations électriques en <strong class="text-white">Occitanie et départements limitrophes</strong>.
        </p>
      </div>

      <!-- Grille pannes prises en charge -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">

        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-6 flex flex-col gap-3">
          <div class="w-10 h-10 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-white text-base uppercase">Borne en erreur ou bloquée</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            La borne ne démarre pas, affiche un code erreur ou reste bloquée en charge. Diagnostic et remise en service.
          </p>
        </div>

        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-6 flex flex-col gap-3">
          <div class="w-10 h-10 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-white text-base uppercase">Disjoncteur qui saute</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            La charge de votre véhicule fait disjoncter votre tableau. Identification de la surcharge et mise à niveau.
          </p>
        </div>

        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-6 flex flex-col gap-3">
          <div class="w-10 h-10 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-white text-base uppercase">Câblage défectueux</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Câble endommagé, connecteur oxydé ou chauffe anormale. Remplacement et vérification de conformité.
          </p>
        </div>

        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-6 flex flex-col gap-3">
          <div class="w-10 h-10 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-white text-base uppercase">Mise en conformité</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Installation non conforme NF C 15-100, absence de différentiel, mise à la terre insuffisante. Remise aux normes avec attestation.
          </p>
        </div>

        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-6 flex flex-col gap-3">
          <div class="w-10 h-10 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-white text-base uppercase">Remplacement de borne</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Borne vétuste ou incompatible avec votre nouveau véhicule. Dépose de l'ancienne et pose d'un modèle adapté.
          </p>
        </div>

        <div class="bg-[#162035] border border-[#1e2f4a] rounded-2xl p-6 flex flex-col gap-3">
          <div class="w-10 h-10 rounded-xl bg-ems-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-ems-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h3 class="font-display font-bold text-white text-base uppercase">Réactivité garantie</h3>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Réponse à votre demande en 48h ouvrées. Contactez-nous directement par téléphone pour les urgences.
          </p>
        </div>

      </div>

      <!-- Zone d'intervention + CTA -->
      <div class="bg-[#162035] border border-ems-green/20 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="flex flex-col gap-3 max-w-xl">
          <span class="font-body text-[10px] text-ems-green uppercase tracking-widest font-bold">Zone d'intervention</span>
          <p class="font-display font-extrabold text-white text-xl uppercase">
            Hérault, Gard et départements limitrophes
          </p>
          <p class="font-body text-sm text-[#8a96a8] leading-relaxed">
            Intervention sur 12 départements (34, 30, 13, 84, 07, 48, 12, 81, 11, 66, 09, 31). Contactez-nous pour échanger sur votre projet.
          </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
          <a href="#contact"
             class="inline-flex items-center justify-center bg-ems-green text-ems-dark font-body font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-ems-green-alt transition-colors">
            Demander un devis
          </a>
          <a href="tel:+33743708495"
             class="inline-flex items-center justify-center gap-2 bg-white/10 border border-white/20 text-white font-body font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-lg hover:bg-white/20 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            07 43 70 84 95
          </a>
        </div>
      </div>

    </div>
  </section>
</template>
