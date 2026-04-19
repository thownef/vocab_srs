import { nextTick } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@/router/routes'
import { useGeneralStore } from '@/stores/general.store'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach(async (to, from) => {
  return true
})

router.afterEach(async (to) => {
  await nextTick()
  const { endLoading } = useGeneralStore()
  endLoading()
})

export default router
