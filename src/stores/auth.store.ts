import { defineStore } from 'pinia'
import { ref } from 'vue'
import Cookie from 'js-cookie'
import { StorageKeyEnum } from '@/shared/core/enums/storage.enum'
import type { User } from '@/modules/auth/core/config/types/auth.type'

export const useAuthStore = defineStore('auth', () => {
  const profile = ref<User | null>(null)

  const setProfile = (data: User) => {
    profile.value = data
  }

  const clearAuth = () => {
    profile.value = null
    Cookie.remove(StorageKeyEnum.ACCESS_TOKEN)
  }

  return {
    profile,
    setProfile,
    clearAuth,
  }
})
