<script setup>
import { ref, reactive } from 'vue'

const form = reactive({
  company: '',
  email: '',
  phone: '',
  message: ''
})
const submitted  = ref(false)
const submitting = ref(false)
const error      = ref(false)

async function handleSubmit() {
  if (!form.company || !form.email || !form.message) return
  submitting.value = true
  error.value = false
  try {
    // Remplacer par votre endpoint réel (Netlify Forms, FormSubmit, EmailJS, etc.)
    await new Promise(resolve => setTimeout(resolve, 900)) // Simulé
    submitted.value = true
  } catch {
    error.value = true
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <section id="contact" class="py-24 bg-[#0c1524]" aria-labelledby="contact-title">
    <div class="max-w-2xl mx-auto px-6">

      <!-- En-tête -->
      <div class="text-center mb-10 flex flex-col items-center">
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green">Contactez-nous</span>
        </span>
        <h2 id="contact-title" class="section-title mb-3">Demandez votre devis gratuit</h2>
        <p class="font-body text-ems-muted text-base">
          Décrivez votre projet HTA ou IRVE et recevez une réponse personnalisée rapidement.
        </p>
      </div>

      <!-- Message de succès -->
      <div v-if="submitted"
           class="bg-ems-surface border border-ems-green/50 rounded-xl p-10 text-center"
           role="alert" aria-live="polite">
        <svg class="mx-auto mb-4" width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
          <circle cx="24" cy="24" r="22" stroke="#5DBE3A" stroke-width="2"/>
          <path d="M14 24l7 7 13-14" stroke="#5DBE3A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <h3 class="font-display font-bold text-ems-text text-2xl uppercase mb-2">Demande envoyée !</h3>
        <p class="font-body text-ems-muted text-sm">Nous vous répondrons dans les plus brefs délais.</p>
      </div>

      <!-- Formulaire -->
      <form v-else
            class="bg-ems-surface border border-ems-border rounded-xl p-8 flex flex-col gap-5"
            @submit.prevent="handleSubmit"
            aria-label="Formulaire de demande de devis">

        <!-- Nom entreprise -->
        <div>
          <label for="company" class="form-label">
            Nom de l'entreprise <span class="text-ems-green" aria-hidden="true">*</span>
          </label>
          <input id="company" v-model="form.company" type="text" required
                 placeholder="Votre entreprise ou nom"
                 class="form-input"
                 aria-required="true" />
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="form-label">
            Adresse email <span class="text-ems-green" aria-hidden="true">*</span>
          </label>
          <input id="email" v-model="form.email" type="email" required
                 placeholder="contact@exemple.fr"
                 class="form-input"
                 aria-required="true" />
        </div>

        <!-- Téléphone -->
        <div>
          <label for="phone" class="form-label">
            Téléphone <span class="text-ems-muted text-xs font-normal">(facultatif)</span>
          </label>
          <input id="phone" v-model="form.phone" type="tel"
                 placeholder="+33 6 XX XX XX XX"
                 class="form-input" />
        </div>

        <!-- Message -->
        <div>
          <label for="message" class="form-label">
            Votre message <span class="text-ems-green" aria-hidden="true">*</span>
          </label>
          <textarea id="message" v-model="form.message" rows="5" required
                    placeholder="Décrivez votre projet, votre localisation, vos besoins..."
                    class="form-input h-auto py-3 resize-y"
                    aria-required="true"></textarea>
        </div>

        <!-- Erreur -->
        <p v-if="error" class="font-body text-sm text-red-400" role="alert">
          Une erreur est survenue. Merci de réessayer ou de nous appeler directement.
        </p>

        <!-- Submit -->
        <button type="submit"
                :disabled="submitting"
                class="btn-primary w-full h-12 font-display font-bold text-base uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed"
                :aria-label="submitting ? 'Envoi en cours' : 'Envoyer la demande de devis'">
          {{ submitting ? 'Envoi en cours…' : 'Envoyer ma demande' }}
        </button>

        <!-- RGPD -->
        <p class="flex items-center justify-center gap-2 font-body text-xs text-ems-muted/60 text-center">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="5" y="11" width="14" height="10" rx="2" stroke="#8A96A8" stroke-width="2"/>
            <path d="M8 11V7a4 4 0 018 0v4" stroke="#8A96A8" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Vos données sont confidentielles et ne seront pas transmises à des tiers.
        </p>
      </form>
    </div>
  </section>
</template>
