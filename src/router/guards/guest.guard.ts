import type { RouteLocationNormalized } from 'vue-router'
import Cookie from 'js-cookie'
import { StorageKeyEnum } from '@/shared/core/enums/storage.enum'
import { PageEnum } from '@/shared/core/enums/page.enum'

export const GuestGuard = async (to: RouteLocationNormalized, from: RouteLocationNormalized) => {
  const accessToken = Cookie.get(StorageKeyEnum.ACCESS_TOKEN)

  if (accessToken) {
    return { name: PageEnum.DASHBOARD }
  }

  return true
}
