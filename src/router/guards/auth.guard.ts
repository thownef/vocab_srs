import type { RouteLocationNormalized } from 'vue-router'
import Cookie from 'js-cookie'
import { StorageKeyEnum } from '@/shared/core/enums/storage.enum'
import { useAuthStore } from '@/stores/auth.store'
import AuthService from '@/shared/services/auth.service'
import { PageEnum } from '@/shared/core/enums/page.enum'

export const AuthGuard = async (to: RouteLocationNormalized, from: RouteLocationNormalized) => {
  const accessToken = Cookie.get(StorageKeyEnum.ACCESS_TOKEN)
  const authStore = useAuthStore()

  if (!accessToken) {
    return { name: PageEnum.LOGIN }
  }

  if (!authStore.profile) {
    try {
      const response = await AuthService.getProfile()
      authStore.setProfile(response.data.data)
      return true
    } catch (error) {
      authStore.clearAuth()
      return { name: PageEnum.LOGIN }
    }
  }

  return true
}
