import { ref, watch } from 'vue'
import { APPORTEURS_CONFIG } from '@/config/apporteurs.js'
import { isInZone } from '@/constants/zones.js'

/**
 * Composable pour les champs conditionnels du formulaire.
 * Porte la logique de updateConditions() de app.main.js en Vue idiomatique.
 *
 * @param {Object} fields - refs des champs du formulaire
 * @param {'registration'|'referral'} formType
 */
export function useConditionalFields(fields, formType) {
  // États de visibilité de chaque groupe conditionnel
  const show = ref({
    professional: true,
    vat: false,
    vatOther: false,
    linkedReferral: false,
  })

  function update() {
    const vatValue = fields.vat_regime?.value ?? ''
    const linkValue = fields.professional_link?.value ?? ''

    show.value.professional = true // toujours visible dans ce formulaire
    show.value.vat = vatValue === 'TVA facturée'
    show.value.vatOther = vatValue === 'Autre'
    show.value.linkedReferral = formType === 'referral' && linkValue === 'Oui'
  }

  // Réagit aux changements des champs pilotes
  if (fields.vat_regime) {
    watch(() => fields.vat_regime.value, update, { immediate: true })
  }
  if (fields.professional_link) {
    watch(() => fields.professional_link.value, update, { immediate: true })
  }

  return { show, update }
}

/**
 * Composable pour la validation du contact client (formulaire referral).
 * Porte la logique checkClientContact() de app.main.js.
 */
export function useClientContactValidation(fields) {
  const phoneError = ref('')
  const emailError = ref('')

  function validate() {
    phoneError.value = ''
    emailError.value = ''

    const phone = fields.client_phone?.value?.trim() ?? ''
    const email = fields.client_email?.value?.trim() ?? ''
    const method = fields.contact_method?.value ?? ''

    if (!phone && !email) {
      phoneError.value = 'Indiquez au moins un moyen de contact du client.'
      return false
    }
    if (['Téléphone', 'SMS'].includes(method) && !phone) {
      phoneError.value = 'Le téléphone est nécessaire pour le moyen de contact demandé.'
      return false
    }
    if (method === 'E-mail' && !email) {
      emailError.value = "L'e-mail est nécessaire pour le moyen de contact demandé."
      return false
    }
    return true
  }

  return { phoneError, emailError, validate }
}

/**
 * Composable pour le retour zone (formulaire referral).
 * Porte la logique zones/postal de app.main.js.
 */
export function useZoneFeedback(postalCodeRef) {
  const feedback = ref('')
  const inZone = ref(null)

  watch(postalCodeRef, (val) => {
    const code = String(val ?? '').trim()
    if (code.length !== 5) {
      feedback.value = ''
      inZone.value = null
      return
    }
    const result = isInZone(code)
    inZone.value = result
    feedback.value = result
      ? 'Département dans la zone prévue. EMS examinera le projet avant toute acceptation.'
      : "Ce chantier est hors de la zone prévue au contrat. Contactez EMS pour examiner la situation\u00a0; une présentation n'ouvre pas automatiquement droit à commission."
  })

  return { feedback, inZone }
}
