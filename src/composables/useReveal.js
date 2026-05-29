import { ref, onMounted } from 'vue'

/**
 * Composable — déclenche une animation de révélation quand l'élément
 * entre dans le viewport (IntersectionObserver).
 *
 * Usage :
 *   const { el, visible } = useReveal()
 *   <div ref="el" :class="['reveal', visible && 'visible']">...</div>
 *
 * @param {number} threshold  Fraction de l'élément visible avant déclenchement (0–1)
 * @param {number} rootMargin Marge autour du viewport (px)
 */
export function useReveal(threshold = 0.12, rootMargin = '0px') {
  const el      = ref(null)
  const visible = ref(false)

  onMounted(() => {
    if (!el.value) return

    // Fallback si IntersectionObserver non disponible
    if (!('IntersectionObserver' in window)) {
      visible.value = true
      return
    }

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          visible.value = true
          observer.disconnect()
        }
      },
      { threshold, rootMargin }
    )

    observer.observe(el.value)
  })

  return { el, visible }
}
