<template>
  <Transition name="fade">
    <div v-if="app.isPageLoading" class="page-loader">
      <span class="spinner" />
    </div>
  </Transition>

  <RouterView />
</template>

<script setup lang="ts">
import { useAppStore } from '@/stores/app'
import { useHead } from '@unhead/vue'

const app = useAppStore()

useHead({
  titleTemplate: 'LexiLoom',
})
</script>

<style scoped>
.page-loader {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.6);
  backdrop-filter: blur(4px);
}

.spinner {
  width: 36px;
  height: 36px;
  border: 3px solid #e2e8f0;
  border-top-color: #6366f1;
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
