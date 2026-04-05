import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@/router/routes'

import { useAppStore } from '@/stores/app'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach(() => {
  const app = useAppStore()
  app.startLoading()
})

router.afterEach(() => {
  const app = useAppStore()
  app.stopLoading()
})

export default router
