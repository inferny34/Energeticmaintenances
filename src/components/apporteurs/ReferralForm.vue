<template>
  <!-- FORMULAIRE RECOMMANDATION (Recommander un client) -->
  <div>
    <!-- Encart de préparation -->
    <aside class="mb-6 rounded-xl border border-ems-border bg-ems-dark p-6 space-y-3">
      <span class="section-label">Vous avez déjà signé avec EMS</span>
      <h3 class="font-display font-bold text-white uppercase text-lg">Un client à présenter&nbsp;?</h3>
      <p class="font-body text-sm text-ems-muted leading-relaxed">
        Préparez ses coordonnées, le lieu du chantier et son besoin. Il doit avoir demandé à être
        contacté par EMS&nbsp;; conservez sa demande écrite et informez-le de votre commission éventuelle.
      </p>
      <p class="font-body text-xs text-ems-muted/70 leading-relaxed">
        Si le contact a un lien avec votre emploi ou un mandant, effectuez les vérifications et
        réunissez les autorisations nécessaires avant l'envoi. Ce formulaire ne remplace pas
        l'engagement signé prévu au contrat.
      </p>
      <button
        type="button"
        class="font-body text-sm text-ems-green underline hover:text-white transition-colors"
        @click="$emit('open-contract', 0)"
      >
        Relire le contrat et la fiche client →
      </button>
    </aside>

    <!-- FORMULAIRE -->
    <form
      :id="formId"
      enctype="multipart/form-data"
      class="card space-y-6"
      novalidate
      @input="onFormInput"
      @submit.prevent="onSubmit"
    >
      <input type="hidden" name="profile" value="Professionnel">

      <!-- 01 / VOUS ET VOTRE CLIENT -->
      <fieldset class="space-y-4 border-0 p-0 m-0">
        <legend class="sr-only">01 / Vous et votre client</legend>
        <div class="font-display font-bold text-ems-green text-xs uppercase tracking-widest">
          01 / Vous et votre client
        </div>
        <h3 :id="ids.heading" class="font-display font-bold text-white uppercase text-base" tabindex="-1">
          Présenter un projet à EMS.
        </h3>
        <p class="font-body text-xs text-ems-muted leading-relaxed">
          La présentation doit être complète et le client doit avoir demandé à être contacté.
          Elle reste soumise à l'examen et à la réponse écrite d'EMS.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1">
            <span class="form-label">Votre nom *</span>
            <input v-model="f.partner_name" name="partner_name" required autocomplete="name" maxlength="160" :id="ids.partnerName" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Votre SIRET d'apporteur *</span>
            <input v-model="f.partner_siret" name="partner_siret" required inputmode="numeric" pattern="[0-9]{14}" minlength="14" maxlength="14" title="14 chiffres sans espace" :id="ids.partnerSiret" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Votre e-mail d'apporteur *</span>
            <input v-model="f.partner_email" name="partner_email" type="email" required autocomplete="email" maxlength="254" :id="ids.partnerEmail" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Votre téléphone (facultatif)</span>
            <input v-model="f.partner_phone" name="partner_phone" type="tel" maxlength="30" :id="ids.partnerPhone" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Référence de votre contrat (si connue)</span>
            <input v-model="f.contract_reference" name="contract_reference" maxlength="100" :id="ids.contractRef" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Nom du client / société *</span>
            <input v-model="f.client_name" name="client_name" required maxlength="200" :id="ids.clientName" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Téléphone du client</span>
            <input
              v-model="f.client_phone"
              name="client_phone"
              type="tel"
              maxlength="30"
              :id="ids.clientPhone"
              class="form-input"
              :class="phoneError ? 'border-red-500' : ''"
              :aria-describedby="phoneError ? ids.phoneError : undefined"
            >
            <span v-if="phoneError" :id="ids.phoneError" class="font-body text-xs text-red-400" role="alert">{{ phoneError }}</span>
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">E-mail du client</span>
            <input
              v-model="f.client_email"
              name="client_email"
              type="email"
              maxlength="254"
              :id="ids.clientEmail"
              class="form-input"
              :class="emailError ? 'border-red-500' : ''"
              :aria-describedby="emailError ? ids.emailError : undefined"
            >
            <span v-if="emailError" :id="ids.emailError" class="font-body text-xs text-red-400" role="alert">{{ emailError }}</span>
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Type de site *</span>
            <select v-model="f.site_type" name="site_type" required :id="ids.siteType" class="form-input">
              <option value="">Choisir</option>
              <option>Maison</option>
              <option>Appartement / copropriété</option>
              <option>Entreprise</option>
              <option>Autre</option>
            </select>
          </label>

          <label class="flex flex-col gap-1 sm:col-span-2">
            <span class="form-label">Adresse ou repère du chantier *</span>
            <input v-model="f.address" name="address" required maxlength="400" :id="ids.address" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Code postal du chantier *</span>
            <input
              v-model="f.postal_code"
              name="postal_code"
              inputmode="numeric"
              pattern="[0-9]{5}"
              maxlength="5"
              required
              :id="ids.postalCode"
              class="form-input"
            >
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Commune *</span>
            <input v-model="f.city" name="city" required maxlength="160" :id="ids.city" class="form-input">
          </label>
        </div>

        <!-- Retour zone -->
        <p
          v-if="zoneFeedback"
          :id="ids.zoneFeedback"
          aria-live="polite"
          class="font-body text-sm rounded-md px-3 py-2"
          :class="inZone === true
            ? 'bg-ems-green/10 text-ems-green border border-ems-green/20'
            : 'bg-red-500/10 text-red-300 border border-red-500/20'"
        >
          {{ zoneFeedback }}
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1">
            <span class="form-label">Nombre de bornes, si connu</span>
            <input v-model="f.planned_units" name="planned_units" type="number" min="1" max="10000" step="1" :id="ids.plannedUnits" class="form-input">
          </label>
          <label class="flex flex-col gap-1">
            <span class="form-label">Véhicule, si connu</span>
            <input v-model="f.vehicle" name="vehicle" maxlength="160" :id="ids.vehicle" class="form-input">
          </label>
          <label class="flex flex-col gap-1 sm:col-span-2">
            <span class="form-label">Besoin exprimé / précisions sur le projet *</span>
            <textarea v-model="f.need" name="need" rows="3" required maxlength="2000" :id="ids.need" class="form-input h-auto py-3"></textarea>
          </label>
        </div>
      </fieldset>

      <div class="border-t border-ems-border"></div>

      <!-- 02 / LA DEMANDE DU CLIENT -->
      <fieldset class="space-y-4 border-0 p-0 m-0">
        <legend class="sr-only">02 / La demande du client</legend>
        <div class="font-display font-bold text-ems-green text-xs uppercase tracking-widest">
          02 / La demande du client
        </div>
        <h3 class="font-display font-bold text-white uppercase text-base" tabindex="-1">
          Son accord, avant tout.
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="flex flex-col gap-1">
            <span class="form-label">Moyen de contact demandé par le client *</span>
            <select v-model="f.contact_method" name="contact_method" required :id="ids.contactMethod" class="form-input">
              <option value="">Choisir</option>
              <option>Téléphone</option>
              <option>E-mail</option>
              <option>SMS</option>
            </select>
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Date de sa demande *</span>
            <input v-model="f.consent_date" name="consent_date" type="date" required :max="todayLocal" :id="ids.consentDate" class="form-input">
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Preuve écrite de sa demande *</span>
            <select v-model="f.consent_evidence_type" name="consent_evidence_type" required :id="ids.consentEvidenceType" class="form-input">
              <option value="">Choisir</option>
              <option>SMS</option>
              <option>E-mail</option>
              <option>Autre écrit</option>
            </select>
          </label>

          <label class="flex flex-col gap-1">
            <span class="form-label">Preuve de la demande du client (si disponible)</span>
            <input
              type="file"
              name="consent_evidence"
              accept="application/pdf,image/png,image/jpeg,message/rfc822,.eml"
              :id="ids.consentEvidence"
              class="font-body text-sm text-ems-muted file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:bg-ems-green/10 file:text-ems-green file:font-body file:text-xs file:cursor-pointer hover:file:bg-ems-green/20 cursor-pointer"
            >
          </label>
        </div>

        <label class="flex items-start gap-3 cursor-pointer group">
          <input v-model="f.consent" type="checkbox" name="consent" value="1" required :id="ids.consent" class="mt-1 h-4 w-4 rounded border-ems-border bg-ems-dark accent-ems-green">
          <span class="font-body text-sm text-ems-muted leading-relaxed group-hover:text-ems-text transition-colors">
            Le client a demandé, avant cette transmission, à être contacté par <strong class="text-white">EMS</strong>
            pour ce projet et par le moyen indiqué. Je conserve sa demande écrite et la transmets selon le contrat. *
          </span>
        </label>

        <label class="flex items-start gap-3 cursor-pointer group">
          <input v-model="f.commission_disclosed" type="checkbox" name="commission_disclosed" value="1" required :id="ids.commissionDisclosed" class="mt-1 h-4 w-4 rounded border-ems-border bg-ems-dark accent-ems-green">
          <span class="font-body text-sm text-ems-muted leading-relaxed group-hover:text-ems-text transition-colors">
            J'ai informé le client que je peux recevoir une commission d'EMS si le projet aboutit. *
          </span>
        </label>
      </fieldset>

      <div class="border-t border-ems-border"></div>

      <!-- 03 / L'ORIGINE DU CONTACT -->
      <fieldset class="space-y-4 border-0 p-0 m-0">
        <legend class="sr-only">03 / L'origine du contact</legend>
        <div class="font-display font-bold text-ems-green text-xs uppercase tracking-widest">
          03 / L'origine du contact
        </div>
        <h3 class="font-display font-bold text-white uppercase text-base" tabindex="-1">
          Une présentation en toute transparence.
        </h3>

        <!-- Callout loyauté -->
        <aside
          id="engagement-loyaute"
          aria-labelledby="loyalty-title"
          class="rounded-xl border border-ems-border bg-ems-dark p-5 space-y-3"
        >
          <span class="section-label">À lire avant chaque recommandation</span>
          <h4 id="loyalty-title" class="font-display font-bold text-white uppercase text-base" tabindex="-1">
            Une recommandation loyale, sans détournement.
          </h4>
          <p class="font-body text-sm text-ems-muted leading-relaxed">
            Si ce contact vient de votre emploi ou d'un mandant, vérifiez vos obligations avant de le présenter à EMS.
          </p>
          <ul class="space-y-2 font-body text-sm text-ems-muted">
            <li><strong class="text-white">Ne détournez pas</strong> leurs clients, prospects ou opportunités en violation de vos obligations.</li>
            <li><strong class="text-white">N'utilisez pas sans autorisation</strong> leurs fichiers, leurs informations confidentielles ou leurs moyens.</li>
            <li><strong class="text-white">Renseignez-vous et obtenez les autorisations nécessaires</strong> auprès d'une personne habilitée avant la présentation.</li>
          </ul>
          <p class="font-body text-xs text-ems-muted/70 leading-relaxed">
            Un contact professionnel n'est pas automatiquement interdit. Déclarez son origine réelle
            et obtenez toute autorisation nécessaire&nbsp;; l'absence de partenariat avec un installateur
            ne vaut pas autorisation.
          </p>
          <div class="flex flex-wrap gap-3">
            <button type="button" class="font-body text-xs text-ems-green underline hover:text-white transition-colors" @click="$emit('open-contract', 4)">
              Lire les règles de loyauté · article 7 ↗
            </button>
            <button type="button" class="font-body text-xs text-ems-green underline hover:text-white transition-colors" @click="$emit('open-contract', 9)">
              Voir la fiche et l'engagement à signer · annexe 2 ↗
            </button>
          </div>
          <p class="font-body text-xs text-ems-muted/60 leading-relaxed">
            Pour les projets concernés, la fiche est signée pour chaque client. La case ci-dessous ne
            remplace ni cette signature ni une autorisation requise, et ne transfère pas automatiquement
            la responsabilité à EMS.
          </p>
        </aside>

        <label class="flex flex-col gap-1">
          <span class="form-label">Quel lien a ce projet avec votre activité professionnelle&nbsp;? *</span>
          <select v-model="f.professional_link" name="professional_link" required :id="ids.professionalLink" class="form-input">
            <option value="">Choisir</option>
            <option value="Non">Aucun lien identifié après vérification</option>
            <option value="Oui">Lien professionnel possible</option>
          </select>
        </label>

        <!-- Champs conditionnels lien professionnel -->
        <fieldset
          v-show="f.professional_link === 'Oui'"
          :disabled="f.professional_link !== 'Oui'"
          data-condition="linked-referral"
          class="space-y-4 border border-ems-border rounded-xl p-5"
        >
          <legend class="font-body text-xs text-ems-muted px-1">Origine du contact et autorisations</legend>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label class="flex flex-col gap-1">
              <span class="form-label">Profession / fonction *</span>
              <input v-model="f.profession" name="profession" :required="f.professional_link === 'Oui'" maxlength="160" :id="ids.profession" class="form-input">
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Employeur / mandant concerné *</span>
              <input v-model="f.employer" name="employer" :required="f.professional_link === 'Oui'" maxlength="200" :id="ids.employer" class="form-input">
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Origine du contact *</span>
              <select v-model="f.contact_origin" name="contact_origin" :required="f.professional_link === 'Oui'" :id="ids.contactOrigin" class="form-input">
                <option value="">Choisir</option>
                <option>Personnelle</option>
                <option>Professionnelle</option>
                <option>Les deux</option>
              </select>
            </label>
            <label class="flex flex-col gap-1 sm:col-span-2">
              <span class="form-label">Comment connaissez-vous ce client et son projet&nbsp;? *</span>
              <input v-model="f.origin_details" name="origin_details" :required="f.professional_link === 'Oui'" maxlength="1000" :id="ids.originDetails" class="form-input">
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Contact obtenu au travail / par ses moyens&nbsp;? *</span>
              <select v-model="f.work_resources" name="work_resources" :required="f.professional_link === 'Oui'" :id="ids.workResources" class="form-input">
                <option value="">Choisir</option>
                <option>Non</option>
                <option>Oui</option>
              </select>
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Client ou opportunité de votre employeur / mandant&nbsp;? *</span>
              <select v-model="f.employer_opportunity" name="employer_opportunity" :required="f.professional_link === 'Oui'" :id="ids.employerOpportunity" class="form-input">
                <option value="">Choisir</option>
                <option>Non</option>
                <option>Oui</option>
              </select>
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Un rôle dans le choix du fournisseur&nbsp;? *</span>
              <select v-model="f.supplier_role" name="supplier_role" :required="f.professional_link === 'Oui'" :id="ids.supplierRole" class="form-input">
                <option value="">Choisir</option>
                <option>Non</option>
                <option>Oui</option>
              </select>
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Partenariat / obligation pouvant être affecté&nbsp;? *</span>
              <select v-model="f.professional_restriction" name="professional_restriction" :required="f.professional_link === 'Oui'" :id="ids.professionalRestriction" class="form-input">
                <option value="">Choisir</option>
                <option>Non</option>
                <option>Oui</option>
              </select>
            </label>
            <label class="flex flex-col gap-1 sm:col-span-2">
              <span class="form-label">Vérifications et autorisation *</span>
              <select v-model="f.authorization_status" name="authorization_status" :required="f.professional_link === 'Oui'" :id="ids.authorizationStatus" class="form-input">
                <option value="">Choisir</option>
                <option>Apport personnel sans conflit identifié après vérification</option>
                <option>Apport professionnel compatible après vérification</option>
                <option>Autorisation écrite jointe</option>
              </select>
            </label>
            <label class="flex flex-col gap-1 sm:col-span-2">
              <span class="form-label">Auteur habilité / structure / date / portée</span>
              <input v-model="f.authorization_details" name="authorization_details" maxlength="1500" :id="ids.authorizationDetails" class="form-input">
            </label>
            <label class="flex flex-col gap-1">
              <span class="form-label">Autorisation écrite, si disponible</span>
              <input
                type="file"
                name="employer_authorization"
                accept="application/pdf,image/png,image/jpeg"
                :required="f.authorization_status === 'Autorisation écrite jointe'"
                :id="ids.employerAuthorization"
                class="font-body text-sm text-ems-muted file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:bg-ems-green/10 file:text-ems-green file:font-body file:text-xs file:cursor-pointer hover:file:bg-ems-green/20 cursor-pointer"
              >
            </label>
            <label class="flex flex-col gap-1 sm:col-span-2">
              <span class="form-label">Précisions sur les liens déclarés</span>
              <textarea v-model="f.professional_details" name="professional_details" rows="3" maxlength="2000" :id="ids.professionalDetails" class="form-input h-auto py-3"></textarea>
            </label>
          </div>
          <div class="rounded-md border border-ems-green/20 bg-ems-green/5 px-4 py-3">
            <p class="font-body text-xs text-ems-muted leading-relaxed">
              Avant l'envoi, effectuez les vérifications requises et joignez les autorisations nécessaires.
              La fiche client et l'engagement de loyauté signés restent exigés selon le contrat.
              Une déclaration ne remplace pas une autorisation requise.
            </p>
          </div>
        </fieldset>

        <!-- Checkbox loyauté -->
        <label class="flex items-start gap-3 cursor-pointer group">
          <input v-model="f.information_confirmed" type="checkbox" name="information_confirmed" value="1" required :id="ids.informationConfirmed" class="mt-1 h-4 w-4 rounded border-ems-border bg-ems-dark accent-ems-green">
          <span class="font-body text-sm text-ems-muted leading-relaxed group-hover:text-ems-text transition-colors">
            J'ai pris connaissance des règles de loyauté de l'article 7 et de l'annexe applicable.
            Après vérification de mes obligations, je confirme la sincérité des informations déclarées
            pour ce client. Je ne détourne pas de clients, prospects ou opportunités de mon employeur
            ou mandant en violation de mes obligations et n'utilise ni ne transmets sans autorisation
            leurs fichiers, informations confidentielles ou moyens. J'ai obtenu les autorisations
            nécessaires à cette présentation rémunérée. *
          </span>
        </label>
      </fieldset>

      <!-- Honeypot -->
      <div class="absolute -left-[9999px] overflow-hidden h-px w-px" aria-hidden="true">
        <label>Ne pas remplir<input name="website" tabindex="-1" autocomplete="off"></label>
      </div>

      <!-- Politique de confidentialité -->
      <p class="font-body text-xs text-ems-muted/70">
        Les données du client sont utilisées pour ce projet, la présentation et son suivi.
        EMS informera le client de leur origine et de ses droits selon le contrat.
        <RouterLink to="/privacy" class="text-ems-green underline hover:text-white transition-colors">
          Politique de confidentialité
        </RouterLink>.
      </p>

      <!-- Vérifications pré-envoi -->
      <div class="rounded-xl border border-ems-border bg-ems-dark/50 p-5 space-y-3">
        <ul class="space-y-1">
          <li v-for="check in verificationList" :key="check" class="flex items-start gap-2 font-body text-xs text-ems-muted">
            <span aria-hidden="true" class="text-ems-green flex-shrink-0">✓</span>{{ check }}
          </li>
        </ul>
        <label class="flex flex-col gap-1">
          <span class="form-label">Vérifications requises avant envoi *</span>
          <select v-model="f.checks_completed" name="checks_completed" required :id="ids.checksCompleted" class="form-input">
            <option value="">Choisir</option>
            <option value="Non">Non, je n'ai pas encore effectué les vérifications</option>
            <option value="Oui">Oui, j'ai effectué les vérifications requises</option>
          </select>
        </label>
        <p class="font-body text-xs text-ems-muted">
          Si une vérification reste à faire, terminez-la avant l'envoi. EMS examinera ensuite votre dossier.
        </p>
        <p v-if="f.checks_completed === 'Non'" role="status" aria-live="polite" class="font-body text-xs text-red-400">
          L'envoi est bloqué tant que les vérifications ne sont pas terminées. Vous pouvez compléter les champs sans transmettre le dossier.
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
          <span v-else>Transmettre la présentation <span aria-hidden="true">↗</span></span>
        </button>
        <span class="font-body text-xs text-ems-muted">
          La présentation sera adressée à EMS pour examen. Vous recevrez une réponse écrite selon le contrat.
        </span>
      </div>

      <p class="font-body text-xs text-ems-muted/70">
        La suite&nbsp;: EMS examine la présentation et vous répond par écrit sous 7 jours calendaires,
        selon le contrat. L'envoi ne vaut pas acceptation.
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
import { ref, reactive, computed, useId, watch } from 'vue'
import { RouterLink } from 'vue-router'
import { useFormSubmit } from '@/composables/useFormSubmit.js'
import { useZoneFeedback } from '@/composables/useConditionalFields.js'

const emit = defineEmits(['open-contract'])

const _id = useId()
const ids = {
  heading: `${_id}-heading`,
  partnerName: `${_id}-partner-name`,
  partnerSiret: `${_id}-partner-siret`,
  partnerEmail: `${_id}-partner-email`,
  partnerPhone: `${_id}-partner-phone`,
  contractRef: `${_id}-contract-ref`,
  clientName: `${_id}-client-name`,
  clientPhone: `${_id}-client-phone`,
  phoneError: `${_id}-phone-error`,
  clientEmail: `${_id}-client-email`,
  emailError: `${_id}-email-error`,
  siteType: `${_id}-site-type`,
  address: `${_id}-address`,
  postalCode: `${_id}-postal-code`,
  city: `${_id}-city`,
  zoneFeedback: `${_id}-zone-feedback`,
  plannedUnits: `${_id}-planned-units`,
  vehicle: `${_id}-vehicle`,
  need: `${_id}-need`,
  contactMethod: `${_id}-contact-method`,
  consentDate: `${_id}-consent-date`,
  consentEvidenceType: `${_id}-consent-evidence-type`,
  consentEvidence: `${_id}-consent-evidence`,
  consent: `${_id}-consent`,
  commissionDisclosed: `${_id}-commission-disclosed`,
  professionalLink: `${_id}-professional-link`,
  profession: `${_id}-profession`,
  employer: `${_id}-employer`,
  contactOrigin: `${_id}-contact-origin`,
  originDetails: `${_id}-origin-details`,
  workResources: `${_id}-work-resources`,
  employerOpportunity: `${_id}-employer-opportunity`,
  supplierRole: `${_id}-supplier-role`,
  professionalRestriction: `${_id}-professional-restriction`,
  authorizationStatus: `${_id}-authorization-status`,
  authorizationDetails: `${_id}-authorization-details`,
  employerAuthorization: `${_id}-employer-authorization`,
  professionalDetails: `${_id}-professional-details`,
  informationConfirmed: `${_id}-information-confirmed`,
  checksCompleted: `${_id}-checks-completed`,
}

const formId = `${_id}-referral-form`

// Date max = aujourd'hui
const today = new Date()
const todayLocal = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`

const f = reactive({
  partner_name: '',
  partner_siret: '',
  partner_email: '',
  partner_phone: '',
  contract_reference: '',
  client_name: '',
  client_phone: '',
  client_email: '',
  site_type: '',
  address: '',
  postal_code: '',
  city: '',
  planned_units: '',
  vehicle: '',
  need: '',
  contact_method: '',
  consent_date: '',
  consent_evidence_type: '',
  consent: false,
  commission_disclosed: false,
  professional_link: '',
  profession: '',
  employer: '',
  contact_origin: '',
  origin_details: '',
  work_resources: '',
  employer_opportunity: '',
  supplier_role: '',
  professional_restriction: '',
  authorization_status: '',
  authorization_details: '',
  professional_details: '',
  information_confirmed: false,
  checks_completed: '',
})

// Zone feedback
const postalCodeRef = computed(() => f.postal_code)
const { feedback: zoneFeedback, inZone } = useZoneFeedback(postalCodeRef)

// Erreurs contact client
const phoneError = ref('')
const emailError = ref('')

function validateClientContact() {
  phoneError.value = ''
  emailError.value = ''
  const phone = f.client_phone.trim()
  const email = f.client_email.trim()
  const method = f.contact_method
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

// Soumission
const { status: submitStatus, message: submitMessage, sent, submit, resetSubmissionId } = useFormSubmit('referral')

function onFormInput() {
  resetSubmissionId()
}

async function onSubmit() {
  if (f.checks_completed !== 'Oui') {
    submitStatus.value = 'error'
    submitMessage.value = "Effectuez les vérifications requises et complétez votre dossier avant de l'envoyer."
    return
  }

  if (!validateClientContact()) return

  const form = document.getElementById(formId)
  if (!form || !form.reportValidity()) return

  const fileLists = [...form.querySelectorAll('input[type=file]')]
    .filter(i => !i.disabled && !i.closest('fieldset[disabled]'))
    .map(i => i.files)

  const formData = new FormData(form)
  await submit(formData, fileLists)
}

const verificationList = [
  'Demande de contact du client et information sur la commission confirmées.',
  'Origine du contact et obligations professionnelles vérifiées.',
  'Autorisations nécessaires obtenues.',
]
</script>
