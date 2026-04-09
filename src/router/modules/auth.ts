import type { RouteRecordRaw } from 'vue-router'
import { LayoutEnum } from '@/shared/core/enums/layout.enum'

export const authRoutes: RouteRecordRaw[] = [
  {
    path: '/login',
    name: 'login',
    component: () => import('@/modules/auth/LoginView.vue'),
    meta: { layout: LayoutEnum.AUTH },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/modules/auth/RegisterView.vue'),
    meta: { layout: LayoutEnum.AUTH },
  },
]
