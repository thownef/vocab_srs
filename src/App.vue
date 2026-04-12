<template>
  <component class="app-wrapper" :is="layout" v-if="layout" />
  <AppNotification />
</template>

<script setup lang="ts">
import { LayoutEnum } from '@/shared/core/enums/layout.enum'
import { useGeneralStore } from '@/stores/general.store'
import { useHead } from '@unhead/vue'
import { computed, defineAsyncComponent } from 'vue'
import AppNotification from '@/components/Notification/AppNotification.vue'

const LoadingLayout = defineAsyncComponent(() => import('@/components/Layout/LoadingLayout.vue'))
const BasicLayout = defineAsyncComponent(() => import('@/components/Layout/BasicLayout.vue'))

const general = useGeneralStore()

const layout = computed(() => {
  switch (general.layout) {
    case LayoutEnum.AUTH:
      return BasicLayout
    case LayoutEnum.DEFAULT:
      return BasicLayout
    default:
      return LoadingLayout
  }
})

useHead({
  titleTemplate: 'LexiLoom',
})
</script>

<style scoped></style>
