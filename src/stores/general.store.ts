import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { pinia } from '@/stores/pinia'
import _ from 'lodash'

export const useGeneralStore = defineStore('general', () => {
  const isLoading = ref(false)
  const layout = ref()

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

  const handleSetLayout = (layoutName: string) => {
    layout.value = layoutName
  }

  return {
    isLoading,
    layout,
    startLoading,
    endLoading,
    onSetLayout: handleSetLayout,
  }
})

export const generalStore = useGeneralStore(pinia)
