<script setup>
import { ref, reactive } from 'vue'

const form = reactive({
  company: '',
  email: '',
  phone: '',
  message: '',
  _hp: ''        // Honeypot anti-spam : doit rester vide
})
const submitted  = ref(false)
const submitting = ref(false)
const error      = ref(false)

async function handleSubmit() {
  if (!form.company || !form.email || !form.message) return
  submitting.value = true
  error.value = false
  try {
    const response = await fetch('/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        company: form.company,
        email:   form.email,
        phone:   form.phone,
        message: form.message,
        _hp:     form._hp      // Honeypot (vide chez les humains)
      })
    })
    const data = await response.json()
    if (data.success) {
      submitted.value = true
    } else {
      error.value = true
    }
  } catch {
    // Erreur réseau ou parsing JSON
    error.value = true
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <section id="contact" class="py-24 bg-[#f8fafc] text-slate-950" aria-labelledby="contact-title">
    <div class="max-w-6xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-16 flex flex-col items-center">
        <!-- Badge -->
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Contact & Devis</span>
        </span>
        
        <h2 id="contact-title" class="font-display font-extrabold text-slate-900 text-center uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Demandez votre <span class="text-ems-green">devis gratuit</span>
        </h2>
        
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Décrivez votre projet <strong class="text-slate-900">HTA ou IRVE</strong> et recevez une réponse personnalisée rapidement.
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Formulaire à gauche (7 cols) -->
        <div class="lg:col-span-7">
          <!-- Message de succès -->
          <div v-if="submitted"
               class="bg-white border border-ems-green/30 rounded-2xl p-10 text-center shadow-lg"
               role="alert" aria-live="polite">
            <svg class="mx-auto mb-4 text-ems-green" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" stroke-width="2"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
            </svg>
            <h3 class="font-display font-bold text-slate-900 text-2xl uppercase mb-2">Demande envoyée !</h3>
            <p class="font-body text-slate-600 text-sm">Nous vous répondrons dans les plus brefs délais.</p>
          </div>

          <!-- Formulaire -->
          <form v-else
                class="bg-white border border-slate-200/60 rounded-2xl p-8 flex flex-col gap-6 shadow-md"
                @submit.prevent="handleSubmit"
                aria-label="Formulaire de demande de devis">

            <!-- Nom entreprise -->
            <div>
              <label for="company" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                Nom de l'entreprise <span class="text-ems-green" aria-hidden="true">*</span>
              </label>
              <input id="company" v-model="form.company" type="text" required
                     placeholder="Votre entreprise ou nom"
                     autocomplete="organization"
                     class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 h-12 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200"
                     aria-required="true" />
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                Adresse email <span class="text-ems-green" aria-hidden="true">*</span>
              </label>
              <input id="email" v-model="form.email" type="email" required
                     placeholder="contact@exemple.fr"
                     autocomplete="email"
                     class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 h-12 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200"
                     aria-required="true" />
            </div>

            <!-- Téléphone -->
            <div>
              <label for="phone" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                Téléphone <span class="text-slate-400 text-[10px] font-normal lowercase">(facultatif)</span>
              </label>
              <input id="phone" v-model="form.phone" type="tel"
                     placeholder="+33 6 XX XX XX XX"
                     autocomplete="tel"
                     class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 h-12 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200" />
            </div>

            <!-- Message -->
            <div>
              <label for="message" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                Votre message <span class="text-ems-green" aria-hidden="true">*</span>
              </label>
              <!-- Honeypot anti-spam : invisible pour les humains, rempli par les bots -->
              <div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;pointer-events:none;tab-index:-1;">
                <label for="_hp">Ne pas remplir</label>
                <input id="_hp" v-model="form._hp" type="text" name="_hp" tabindex="-1" autocomplete="off" />
              </div>

              <textarea id="message" v-model="form.message" rows="5" required
                        placeholder="Décrivez votre projet, type d'installation HTA, IRVE, localisation dans le Sud de France, délais..."
                        autocomplete="off"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200 h-32 resize-y"
                        aria-required="true"></textarea>
            </div>

            <!-- Erreur -->
            <p v-if="error" class="font-body text-sm text-red-500" role="alert">
              Une erreur est survenue. Merci de réessayer ou de nous appeler directement.
            </p>

            <!-- Submit -->
            <button type="submit"
                    :disabled="submitting"
                    class="w-full bg-[#1b2a4a] text-white font-body font-bold text-xs uppercase tracking-wider py-4 rounded-lg hover:bg-ems-green hover:text-[#1b2a4a] disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300"
                    :aria-label="submitting ? 'Envoi en cours' : 'Envoyer la demande de devis'">
              {{ submitting ? 'Envoi en cours…' : 'Envoyer ma demande' }}
            </button>

            <!-- RGPD -->
            <p class="flex items-center justify-center gap-2 font-body text-[10px] text-slate-400 text-center">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/>
                <path d="M8 11V7a4 4 0 018 0v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              Vos données sont confidentielles et ne seront pas transmises à des tiers.
            </p>
          </form>
        </div>

        <!-- Coordonnées et urgence à droite (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6">
          
          <!-- Grille d'infos (4 cartes) -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Téléphone</span>
                <span class="text-sm font-bold text-slate-800">À renseigner</span>
              </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="min-w-0">
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Email</span>
                <a href="mailto:contact@energetic-ms.fr" class="text-xs font-bold text-slate-800 break-all hover:text-ems-green">contact@energetic-ms.fr</a>
              </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Zone d'intervention</span>
                <span class="text-sm font-bold text-slate-800">Sud de France</span>
              </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Disponibilité</span>
                <span class="text-sm font-bold text-slate-800">Lun - Ven + Astreinte</span>
              </div>
            </div>

          </div>

          <!-- Encadré Urgence bleu foncé -->
          <div class="bg-[#1b2a4a] text-white border border-ems-green/35 rounded-2xl p-6 shadow-lg flex flex-col gap-5 text-left">
            <div class="flex flex-col gap-2">
              <h4 class="font-display font-extrabold text-lg uppercase tracking-wide text-white">Urgence ou projet urgent ?</h4>
              <p class="font-body text-xs text-[#8a96a8] leading-relaxed">
                Contactez-nous directement pour une <strong class="text-white">intervention rapide dans le Sud de France</strong> sur vos installations <strong class="text-white">HTA ou IRVE</strong>.
              </p>
            </div>
            
            <a href="tel:+33400000000" class="inline-flex items-center justify-center gap-2 bg-[#5dbe3a] text-[#0f1a2e] font-body font-bold text-xs uppercase tracking-wider py-3.5 px-6 rounded-lg hover:bg-[#4caf50] transition-colors self-start">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              Appeler maintenant
            </a>
          </div>

        </div>

      </div>

    </div>
  </section>
</template>
