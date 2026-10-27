import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: {
      title: 'Borne de recharge à domicile en Occitanie | Hérault, Gard… — EMS',
      description: 'Installation de bornes de recharge pour véhicules électriques à domicile en Occitanie et départements limitrophes : Hérault, Gard, Bouches-du-Rhône… Maintenance HTA & dépannage. Devis gratuit.',
      robots: 'index, follow',
    },
  },
  {
    path: '/apporteurs',
    name: 'apporteurs',
    component: () => import('../views/ApporteursView.vue'),
    meta: {
      title: 'Programme Apporteurs d’Affaires | EMS Energetic Maintenances Services',
      description: 'Devenez apporteur d’affaires EMS ou recommandez un client pour l’installation de borne de recharge électrique. Rémunération jusqu’à 130 € par borne.',
      // TODO client : Définir si la page doit être indexée ou rester privée
      // Par défaut : noindex, nofollow selon les consignes du projet
      robots: 'noindex, nofollow',
    },
  },
  {
    path: '/mentions',
    name: 'mentions',
    component: () => import('../components/MentionsLegales.vue'),
    meta: {
      title: 'Mentions Légales — Energetic Maintenances Services',
      robots: 'noindex, follow',
    },
  },
  {
    path: '/privacy',
    name: 'privacy',
    component: () => import('../components/PolitiqueConfidentialite.vue'),
    meta: {
      title: 'Politique de Confidentialité — Energetic Maintenances Services',
      robots: 'noindex, follow',
    },
  },
  // Redirection ou fallback pour compatibilité éventuelle
  {
    path: '/:pathMatch(.*)*',
    redirect: '/',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    if (to.hash) {
      const prefersReducedMotion = typeof window !== 'undefined' &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches

      return new Promise((resolve) => {
        // Attente du rendu DOM (surtout lors de la transition inter-pages)
        setTimeout(() => {
          const el = document.querySelector(to.hash)
          if (el) {
            resolve({
              el: to.hash,
              top: 80, // Offset pour le header fixe (NavBar h-16 = 64px)
              behavior: prefersReducedMotion ? 'instant' : 'smooth',
            })
          } else {
            resolve({ top: 0, behavior: 'instant' })
          }
        }, 120)
      })
    }
    return { top: 0, behavior: 'instant' }
  },
})

// Mise à jour dynamique du <title> et des balises méta (SEO & robots)
router.afterEach((to) => {
  if (to.meta?.title) {
    document.title = to.meta.title
  }

  // Description
  let metaDesc = document.querySelector('meta[name="description"]')
  if (to.meta?.description) {
    if (!metaDesc) {
      metaDesc = document.createElement('meta')
      metaDesc.name = 'description'
      document.head.appendChild(metaDesc)
    }
    metaDesc.content = to.meta.description
  }

  // Robots (ex: noindex, nofollow sur /apporteurs)
  let metaRobots = document.querySelector('meta[name="robots"]')
  if (to.meta?.robots) {
    if (!metaRobots) {
      metaRobots = document.createElement('meta')
      metaRobots.name = 'robots'
      document.head.appendChild(metaRobots)
    }
    metaRobots.content = to.meta.robots
  }
})

export default router
