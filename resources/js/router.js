import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'
import Reviews from './components/Pages/Reviews.vue'
import Settings from './components/Pages/Settings.vue'

const routes = [
  { path: '/reviews', component: Reviews, meta: { auth: true } },
  { path: '/settings', component: Settings, meta: { auth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Навигационные гварды
router.beforeEach(async (to, from, next) => {
  if (!to.meta.auth && !to.meta.guest) return next()

  try {
    // Проверяем текущую сессию через Laravel
    const response = await axios.get('/user', { withCredentials: true })
    const isAuthenticated = response.status === 200

    if (to.meta.auth && !isAuthenticated) {
      next({ path: '/' })
    } else if (to.meta.guest && isAuthenticated) {
      next({ path: '/reviews' })
    } else {
      next()
    }
  } catch (err) {
    if (to.meta.auth) {
      next({ path: '/' })
    } else {
      next()
    }
  }
})

export default router