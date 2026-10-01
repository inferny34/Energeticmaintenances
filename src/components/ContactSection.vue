<script setup>
import { ref, reactive, computed } from 'vue'

const projectTypes = [
  { value: 'borne-domicile', label: 'Borne à domicile',        icon: '🏠' },
  { value: 'depannage',      label: 'Dépannage / Conformité',  icon: '🔧' },
  { value: 'projet-pro',     label: 'Projet professionnel',    icon: '🏭' },
]

const form = reactive({
  projectType: '',
  name:        '',
  postalCode:  '',
  phone:       '',
  email:       '',
  referredBy:  '',
  message:     '',
  consent:     false,    // Case RGPD obligatoire (jamais pré-cochée)
  _hp:         ''        // Honeypot anti-spam
})

const submitted  = ref(false)
const submitting = ref(false)
const error      = ref(false)
const errorMessage = ref('')

// Placeholder message dynamique selon le besoin
const messagePlaceholder = computed(() => {
  if (form.projectType === 'borne-domicile')
    return 'Décrivez votre projet : type de logement (maison/appart), garage, puissance souhaitée (7 à 22 kW), véhicule...'
  if (form.projectType === 'depannage')
    return 'Décrivez la panne constatée : borne en erreur, disjoncteur qui saute, marque de la borne...'
  if (form.projectType === 'projet-pro')
    return 'Décrivez votre besoin : poste HTA, flotte d\'entreprise, copropriété, puissance, localisation...'
  return 'Décrivez votre besoin...'
})

// Validation : nom, code postal, message, consentement RGPD, et au moins un moyen de contact (téléphone OU email)
const hasContactMethod = computed(() => form.phone.trim() !== '' || form.email.trim() !== '')

const isValid = computed(() =>
  form.name.trim() !== '' &&
  form.postalCode.trim() !== '' &&
  hasContactMethod.value &&
  form.message.trim() !== '' &&
  form.consent === true
)

async function handleSubmit() {
  if (!isValid.value) {
    if (!form.consent) {
      errorMessage.value = 'Veuillez accepter la politique de confidentialité pour envoyer votre demande.'
      error.value = true
    } else if (!hasContactMethod.value) {
      errorMessage.value = 'Veuillez renseigner au moins un moyen de contact (téléphone ou email).'
      error.value = true
    }
    return
  }

  submitting.value = true
  error.value = false
  errorMessage.value = ''

  try {
    const response = await fetch('/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        projectType: form.projectType,
        name:        form.name,
        postalCode:  form.postalCode,
        phone:       form.phone,
        email:       form.email,
        referredBy:  form.referredBy,
        message:     form.message,
        consent:     form.consent,
        _hp:         form._hp
      })
    })
    const data = await response.json()
    if (data.success) {
      submitted.value = true
    } else {
      errorMessage.value = data.error || 'Une erreur est survenue. Merci de réessayer ou de nous appeler.'
      error.value = true
    }
  } catch {
    errorMessage.value = 'Une erreur réseau est survenue. Merci de nous contacter par téléphone.'
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
        <span class="inline-flex items-center justify-center bg-ems-green/10 border border-ems-green/20 rounded-full px-4 py-1 mb-4">
          <span class="font-display font-bold text-xs uppercase tracking-wider text-ems-green-dark">Contact & Devis</span>
        </span>
        <h2 id="contact-title" class="font-display font-extrabold text-slate-900 text-center uppercase tracking-tight mb-4 leading-none text-2xl sm:text-4xl">
          Demandez votre <span class="text-ems-green-dark">devis gratuit</span>
        </h2>
        <p class="font-body text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
          Réponse à votre demande en <strong class="text-slate-900">48h ouvrées</strong>. Pour une urgence, appelez directement le <a href="tel:+33743708495" class="text-ems-green-dark font-bold hover:underline">07 43 70 84 95</a>.
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

        <!-- Formulaire à gauche (7 cols) -->
        <div class="lg:col-span-7">

          <!-- Message de succès -->
          <div v-if="submitted"
               class="bg-white border border-ems-green/30 rounded-2xl p-10 text-center shadow-lg"
               role="alert" aria-live="polite">
            <svg class="mx-auto mb-4 text-ems-green" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <circle cx="12" cy="12" r="10" stroke-width="2"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
            </svg>
            <h3 class="font-display font-bold text-slate-900 text-2xl uppercase mb-2">Demande envoyée !</h3>
            <p class="font-body text-slate-600 text-sm">Votre message a bien été transmis. Nous vous répondrons en 48h ouvrées.</p>
          </div>

          <!-- Formulaire -->
          <form v-else
                class="bg-white border border-slate-200/60 rounded-2xl p-8 flex flex-col gap-6 shadow-md"
                @submit.prevent="handleSubmit"
                aria-label="Formulaire de demande de devis">

            <!-- Honeypot anti-spam : invisible pour les humains -->
            <div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;pointer-events:none;">
              <label for="_hp">Ne pas remplir</label>
              <input id="_hp" v-model="form._hp" type="text" name="_hp" tabindex="-1" autocomplete="off" />
            </div>

            <!-- Étape 1 : Type de besoin -->
            <fieldset>
              <legend class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-3">
                Mon besoin <span class="text-slate-400 font-normal lowercase text-[10px]">(facultatif)</span>
              </legend>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label
                  v-for="pt in projectTypes"
                  :key="pt.value"
                  :class="[
                    'flex flex-col items-center gap-2 text-center border rounded-xl px-3 py-4 cursor-pointer transition-all duration-200 select-none',
                    form.projectType === pt.value
                      ? 'border-ems-green bg-ems-green/5 shadow-sm'
                      : 'border-slate-200 bg-slate-50 hover:border-ems-green/50 hover:bg-ems-green/5'
                  ]"
                >
                  <input
                    type="radio"
                    :value="pt.value"
                    v-model="form.projectType"
                    class="sr-only"
                    :aria-label="pt.label"
                  />
                  <span class="text-2xl" aria-hidden="true">{{ pt.icon }}</span>
                  <span class="font-body font-semibold text-xs text-slate-700 leading-tight">{{ pt.label }}</span>
                </label>
              </div>
            </fieldset>

            <!-- Nom + Code Postal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="name" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                  Nom <span class="text-ems-green" aria-hidden="true">*</span>
                </label>
                <input id="name" v-model="form.name" type="text" required
                       placeholder="Votre nom ou société"
                       autocomplete="name"
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 h-12 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200"
                       aria-required="true" />
              </div>
              <div>
                <label for="postalCode" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                  Code Postal <span class="text-ems-green" aria-hidden="true">*</span>
                </label>
                <input id="postalCode" v-model="form.postalCode" type="text" required
                       placeholder="34000"
                       autocomplete="postal-code"
                       inputmode="numeric"
                       maxlength="10"
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 h-12 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200"
                       aria-required="true" />
              </div>
            </div>

            <!-- Téléphone OU Email (validation coordonnée sans contradiction) -->
            <fieldset class="border border-slate-200/80 rounded-xl p-4 bg-slate-50/50">
              <legend class="font-body font-semibold text-xs text-slate-700 uppercase tracking-wider px-2">
                Coordonnées de contact <span class="text-ems-green" aria-hidden="true">*</span>
              </legend>
              <p class="font-body text-[11px] text-slate-500 mb-3 px-1">
                Renseignez au moins un moyen de contact (téléphone ou email obligatoire).
              </p>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label for="phone" class="block font-body font-semibold text-xs text-slate-700 mb-1.5">
                    Téléphone
                  </label>
                  <input id="phone" v-model="form.phone" type="tel"
                         placeholder="07 XX XX XX XX"
                         autocomplete="tel"
                         class="w-full bg-white border border-slate-200 rounded-lg px-4 h-11 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:outline-none transition-all duration-200" />
                </div>
                <div>
                  <label for="email" class="block font-body font-semibold text-xs text-slate-700 mb-1.5">
                    Adresse email
                  </label>
                  <input id="email" v-model="form.email" type="email"
                         placeholder="contact@exemple.fr"
                         autocomplete="email"
                         class="w-full bg-white border border-slate-200 rounded-lg px-4 h-11 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:outline-none transition-all duration-200" />
                </div>
              </div>
            </fieldset>

            <!-- Champ Recommandation (Point 10) -->
            <div>
              <label for="referredBy" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                Vous avez été recommandé par… <span class="text-slate-400 font-normal lowercase text-[10px]">(nom de votre parrain — facultatif)</span>
              </label>
              <input id="referredBy" v-model="form.referredBy" type="text"
                     placeholder="Nom et prénom de la personne qui vous a recommandé"
                     autocomplete="off"
                     class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 h-11 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200" />
            </div>

            <!-- Message -->
            <div>
              <label for="message" class="block font-body font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">
                Votre message <span class="text-ems-green" aria-hidden="true">*</span>
              </label>
              <textarea id="message" v-model="form.message" rows="4" required
                        :placeholder="messagePlaceholder"
                        autocomplete="off"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-slate-900 placeholder:text-slate-400 text-sm focus:border-ems-green focus:bg-white focus:outline-none transition-all duration-200 h-28 resize-y"
                        aria-required="true"></textarea>
            </div>

            <!-- Case à cocher de consentement RGPD (Point 8 : obligatoire, jamais pré-cochée) -->
            <div class="flex items-start gap-3 pt-2">
              <input
                id="consent"
                v-model="form.consent"
                type="checkbox"
                required
                class="mt-1 w-4 h-4 rounded border-slate-300 text-ems-green focus:ring-ems-green cursor-pointer flex-shrink-0"
                aria-required="true"
              />
              <label for="consent" class="font-body text-xs text-slate-600 leading-relaxed cursor-pointer select-none">
                J'accepte que mes données soient utilisées afin d'être recontacté dans le cadre de ma demande et j'ai pris connaissance des
                <a href="#mentions" target="_blank" rel="noopener noreferrer" class="text-slate-800 underline hover:text-ems-green-dark">mentions légales</a>
                et de la
                <a href="#privacy" target="_blank" rel="noopener noreferrer" class="text-slate-800 underline hover:text-ems-green-dark">politique de confidentialité</a>.
                <span class="text-ems-green" aria-hidden="true">*</span>
              </label>
            </div>

            <!-- Message d'erreur -->
            <p v-if="error" class="font-body text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3" role="alert">
              {{ errorMessage || 'Une erreur est survenue. Merci de réessayer ou de nous appeler au 07 43 70 84 95.' }}
            </p>

            <!-- Submit -->
            <button type="submit"
                    :disabled="submitting || !isValid"
                    class="w-full bg-[#1b2a4a] text-white font-body font-bold text-xs uppercase tracking-wider py-4 rounded-lg hover:bg-ems-green hover:text-[#1b2a4a] disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-300"
                    :aria-label="submitting ? 'Envoi en cours' : 'Envoyer la demande de devis'">
              {{ submitting ? 'Envoi en cours…' : 'Envoyer ma demande' }}
            </button>

            <!-- Confidentialité garantie -->
            <p class="flex items-center justify-center gap-2 font-body text-[10px] text-slate-400 text-center">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/>
                <path d="M8 11V7a4 4 0 018 0v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              Vos données sont strictement confidentielles et ne seront jamais cédées à des tiers.
            </p>
          </form>
        </div>

        <!-- Coordonnées et urgence à droite (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6">

          <!-- Grille d'infos (4 cartes) -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Téléphone</span>
                <a href="tel:+33743708495" class="text-sm font-bold text-slate-800 hover:text-ems-green transition-colors">07 43 70 84 95</a>
              </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="min-w-0">
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Email</span>
                <a href="mailto:contact@energeticmaintenances.fr" class="text-xs font-bold text-slate-800 break-all hover:text-ems-green">contact@energeticmaintenances.fr</a>
              </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Zone d'intervention</span>
                <span class="text-sm font-bold text-slate-800">12 départements</span>
              </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 text-[#1b2a4a]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Disponibilité</span>
                <span class="text-sm font-bold text-slate-800">Lun – Ven + Astreinte</span>
              </div>
            </div>

          </div>

          <!-- Encadré Urgence -->
          <div class="bg-[#1b2a4a] text-white border border-ems-green/35 rounded-2xl p-6 shadow-lg flex flex-col gap-5 text-left">
            <div class="flex flex-col gap-2">
              <h3 class="font-display font-extrabold text-lg uppercase tracking-wide text-white">Besoin d'un dépannage rapide ?</h3>
              <p class="font-body text-xs text-[#8a96a8] leading-relaxed">
                Pour une borne en panne, une anomalie électrique ou un projet urgent, contactez-nous directement par téléphone.
              </p>
            </div>
            <a href="tel:+33743708495" class="inline-flex items-center justify-center gap-2 bg-[#5dbe3a] text-[#0f1a2e] font-body font-bold text-xs uppercase tracking-wider py-3.5 px-6 rounded-lg hover:bg-[#4caf50] transition-colors self-start">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              07 43 70 84 95 — Appeler maintenant
            </a>
          </div>

        </div>

      </div>

    </div>
  </section>
</template>
