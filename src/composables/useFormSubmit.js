import { ref } from 'vue'
import { APPORTEURS_CONFIG } from '@/config/apporteurs.js'

/**
 * Composable pour la soumission des formulaires apporteurs.
 * Porte la logique submit de app.main.js en Vue idiomatique.
 *
 * @param {'registration'|'referral'} formType
 */
export function useFormSubmit(formType) {
  const status = ref('idle') // 'idle' | 'submitting' | 'success' | 'error'
  const message = ref('')
  const receiptId = ref('')
  const submissionId = ref('')
  const sent = ref(false)

  /** Génère ou récupère le submission_id (conservé tant que le formulaire n'est pas modifié) */
  function getSubmissionId() {
    if (!submissionId.value) {
      submissionId.value =
        window.crypto?.randomUUID?.() ||
        `request-${Date.now()}-${Math.random().toString(36).slice(2)}`
    }
    return submissionId.value
  }

  /** Réinitialise le submission_id quand l'utilisateur modifie le formulaire */
  function resetSubmissionId() {
    submissionId.value = ''
    if (sent.value) {
      sent.value = false
      status.value = 'idle'
      message.value = ''
    }
  }

  /**
   * Valide la taille des fichiers.
   * @param {FileList[]} fileLists
   * @returns {boolean}
   */
  function validateFileSizes(fileLists) {
    for (const list of fileLists) {
      for (const file of list) {
        if (file.size > APPORTEURS_CONFIG.maxFileBytes) return false
      }
    }
    return true
  }

  /**
   * Soumet le formulaire.
   * @param {FormData} formData - déjà construit par le composant
   * @param {FileList[]} fileLists - tableaux de fichiers pour la validation taille
   * @returns {Promise<boolean>} true si succès
   */
  async function submit(formData, fileLists = []) {
    if (status.value === 'submitting') return false

    // Validation taille fichiers
    if (!validateFileSizes(fileLists)) {
      status.value = 'error'
      message.value =
        'Une pièce dépasse la taille autorisée de 10\u00a0Mo. Réduisez-la ou transmettez-la séparément à EMS.'
      return false
    }

    // Vérification endpoint (même origine, HTTPS)
    const rawEndpoint =
      formType === 'registration'
        ? APPORTEURS_CONFIG.registrationEndpoint
        : APPORTEURS_CONFIG.referralEndpoint

    let url
    try {
      url = new URL(rawEndpoint, window.location.href)
      if (url.origin !== window.location.origin || url.protocol !== 'https:') {
        throw new Error('Configuration')
      }
    } catch {
      status.value = 'error'
      message.value = "Le formulaire n'est pas disponible. Contactez EMS directement."
      return false
    }

    // Enrichissement du FormData
    formData.set('submission_id', getSubmissionId())
    formData.set('model_version', APPORTEURS_CONFIG.contractVersion)
    formData.set('form_version', APPORTEURS_CONFIG.formVersion)

    status.value = 'submitting'
    message.value = 'Transmission en cours\u2026'

    const csrfToken = document.querySelector('meta[name=csrf-token]')?.content

    try {
      const response = await fetch(url.href, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
      })

      const result = await response.json()

      if (
        !response.ok ||
        result.success !== true ||
        typeof result.receipt_id !== 'string' ||
        !result.receipt_id.trim()
      ) {
        throw new Error('Transmission non confirmée')
      }

      receiptId.value = result.receipt_id
      sent.value = true
      status.value = 'success'
      message.value =
        formType === 'registration'
          ? `Votre demande a été transmise à EMS. Référence\u00a0: ${result.receipt_id}. EMS examinera vos informations pour préparer le contrat. Aucune signature n'a été effectuée.`
          : `Votre présentation a été transmise à EMS. Référence\u00a0: ${result.receipt_id}. Conservez cette référence\u00a0; la réponse d'EMS vous sera adressée par écrit. La transmission ne vaut pas acceptation.`

      return true
    } catch {
      status.value = 'error'
      message.value =
        "La réception par EMS n'a pas pu être confirmée. Ne considérez pas la demande comme acceptée\u00a0; contactez EMS ou réessayez. Vos champs restent affichés."
      return false
    }
  }

  return {
    status,
    message,
    receiptId,
    sent,
    submit,
    resetSubmissionId,
  }
}
