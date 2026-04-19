<script setup lang="ts">
import { Bell, Search } from 'lucide-vue-next'
import { useAuthStore } from '@/stores/auth.store'
import AppSidebar from '@/components/Sidebar/AppSidebar.vue'

const authStore = useAuthStore()
</script>

<template>
  <div class="flex min-h-screen bg-[#F8FAFC]">
    <AppSidebar />

    <main class="flex-1 ml-64 p-8">
      <header class="flex items-center justify-between mb-8">
        <div class="relative w-96 group">
          <Search
            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5 group-focus-within:text-blue-500 transition-colors"
          />
          <input
            type="text"
            placeholder="Search your sanctuary..."
            class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium text-slate-900 placeholder:text-slate-400 shadow-sm"
          />
        </div>

        <div class="flex items-center gap-6">
          <button
            class="relative p-3 text-slate-400 hover:text-slate-600 bg-white border border-slate-200 rounded-2xl transition-all hover:shadow-md active:scale-95"
          >
            <Bell class="w-5 h-5" />
            <span
              class="absolute top-2.5 right-3 w-2 h-2 bg-red-500 rounded-full border border-white"
            ></span>
          </button>

          <div class="flex items-center gap-4 pl-6 border-l border-slate-200">
            <div class="text-right">
              <p class="text-sm font-bold text-slate-900">
                {{ authStore.profile?.name || 'Scholar' }}
              </p>
              <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-0.5">
                Apprentice
              </p>
            </div>
            <div
              class="w-12 h-12 rounded-2xl bg-blue-100 border border-slate-200 overflow-hidden shadow-sm"
            >
              <img
                :src="`https://api.dicebear.com/7.x/avataaars/svg?seed=${authStore.profile?.name || 'Alex'}`"
                alt="Avatar"
                class="w-full h-full object-cover"
              />
            </div>
          </div>
        </div>
      </header>

      <!-- Content Area -->
      <RouterView v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" :key="$route.path" />
        </transition>
      </RouterView>
    </main>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition:
    opacity 0.3s ease,
    transform 0.3s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
