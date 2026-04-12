import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@/router/routes'

import { useGeneralStore } from '@/stores/general.store'
import { LayoutEnum } from '@/shared/core/enums/layout.enum'
import _ from 'lodash'
import { nextTick } from 'vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach(async (to, from) => {
  return true
})

router.afterEach(async (to) => {
  await nextTick()
  const { onSetLayout, endLoading } = useGeneralStore()
  const layout = (to.meta.layout as string) || LayoutEnum.DEFAULT
  onSetLayout(layout)
  endLoading()
})

export default router
