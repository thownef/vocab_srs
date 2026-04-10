import type { RouteLocationNormalized } from 'vue-router'
import Cookie from 'js-cookie'
import { useAuthStore } from '@/stores/auth.store'
import AuthService from '@/shared/services/auth.service'

export const AuthGuard = async (to: RouteLocationNormalized, from: RouteLocationNormalized) => {
  const accessToken = Cookie.get('accessToken')
  const authStore = useAuthStore()

  if (!accessToken) {
    return { name: 'login' }
  }

  if (!authStore.profile) {
    try {
      const response = await AuthService.getProfile()
      authStore.setProfile(response.data.data)
      return true
    } catch (error) {
      authStore.clearAuth()
      return { name: 'login' }
    }
  }

  return true
}
