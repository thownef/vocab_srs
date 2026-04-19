import type { RouteRecordRaw } from 'vue-router'
import { authRoutes } from '@/router/modules/auth'
import { ResolveGuard } from '@/router/guards'
import { AuthGuard } from '@/router/guards/auth.guard'
import { PageEnum } from '@/shared/core/enums/page.enum'

export const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('@/components/Layout/DefaultLayout.vue'),
    beforeEnter: ResolveGuard([AuthGuard]),
    children: [
      {
        path: '',
        name: PageEnum.DASHBOARD,
        component: () => import('@/modules/dashboard/DashboardPage.vue'),
      },
    ],
  },
  ...authRoutes,
]
