import type { RouteRecordRaw } from 'vue-router'
import { ResolveGuard } from '@/router/guards'
import { GuestGuard } from '@/router/guards/guest.guard'
import { PageEnum, PagePath } from '@/shared/core/enums/page.enum'

export const authRoutes: RouteRecordRaw[] = [
  {
    path: PagePath.LOGIN,
    name: PageEnum.LOGIN,
    component: () => import('@/modules/auth/LoginPage.vue'),
    beforeEnter: ResolveGuard([GuestGuard]),
  },
  {
    path: PagePath.REGISTER,
    name: PageEnum.REGISTER,
    component: () => import('@/modules/auth/RegisterPage.vue'),
    beforeEnter: ResolveGuard([GuestGuard]),
  },
]
