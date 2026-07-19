<script setup>
// Pas de logique spécifique
</script>

<template>
  <section class="py-28 bg-ems-dark text-ems-text font-body" aria-labelledby="legal-title">
    <div class="max-w-4xl mx-auto px-6">
      
      <!-- Back button -->
      <a href="#" class="inline-flex items-center gap-2 text-ems-green hover:text-white transition-colors duration-200 mb-8 text-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour à l'accueil
      </a>

      <!-- Title -->
      <div class="mb-12">
        <span class="section-label">Informations légales</span>
        <h1 id="legal-title" class="section-title text-4xl sm:text-5xl">Mentions Légales</h1>
        <p class="section-sub mt-2">En vigueur au 19 juillet 2026</p>
      </div>

      <!-- Legal Content -->
      <div class="space-y-10 text-ems-muted leading-relaxed">
        
        <!-- Éditeur du site -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">1. Éditeur du site</h2>
          <p>Le site internet accessible à l'adresse <strong>https://energeticmaintenances.fr</strong> est édité par :</p>
          <ul class="list-none space-y-2 mt-4 text-ems-text bg-ems-surface border border-ems-border/50 rounded-lg p-5">
            <li><strong>Nom de l'entreprise :</strong> Energetic Maintenances Services</li>
            <li><strong>Forme juridique :</strong> SAS</li>
            <li><strong>Siège social :</strong> 34 Avenue de Sète 34560 Poussan</li>
            <li><strong>Numéro SIRET :</strong> 107 267 486 00010</li>
            <li><strong>Directeur de la publication :</strong> Philippe NADAL</li>
            <li><strong>Adresse e-mail de contact :</strong> <a href="mailto:contact@energeticmaintenances.fr" class="text-ems-green hover:underline">contact@energeticmaintenances.fr</a></li>
          </ul>
        </div>

        <!-- Hébergeur du site -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">2. Hébergeur</h2>
          <p>Le site internet est hébergé par la société :</p>
          <ul class="list-none space-y-2 mt-4 text-ems-text bg-ems-surface border border-ems-border/50 rounded-lg p-5">
            <li><strong>Raison sociale :</strong> O2Switch</li>
            <li><strong>Adresse :</strong> Chemin des Pardiaux, 63000 Clermont-Ferrand, France</li>
            <li><strong>Téléphone :</strong> +33 4 44 44 60 40</li>
            <li><strong>Site Internet :</strong> <a href="https://www.o2switch.fr" target="_blank" rel="noopener noreferrer" class="text-ems-green hover:underline">www.o2switch.fr</a></li>
          </ul>
        </div>

        <!-- Propriété intellectuelle -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">3. Propriété intellectuelle</h2>
          <p>
            L'ensemble de ce site (structure, design, logos, textes, éléments graphiques, photographies) constitue une œuvre protégée par la législation française et internationale sur le droit d'auteur et la propriété intellectuelle.
            Tous les droits de reproduction sont réservés. Toute reproduction, représentation ou diffusion, totale ou partielle, du contenu de ce site sur quelque support ou par tout procédé que ce soit, sans autorisation expresse et préalable de l'éditeur, est interdite et constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle.
          </p>
        </div>

        <!-- Responsabilité -->
        <div class="border-b border-ems-border/50 pb-8">
          <h2 class="font-display text-xl text-white uppercase tracking-wider mb-4">4. Limitation de responsabilité</h2>
          <p>
            L'éditeur s'efforce d'assurer au mieux de ses possibilités l'exactitude et la mise à jour des informations diffusées sur ce site. L'éditeur se réserve le droit de corriger, à tout moment et sans préavis, le contenu.
            Toutefois, l'éditeur ne peut garantir l'exactitude, la précision ou l'exhaustivité des informations mises à disposition sur ce site. En conséquence, l'éditeur décline toute responsabilité pour toute imprécision, inexactitude ou omission portant sur des informations disponibles sur le site.
          </p>
        </div>

      </div>

    </div>
  </section>
</template>
