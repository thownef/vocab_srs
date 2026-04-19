<template>
  <LoadingLayout v-if="isLoading" />
  <div v-else class="app-wrapper">
    <RouterView />
  </div>
  <AppNotification />
</template>

<script setup lang="ts">
import { useGeneralStore } from '@/stores/general.store'
import { useHead } from '@unhead/vue'
import { computed, defineAsyncComponent } from 'vue'
import AppNotification from '@/components/Notification/AppNotification.vue'

const LoadingLayout = defineAsyncComponent(() => import('@/components/Layout/LoadingLayout.vue'))

const general = useGeneralStore()

const isLoading = computed(() => general.isLoading)

useHead({
  titleTemplate: 'LexiLoom',
})
</script>

<style scoped></style>
