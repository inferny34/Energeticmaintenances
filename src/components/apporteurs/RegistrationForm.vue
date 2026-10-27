<template>
  <!-- FORMULAIRE INSCRIPTION (Devenir apporteur) -->
  <div>
    <!-- Encart de préparation -->
    <aside class="mb-6 rounded-xl border border-ems-border bg-ems-dark p-6 space-y-4">
      <span class="section-label">Avant de commencer</span>
      <h3 class="font-display font-bold text-white uppercase text-lg">
        Vos quatre pièces à portée de main.
      </h3>
      <p class="font-body text-sm text-ems-muted">Pour envoyer votre demande en une fois, préparez&nbsp;:</p>
      <ul class="space-y-3">
        <li v-for="doc in requiredDocs" :key="doc.label" class="flex gap-3">
          <span class="text-ems-green flex-shrink-0 mt-0.5">•</span>
          <div>
            <strong class="font-body text-sm text-white">{{ doc.label }}</strong>
            <span class="block font-body text-xs text-ems-muted">{{ doc.desc }}</span>
          </div>
        </li>
      </ul>
      <p class="font-body text-xs text-ems-muted/70 leading-relaxed">
        PDF, JPG ou PNG · 10&nbsp;Mo maximum par pièce.
        Les quatre pièces sont obligatoires&nbsp;; EMS les contrôle ensuite.
        Vous ne les avez pas encore&nbsp;? Préparez-les avant de commencer.
      </p>
      <a href="#guide-micro" class="font-body text-sm text-ems-green underline hover:text-white transition-colors">
        Besoin d'aide pour votre micro-entreprise&nbsp;? →
      </a>
    </aside>

    <!-- FORMULAIRE -->
    <form
      :id="formId"
      enctype="multipart/form-data"
      class="card space-y-6"
      novalidate
      @change="onFormChange"
      @input="onFormInput"
      @submit.prevent="onSubmit"
    >
      <input type="hidden" name="profile" value="Professionnel">

      <div class="rounded-md border border-ems-green/20 bg-ems-green/5 px-4 py-3">
        <p class="font-body text-xs text-ems-muted leading-relaxed">
          Entreprise ou micro-entreprise avec SIRET. EMS examinera votre dossier avant de préparer
          le contrat&nbsp;; cet envoi ne vaut pas signature.
        </p>
      </div>

      <!-- 01 / INFOS PROFESSIONNELLES -->
      <fieldset class="space-y-4 border-0 p-0 m-0">
        <legend class="sr-only">01 / Vos informations professionnelles</legend>
        <div class="font-display font-bold text-ems-green text-xs uppercase tracking-widest mb-1">
          01 / Vos informations professionnelles
        </div>
        <h3 :id="ids.regHeading" class="font-display font-bold text-white uppercase text-base" tabindex="-1">
          Devenir apporteur
        </h3>
        <p class="font-body text-xs text-ems-muted">
          Les champs marqués d'un * et les quatre pièces sont obligatoires.
          Le contrat sera préparé à partir de ces informations.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1">
            <span class="form-label">Nom et prénom du contact *</span>
            <input
              v-model="f.partner_name"
              name="partner_name"
              autocomplete="name"
              required
              maxlength="160"
              :id="ids.partnerName"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">E-mail de notification *</span>
            <input
              v-model="f.email"
              name="email"
              type="email"
              autocomplete="email"
              required
              maxlength="254"
              :id="ids.email"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Téléphone *</span>
            <input
              v-model="f.phone"
              name="phone"
              type="tel"
              autocomplete="tel"
              required
              maxlength="30"
              :id="ids.phone"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1 sm:col-span-2">
            <span class="form-label">Adresse complète / siège *</span>
            <input
              v-model="f.address"
              name="address"
              autocomplete="street-address"
              required
              maxlength="400"
              :id="ids.address"
              class="form-input"
            >
          </label>
        </div>
      </fieldset>

      <!-- Informations du professionnel -->
      <fieldset
        data-condition="professional"
        class="space-y-4 border-0 p-0 m-0"
      >
        <legend class="sr-only">Informations du professionnel</legend>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1 sm:col-span-2">
            <span class="form-label">Raison sociale / nom de l'entrepreneur individuel *</span>
            <input
              v-model="f.company"
              name="company"
              required
              maxlength="200"
              :id="ids.company"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Forme juridique *</span>
            <input
              v-model="f.legal_form"
              name="legal_form"
              placeholder="Ex. : EI, SASU…"
              required
              maxlength="100"
              :id="ids.legalForm"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">SIRET *</span>
            <input
              v-model="f.siret"
              name="siret"
              inputmode="numeric"
              pattern="[0-9]{14}"
              minlength="14"
              maxlength="14"
              required
              title="14 chiffres sans espace"
              :id="ids.siret"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Représentant signataire *</span>
            <input
              v-model="f.partner_signer"
              name="partner_signer"
              required
              maxlength="160"
              :id="ids.partnerSigner"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Régime de TVA *</span>
            <select
              v-model="f.vat_regime"
              name="vat_regime"
              required
              :id="ids.vatRegime"
              class="form-input"
            >
              <option value="">Choisir</option>
              <option>Franchise en base de TVA</option>
              <option>TVA facturée</option>
              <option>Autre</option>
            </select>
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Date d'effet du régime (si connue)</span>
            <input
              v-model="f.vat_effective_at"
              name="vat_effective_at"
              type="date"
              :id="ids.vatEffectiveAt"
              class="form-input"
            >
          </label>
        </div>
      </fieldset>

      <!-- Champs conditionnels TVA facturée -->
      <fieldset
        v-show="show.vat"
        :disabled="!show.vat"
        data-condition="vat"
        class="space-y-4 border border-ems-border rounded-lg p-4"
      >
        <legend class="font-body text-xs text-ems-muted px-1">TVA facturée</legend>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1">
            <span class="form-label">Taux de TVA (%) *</span>
            <input
              v-model="f.vat_rate"
              name="vat_rate"
              inputmode="decimal"
              pattern="[0-9]+([.,][0-9]{1,2})?"
              placeholder="Ex. : 20"
              :required="show.vat"
              maxlength="8"
              :id="ids.vatRate"
              class="form-input"
            >
          </label>
          <label class="flex flex-col gap-1">
            <span class="form-label">Numéro de TVA *</span>
            <input
              v-model="f.vat_number"
              name="vat_number"
              :required="show.vat"
              maxlength="40"
              :id="ids.vatNumber"
              class="form-input"
            >
          </label>
        </div>
      </fieldset>

      <!-- Champs conditionnels TVA autre -->
      <fieldset
        v-show="show.vatOther"
        :disabled="!show.vatOther"
        data-condition="vat-other"
        class="space-y-4 border border-ems-border rounded-lg p-4"
      >
        <legend class="font-body text-xs text-ems-muted px-1">Précisez votre régime</legend>
        <label class="flex flex-col gap-1">
          <span class="form-label">Situation fiscale *</span>
          <textarea
            v-model="f.vat_other"
            name="vat_other"
            :required="show.vatOther"
            maxlength="1000"
            rows="3"
            :id="ids.vatOther"
            class="form-input h-auto py-3"
          ></textarea>
        </label>
      </fieldset>

      <div class="border-t border-ems-border my-2"></div>

      <!-- 02 / CONTEXTE DES APPORTS -->
      <fieldset class="space-y-4 border-0 p-0 m-0">
        <legend class="sr-only">02 / Le contexte de vos apports</legend>
        <div class="font-display font-bold text-ems-green text-xs uppercase tracking-widest">
          02 / Le contexte de vos apports
        </div>
        <h3 class="font-display font-bold text-white uppercase text-base" tabindex="-1">
          Un lien avec votre profession&nbsp;?
        </h3>
        <p class="font-body text-xs text-ems-muted leading-relaxed">
          Une entreprise ou une micro-entreprise peut également exercer une activité salariée ou pour
          un mandant. Signalez les liens professionnels utiles à l'examen des présentations.
        </p>

        <p class="font-body text-sm">
          Votre activité a un lien avec un emploi ou un mandant&nbsp;?
          <button
            type="button"
            class="text-ems-green underline hover:text-white transition-colors"
            @click="$emit('open-contract', 4)"
          >
            Consultez les règles de loyauté avant de vous engager ↗
          </button>
        </p>

        <label class="flex flex-col gap-1">
          <span class="form-label">Vos recommandations peuvent-elles être liées à votre profession&nbsp;? *</span>
          <select
            v-model="f.professional_link"
            name="professional_link"
            required
            :id="ids.professionalLink"
            class="form-input"
          >
            <option value="">Choisir</option>
            <option value="Non">Non, contacts personnels</option>
            <option value="Oui">Oui, lien professionnel possible</option>
          </select>
        </label>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1">
            <span class="form-label">Profession / fonction *</span>
            <input
              v-model="f.profession"
              name="profession"
              required
              maxlength="160"
              :id="ids.profession"
              class="form-input"
            >
          </label>
          <label class="flex flex-col gap-1">
            <span class="form-label">Employeur ou mandant, si applicable</span>
            <input
              v-model="f.employer"
              name="employer"
              maxlength="200"
              :id="ids.employer"
              class="form-input"
            >
          </label>
        </div>

        <div class="rounded-md border border-ems-green/20 bg-ems-green/5 px-4 py-3">
          <p class="font-body text-xs text-ems-muted leading-relaxed">
            Pour chaque client lié à un emploi ou à un mandant, la fiche de loyauté et les
            autorisations nécessaires restent requises selon le contrat.
          </p>
        </div>
      </fieldset>

      <!-- PIÈCES OBLIGATOIRES -->
      <details class="border border-ems-border rounded-xl overflow-hidden" open>
        <summary class="px-5 py-4 font-body font-medium text-sm text-white bg-ems-surface/50 cursor-pointer list-none flex items-center justify-between">
          <span>Vos pièces obligatoires — dossier complet</span>
          <span aria-hidden="true" class="text-ems-muted">▾</span>
        </summary>

        <div class="px-5 pt-4 pb-5 space-y-4">
          <p class="font-body text-xs text-ems-muted leading-relaxed">
            Les quatre pièces ci-dessous sont nécessaires pour envoyer votre demande. Le RIB doit
            être au nom de l'apporteur professionnel. Pour une entreprise nouvellement créée, joignez
            le document délivré par l'Urssaf à ce stade, conformément au contrat.
            EMS vérifiera les pièces avant validation.
          </p>

          <!-- Aide justificatifs -->
          <details class="border border-ems-border rounded-lg">
            <summary class="px-4 py-3 font-body text-xs text-ems-green cursor-pointer list-none">
              Où trouver ou demander ces documents&nbsp;?
            </summary>
            <div class="px-4 pb-4 pt-2 space-y-4">
              <p class="font-body text-xs text-ems-muted">
                Un repère pour préparer les quatre pièces demandées par EMS. Les liens s'ouvrent
                dans un nouvel onglet&nbsp;: vous gardez votre formulaire ici.
              </p>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <article v-for="help in docHelp" :key="help.title" class="space-y-1">
                  <h4 class="font-body font-bold text-xs text-white">{{ help.title }}</h4>
                  <p class="font-body text-xs text-ems-muted leading-relaxed">{{ help.body }}</p>
                  <template v-if="help.links">
                    <a
                      v-for="link in help.links"
                      :key="link.href"
                      :href="link.href"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="block font-body text-xs text-ems-green hover:text-white transition-colors"
                    >{{ link.label }} ↗</a>
                  </template>
                  <small v-if="help.note" class="block font-body text-xs text-ems-muted/60 leading-relaxed">
                    {{ help.note }}
                  </small>
                </article>
              </div>
              <p class="font-body text-xs text-ems-muted/60">
                PDF, JPG ou PNG · 10&nbsp;Mo maximum par fichier. Joignez uniquement les documents
                demandés, jamais vos identifiants ni votre relevé bancaire complet.
                L'ajout des fichiers ne vaut pas validation&nbsp;: EMS contrôle votre dossier.
              </p>
            </div>
          </details>

          <!-- 4 inputs fichier -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label v-for="fileField in fileFields" :key="fileField.name" class="flex flex-col gap-1">
              <span class="form-label">{{ fileField.label }}</span>
              <input
                type="file"
                :name="fileField.name"
                accept="application/pdf,image/png,image/jpeg"
                required
                :id="ids[fileField.idKey]"
                class="font-body text-sm text-ems-muted file:mr-3 file:py-1.5 file:px-3
                       file:rounded file:border-0 file:bg-ems-green/10 file:text-ems-green
                       file:font-body file:text-xs file:cursor-pointer
                       hover:file:bg-ems-green/20 cursor-pointer"
                @change="onFileChange"
              >
              <small class="font-body text-xs text-ems-muted/60">{{ fileField.help }}</small>
            </label>
          </div>

          <!-- Compteur pièces -->
          <p
            :id="ids.docCounter"
            role="status"
            aria-live="polite"
            class="font-body text-sm font-medium"
            :class="fileCount === 4 ? 'text-ems-green' : 'text-ems-muted'"
          >
            {{ fileCount === 4
              ? '4 / 4 pièces jointes — EMS contrôlera les documents après réception.'
              : `${fileCount} / 4 pièces jointes — ajoutez les quatre fichiers pour envoyer votre dossier.` }}
          </p>
        </div>
      </details>

      <!-- Notes facultatives -->
      <label class="flex flex-col gap-1">
        <span class="form-label">Une précision pour EMS&nbsp;? (facultatif)</span>
        <textarea
          v-model="f.notes"
          name="notes"
          rows="3"
          maxlength="2000"
          :id="ids.notes"
          class="form-input h-auto py-3"
        ></textarea>
      </label>

      <!-- Checkbox contrat lu -->
      <label class="flex items-start gap-3 cursor-pointer group">
        <input
          v-model="f.contract_read"
          type="checkbox"
          name="contract_read"
          value="1"
          required
          :id="ids.contractRead"
          class="mt-1 h-4 w-4 rounded border-ems-border bg-ems-dark accent-ems-green"
        >
        <span class="font-body text-sm text-ems-muted leading-relaxed group-hover:text-ems-text transition-colors">
          J'ai pris connaissance du
          <button
            type="button"
            class="text-ems-green underline hover:text-white transition-colors"
            @click="$emit('open-contract', 0)"
          >contrat d'apporteur et de ses annexes</button>.
          Cette demande ne vaut pas signature du contrat. *
        </span>
      </label>

      <!-- Honeypot -->
      <div class="absolute -left-[9999px] overflow-hidden h-px w-px" aria-hidden="true">
        <label>
          Ne pas remplir
          <input name="website" tabindex="-1" autocomplete="off">
        </label>
      </div>

      <!-- Politique de confidentialité -->
      <p class="font-body text-xs text-ems-muted/70">
        Vos données sont destinées à EMS pour examiner votre demande et préparer le contrat.
        <RouterLink to="/privacy" class="text-ems-green underline hover:text-white transition-colors">
          Politique de confidentialité
        </RouterLink>.
      </p>

      <!-- Vérifications pré-envoi -->
      <div class="rounded-xl border border-ems-border bg-ems-dark/50 p-5 space-y-3">
        <ul class="space-y-1">
          <li v-for="check in verificationList" :key="check" class="flex items-start gap-2 font-body text-xs text-ems-muted">
            <span aria-hidden="true" class="text-ems-green flex-shrink-0">✓</span>
            {{ check }}
          </li>
        </ul>
        <label class="flex flex-col gap-1">
          <span class="form-label">Vérifications requises avant envoi *</span>
          <select
            v-model="f.checks_completed"
            name="checks_completed"
            required
            :id="ids.checksCompleted"
            class="form-input"
          >
            <option value="">Choisir</option>
            <option value="Non">Non, je n'ai pas encore effectué les vérifications</option>
            <option value="Oui">Oui, j'ai effectué les vérifications requises</option>
          </select>
        </label>
        <p class="font-body text-xs text-ems-muted">
          Si une vérification reste à faire, terminez-la avant l'envoi.
          EMS examinera ensuite votre dossier.
        </p>
        <p
          v-if="f.checks_completed === 'Non'"
          role="status"
          aria-live="polite"
          class="font-body text-xs text-red-400"
        >
          L'envoi est bloqué tant que les vérifications ne sont pas terminées.
          Vous pouvez compléter les champs sans transmettre le dossier.
        </p>
      </div>

      <!-- Bouton submit -->
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <button
          type="submit"
          :disabled="submitStatus === 'submitting' || sent"
          :aria-busy="submitStatus === 'submitting'"
          class="btn-primary disabled:opacity-60 disabled:cursor-not-allowed"
        >
          <span v-if="submitStatus === 'submitting'">Envoi en cours…</span>
          <span v-else>Envoyer mon dossier complet <span aria-hidden="true">↗</span></span>
        </button>
        <span class="font-body text-xs text-ems-muted">
          Le dossier sera adressé à EMS pour contrôle et préparation du contrat. Aucune signature automatique.
        </span>
      </div>

      <p class="font-body text-xs text-ems-muted/70">
        La suite&nbsp;: EMS contrôle les pièces, prépare votre contrat, vous le signez en premier,
        puis EMS contresigne et vous remet l'exemplaire complet.
      </p>

      <!-- Message de retour -->
      <div
        v-if="submitMessage"
        role="status"
        aria-live="polite"
        class="rounded-lg px-4 py-3 font-body text-sm leading-relaxed"
        :class="submitStatus === 'error'
          ? 'border border-red-500/30 bg-red-500/10 text-red-300'
          : 'border border-ems-green/30 bg-ems-green/10 text-ems-text'"
      >
        {{ submitMessage }}
      </div>
    </form>

    <!-- Liens légaux -->
    <p class="mt-4 font-body text-xs text-ems-muted/60">
      <RouterLink to="/mentions" class="underline hover:text-ems-green transition-colors">Mentions légales</RouterLink>
      ·
      <RouterLink to="/privacy" class="underline hover:text-ems-green transition-colors">Politique de confidentialité</RouterLink>
    </p>
  </div>
</template>

<script setup>
import { ref, reactive, computed, useId } from 'vue'
import { RouterLink } from 'vue-router'
import { useFormSubmit } from '@/composables/useFormSubmit.js'

const emit = defineEmits(['open-contract'])

// IDs stables et uniques via useId()
const _id = useId()
const ids = {
  regHeading: `${_id}-heading`,
  partnerName: `${_id}-partner-name`,
  email: `${_id}-email`,
  phone: `${_id}-phone`,
  address: `${_id}-address`,
  company: `${_id}-company`,
  legalForm: `${_id}-legal-form`,
  siret: `${_id}-siret`,
  partnerSigner: `${_id}-partner-signer`,
  vatRegime: `${_id}-vat-regime`,
  vatEffectiveAt: `${_id}-vat-effective-at`,
  vatRate: `${_id}-vat-rate`,
  vatNumber: `${_id}-vat-number`,
  vatOther: `${_id}-vat-other`,
  professionalLink: `${_id}-professional-link`,
  profession: `${_id}-profession`,
  employer: `${_id}-employer`,
  rib: `${_id}-rib`,
  registrationProof: `${_id}-registration-proof`,
  vigilanceProof: `${_id}-vigilance-proof`,
  vatProof: `${_id}-vat-proof`,
  docCounter: `${_id}-doc-counter`,
  notes: `${_id}-notes`,
  contractRead: `${_id}-contract-read`,
  checksCompleted: `${_id}-checks-completed`,
}

const formId = `${_id}-registration-form`

// État du formulaire
const f = reactive({
  partner_name: '',
  email: '',
  phone: '',
  address: '',
  company: '',
  legal_form: '',
  siret: '',
  partner_signer: '',
  vat_regime: '',
  vat_effective_at: '',
  vat_rate: '',
  vat_number: '',
  vat_other: '',
  professional_link: '',
  profession: '',
  employer: '',
  notes: '',
  contract_read: false,
  checks_completed: '',
})

// Conditions d'affichage
const show = computed(() => ({
  vat: f.vat_regime === 'TVA facturée',
  vatOther: f.vat_regime === 'Autre',
}))

// Compteur de fichiers
const fileCount = ref(0)
function onFileChange() {
  const form = document.getElementById(formId)
  if (!form) return
  const inputs = [...form.querySelectorAll('input[type=file]')]
  fileCount.value = inputs.filter(i => i.files.length > 0).length
}

// Soumission
const { status: submitStatus, message: submitMessage, sent, submit, resetSubmissionId } = useFormSubmit('registration')

function onFormChange() {
  // mis à jour par les watchers — pas besoin d'action supplémentaire
}

function onFormInput() {
  resetSubmissionId()
}

async function onSubmit() {
  // Vérification checks_completed
  if (f.checks_completed !== 'Oui') {
    submitStatus.value = 'error'
    submitMessage.value = "Effectuez les vérifications requises et complétez votre dossier avant de l'envoyer."
    return
  }

  const form = document.getElementById(formId)
  if (!form) return

  // Vérification 4 pièces obligatoires
  const requiredFileNames = ['rib', 'registration_proof', 'vigilance_proof', 'vat_proof']
  const missing = requiredFileNames.some(name => {
    const input = form.querySelector(`[name="${name}"]`)
    return !input || input.files.length === 0
  })
  if (missing) {
    submitStatus.value = 'error'
    submitMessage.value = 'Joignez les quatre pièces obligatoires pour envoyer votre dossier.'
    return
  }

  if (!form.reportValidity()) return

  // Collecter les listes de fichiers pour validation taille
  const fileLists = [...form.querySelectorAll('input[type=file]')]
    .filter(i => !i.disabled && !i.closest('fieldset[disabled]'))
    .map(i => i.files)

  const formData = new FormData(form)
  await submit(formData, fileLists)
}

// Données statiques
const requiredDocs = [
  { label: "Votre RIB", desc: "Au nom de l'apporteur professionnel." },
  { label: "Votre immatriculation", desc: "Kbis ou avis SIRENE, selon votre statut." },
  { label: "Votre document URSSAF", desc: "Attestation de vigilance ou document délivré à la création, selon le contrat." },
  { label: "Votre régime de TVA", desc: "Justificatif fiscal, même en franchise en base." },
]

const fileFields = [
  { name: 'rib', idKey: 'rib', label: "RIB au nom de l'apporteur *", help: "Nom du titulaire lisible et identique à celui de l'apporteur." },
  { name: 'registration_proof', idKey: 'registrationProof', label: "Justificatif d'immatriculation (Kbis / avis SIRENE) *", help: "Le document doit identifier votre entreprise et son SIRET." },
  { name: 'vigilance_proof', idKey: 'vigilanceProof', label: "Attestation de vigilance URSSAF / document de création *", help: "Joignez le document URSSAF adapté à votre situation, selon le contrat." },
  { name: 'vat_proof', idKey: 'vatProof', label: "Justificatif du régime de TVA, y compris en franchise en base *", help: "Justificatif fiscal du régime et de sa date d'effet ; le numéro de TVA seul ne suffit pas." },
]

const docHelp = [
  {
    title: "01 · Votre RIB",
    body: "Dans l'application ou l'espace en ligne de votre banque, cherchez « RIB » ou « Coordonnées bancaires », puis téléchargez le document. Vous pouvez aussi le demander à votre conseiller.",
    note: "Le titulaire doit correspondre à l'apporteur professionnel : votre identité pour une entreprise individuelle, ou la société pour une société.",
  },
  {
    title: "02 · Votre immatriculation",
    body: "Avec votre SIREN ou SIRET, téléchargez votre avis de situation SIRENE sur le site de l'Insee. Si vous disposez d'un extrait K ou Kbis, vous pouvez le récupérer sur MonIdenum si votre entreprise est éligible.",
    links: [
      { href: "https://avis-situation-sirene.insee.fr/", label: "Obtenir mon avis SIRENE — Insee" },
      { href: "https://monidenum.fr/", label: "Accéder à mon extrait K / Kbis" },
    ],
  },
  {
    title: "03 · Votre attestation Urssaf",
    body: "Connectez-vous à votre espace Urssaf et recherchez la rubrique « Attestations » ou « Documents et démarches ». Demandez l'attestation de vigilance, puis téléchargez le PDF.",
    links: [{ href: "https://www.urssaf.fr/accueil/attestation-vigilance.html", label: "Suivre le mode d'emploi officiel Urssaf" }],
    note: "Vous débutez ? Si l'attestation de vigilance n'est pas encore disponible, demandez à l'Urssaf le document provisoire adapté à votre création et joignez-le conformément au contrat. Un refus de délivrance n'est pas une attestation de vigilance.",
  },
  {
    title: "04 · Votre régime de TVA",
    body: "Retrouvez votre mémento fiscal à jour ou un courrier fiscal précisant votre régime. Si vous ne l'avez pas, demandez à votre service des impôts des entreprises (SIE), via la messagerie de votre espace professionnel, un justificatif du régime de TVA et de sa date d'effet, y compris en franchise en base.",
    links: [{ href: "https://www.impots.gouv.fr/", label: "Accéder à impots.gouv.fr — espace professionnel" }],
    note: "Vous pouvez écrire : « Bonjour, merci de me transmettre un justificatif de mon régime actuel de TVA et de sa date d'effet pour l'entreprise [nom, SIRET]. » Le numéro de TVA seul ne suffit pas.",
  },
]

const verificationList = [
  "Informations professionnelles et régime de TVA vérifiés.",
  "Quatre pièces correspondant à ma situation jointes.",
  "Obligations envers un éventuel employeur ou mandant vérifiées.",
]
</script>
