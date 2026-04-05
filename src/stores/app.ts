import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', () => {
  const isPageLoading = ref(false)

  function startLoading() {
    isPageLoading.value = true
  }

  function stopLoading() {
    isPageLoading.value = false
  }

  return { isPageLoading, startLoading, stopLoading }
})
