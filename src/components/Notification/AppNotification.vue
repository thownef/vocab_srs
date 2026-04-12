<template>
  <div class="fixed top-6 right-6 z-9999 flex flex-col gap-3 pointer-events-none">
    <transition-group name="notification">
      <div
        v-for="n in store.notifications"
        :key="n.id"
        class="pointer-events-auto flex items-center justify-between min-w-[320px] max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 overflow-hidden relative group"
        v-motion
        :initial="{ opacity: 0, x: 50, scale: 0.9 }"
        :enter="{ opacity: 1, x: 0, scale: 1 }"
        :leave="{ opacity: 0, scale: 0.9, transition: { duration: 200 } }"
      >
        <!-- Progress Bar -->
        <div
          class="absolute bottom-0 left-0 h-1 bg-current opacity-20 transition-all duration-linear"
          :class="typeClasses[n.type].text"
          :style="{ width: '100%', transitionDuration: `${n.duration}ms` }"
        ></div>

        <div class="flex items-center gap-3">
          <div :class="typeClasses[n.type].bg" class="p-2 rounded-xl">
            <component
              :is="typeClasses[n.type].icon"
              :class="typeClasses[n.type].text"
              class="w-5 h-5"
            />
          </div>
          <p class="text-slate-700 font-semibold text-sm">{{ n.message }}</p>
        </div>

        <button
          @click="removeNotification(n.id)"
          class="ml-4 text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-50 transition-colors"
        >
          <X class="w-4 h-4" />
        </button>
      </div>
    </transition-group>
  </div>
</template>

<script setup lang="ts">
import { useNotificationStore } from '@/stores/notification.store'
import { CheckCircle2, AlertCircle, Info, AlertTriangle, X } from 'lucide-vue-next'
import { markRaw } from 'vue'

const store = useNotificationStore()
const { removeNotification } = store

const typeClasses = {
  success: {
    bg: 'bg-emerald-50',
    text: 'text-emerald-500',
    icon: markRaw(CheckCircle2),
  },
  error: {
    bg: 'bg-rose-50',
    text: 'text-rose-500',
    icon: markRaw(AlertCircle),
  },
  info: {
    bg: 'bg-sky-50',
    text: 'text-sky-500',
    icon: markRaw(Info),
  },
  warning: {
    bg: 'bg-amber-50',
    text: 'text-amber-500',
    icon: markRaw(AlertTriangle),
  },
}
</script>

<style scoped>
.notification-move,
.notification-enter-active,
.notification-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.notification-enter-from,
.notification-leave-to {
  opacity: 0;
  transform: translateX(30px) scale(0.9);
}

.notification-leave-active {
  position: absolute;
}
</style>
