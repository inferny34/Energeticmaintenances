<template>
  <!-- LECTEUR DE CONTRAT (dialog natif) -->
  <dialog
    ref="dialogEl"
    :id="ids.dialog"
    aria-labelledby="reader-title"
    class="w-full max-w-3xl mx-auto rounded-2xl border border-ems-border bg-ems-dark
           p-0 backdrop:bg-black/70 open:flex open:flex-col"
    style="max-height: 92dvh;"
    @close="onClose"
    @click="onBackdropClick"
    @keydown="onKeydown"
  >
    <!-- En-tête -->
    <div class="flex items-center justify-between gap-4 px-5 py-4 border-b border-ems-border bg-ems-surface flex-shrink-0">
      <div class="min-w-0">
        <strong id="reader-title" class="font-body font-bold text-sm text-white block truncate">
          Le contrat d'apporteur EMS
        </strong>
        <span class="font-body text-xs text-ems-muted">Version 8 du 27/10/2026</span>
      </div>

      <div class="flex items-center gap-2 flex-shrink-0">
        <!-- Menu PDF/Imprimer -->
        <div class="relative">
          <button
            :id="ids.menuBtn"
            type="button"
            aria-label="Télécharger le contrat"
            :aria-expanded="menuOpen"
            :aria-controls="ids.menu"
            class="p-2 text-ems-muted hover:text-white transition-colors rounded-lg hover:bg-ems-border text-lg leading-none"
            @click="menuOpen = !menuOpen"
          >
            ⋮
          </button>
          <div
            v-show="menuOpen"
            :id="ids.menu"
            class="absolute right-0 top-full mt-1 z-10 min-w-36 rounded-lg border border-ems-border bg-ems-surface shadow-xl"
          >
            <a
              href="/contrat/contrat-apporteur-ems-v8.pdf"
              target="_blank"
              rel="noopener"
              class="flex items-center gap-2 px-4 py-2.5 font-body text-sm text-ems-muted hover:text-white hover:bg-ems-border/50 transition-colors first:rounded-t-lg"
            >
              Imprimer / voir PDF
            </a>
            <a
              href="/contrat/contrat-apporteur-ems-v8.pdf"
              download="Contrat_Apporteur_EMS_V8_Professionnels.pdf"
              class="flex items-center gap-2 px-4 py-2.5 font-body text-sm text-ems-muted hover:text-white hover:bg-ems-border/50 transition-colors last:rounded-b-lg"
            >
              Télécharger PDF
            </a>
          </div>
        </div>

        <!-- Fermer -->
        <button
          :id="ids.close"
          ref="closeBtn"
          type="button"
          aria-label="Fermer le contrat"
          class="p-2 text-ems-muted hover:text-white transition-colors rounded-lg hover:bg-ems-border text-lg leading-none"
          @click="close"
        >
          ×
        </button>
      </div>
    </div>

    <!-- Zone image + texte SR -->
    <div
      ref="swipeEl"
      class="flex-1 overflow-auto flex items-center justify-center bg-black/20 min-h-0"
      @touchstart.passive="onTouchStart"
      @touchend.passive="onTouchEnd"
    >
      <!-- Image de la page courante -->
      <template v-if="pages.length">
        <img
          v-show="!loading && !loadError"
          :key="currentPage"
          :src="pages[currentPage]?.image"
          :alt="`Page ${currentPage + 1} du contrat EMS, version 8`"
          draggable="false"
          class="max-w-full max-h-full object-contain select-none"
          @load="loading = false; loadError = false"
          @error="loading = false; loadError = true"
        >
        <div
          v-if="loading"
          role="status"
          aria-live="polite"
          class="font-body text-sm text-ems-muted p-8 text-center"
        >
          Chargement de la page…
        </div>
        <div
          v-if="loadError"
          role="status"
          aria-live="polite"
          class="font-body text-sm text-red-400 p-8 text-center"
        >
          Cette page n'a pas pu être chargée. Utilisez les trois points pour télécharger le PDF complet.
        </div>
      </template>
      <div v-else role="status" class="font-body text-sm text-ems-muted p-8">
        Chargement du contrat…
      </div>

      <!-- Texte accessible (sr-only) -->
      <div class="sr-only" aria-live="polite">
        {{ pages[currentPage]?.text ?? '' }}
      </div>
    </div>

    <!-- Bas : navigation -->
    <div class="flex items-center justify-between gap-4 px-5 py-3 border-t border-ems-border bg-ems-surface flex-shrink-0">
      <button
        type="button"
        aria-label="Page précédente"
        :disabled="currentPage === 0"
        class="p-2 rounded-lg border border-ems-border text-ems-muted hover:text-white hover:border-ems-green
               disabled:opacity-30 disabled:cursor-not-allowed transition-all"
        @click="goTo(currentPage - 1)"
      >
        ←
      </button>

      <span aria-live="polite" class="font-body text-sm text-ems-muted">
        {{ pages.length ? `${currentPage + 1} / ${pages.length}` : '…' }}
      </span>

      <button
        type="button"
        aria-label="Page suivante"
        :disabled="currentPage >= pages.length - 1"
        class="p-2 rounded-lg border border-ems-border text-ems-muted hover:text-white hover:border-ems-green
               disabled:opacity-30 disabled:cursor-not-allowed transition-all"
        @click="goTo(currentPage + 1)"
      >
        →
      </button>
    </div>
  </dialog>
</template>

<script setup>
import { ref, shallowRef, watch, nextTick, useId } from 'vue'

const props = defineProps({
  /** Page 0-based à afficher à l'ouverture */
  openAtPage: {
    type: Number,
    default: 0,
  },
})

const emit = defineEmits(['close'])

const _id = useId()
const ids = {
  dialog: `${_id}-contract-dialog`,
  menuBtn: `${_id}-menu-btn`,
  menu: `${_id}-menu`,
  close: `${_id}-close`,
}

const dialogEl = ref(null)
const closeBtn = ref(null)
const swipeEl = ref(null)

const pages = shallowRef([])
const currentPage = ref(0)
const loading = ref(false)
const loadError = ref(false)
const menuOpen = ref(false)
const lastFocus = ref(null)

// Chargement différé du JSON de pages
async function loadPages() {
  if (pages.value.length) return
  try {
    const data = await import('@/data/contract-pages.json')
    pages.value = data.pages ?? data.default?.pages ?? []
  } catch {
    pages.value = []
  }
}

function goTo(index) {
  if (!pages.value.length) return
  const clamped = Math.max(0, Math.min(pages.value.length - 1, index))
  if (clamped === currentPage.value) return
  loading.value = true
  loadError.value = false
  currentPage.value = clamped
  menuOpen.value = false
}

/** Ouvre le dialog à la page demandée */
async function open(page = 0) {
  lastFocus.value = document.activeElement
  await loadPages()

  // Préchargement de la page d'après
  if (pages.value[page + 1]?.image) {
    const img = new Image()
    img.src = pages.value[page + 1].image
  }

  loading.value = true
  loadError.value = false
  currentPage.value = Math.max(0, Math.min(pages.value.length - 1, page))

  if (dialogEl.value) {
    document.body.style.overflow = 'hidden'
    dialogEl.value.showModal()
    await nextTick()
    closeBtn.value?.focus()
  }
}

function close() {
  dialogEl.value?.close()
}

function onClose() {
  document.body.style.overflow = ''
  menuOpen.value = false
  emit('close')
  nextTick(() => {
    lastFocus.value?.focus()
  })
}

/** Clic sur le fond du dialog */
function onBackdropClick(event) {
  if (event.target !== dialogEl.value) return
  const rect = dialogEl.value.getBoundingClientRect()
  const outside =
    event.clientX < rect.left ||
    event.clientX > rect.right ||
    event.clientY < rect.top ||
    event.clientY > rect.bottom
  if (outside) close()
}

/** Navigation clavier */
function onKeydown(event) {
  if (event.key === 'ArrowRight') { event.preventDefault(); goTo(currentPage.value + 1) }
  if (event.key === 'ArrowLeft') { event.preventDefault(); goTo(currentPage.value - 1) }
}

// Swipe tactile
let touchStart = null
function onTouchStart(event) {
  touchStart =
    event.touches.length === 1
      ? { x: event.touches[0].clientX, y: event.touches[0].clientY }
      : null
}
function onTouchEnd(event) {
  if (!touchStart || event.changedTouches.length !== 1) return
  const dx = event.changedTouches[0].clientX - touchStart.x
  const dy = event.changedTouches[0].clientY - touchStart.y
  const scale = window.visualViewport?.scale ?? 1
  if (scale <= 1.05) {
    if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy) * 1.4) {
      goTo(currentPage.value + (dx < 0 ? 1 : -1))
    } else if (Math.abs(dy) > 55 && Math.abs(dy) > Math.abs(dx) * 1.4) {
      goTo(currentPage.value + (dy < 0 ? 1 : -1))
    }
  }
  touchStart = null
}

// Exposer open() au parent
defineExpose({ open, close })
</script>
