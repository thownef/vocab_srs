import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useGeneralStore = defineStore('general', () => {
  const isLoading = ref(false)

  const startLoading = () => {
    isLoading.value = true
    const loadingEl = document.querySelector('.loading-mask') as HTMLElement
    if (loadingEl) {
      loadingEl.style.display = 'block'
      loadingEl.style.opacity = '1'
    }
  }

  const endLoading = () => {
    isLoading.value = false
    const loadingEl = document.querySelector('.loading-mask') as HTMLElement
    if (loadingEl) {
      loadingEl.style.transition = 'opacity 0.3s ease'
      loadingEl.style.opacity = '0'
      setTimeout(() => {
        loadingEl.style.display = 'none'
      }, 300)
    }
  }

  return {
    isLoading,
    startLoading,
    endLoading,
  }
})
