import type { RouteRecordRaw } from 'vue-router'
import { LayoutEnum } from '@/shared/core/enums/layout.enum'
import { ResolveGuard } from '@/router/guards'
import { GuestGuard } from '@/router/guards/guest.guard'

export const authRoutes: RouteRecordRaw[] = [
  {
    path: '/login',
    name: 'login',
    component: () => import('@/modules/auth/LoginView.vue'),
    meta: { layout: LayoutEnum.AUTH },
    beforeEnter: ResolveGuard([GuestGuard]),
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/modules/auth/RegisterView.vue'),
    meta: { layout: LayoutEnum.AUTH },
    beforeEnter: ResolveGuard([GuestGuard]),
  },
]
