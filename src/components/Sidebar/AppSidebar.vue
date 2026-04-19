<template>
  <aside class="w-64 h-screen bg-white border-r border-slate-200 flex flex-col fixed left-0 top-0">
    <div class="p-8 flex items-center gap-3">
      <div
        class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200"
      >
        <Sparkles class="text-white w-6 h-6" />
      </div>
      <span class="text-2xl font-black tracking-tight text-slate-900">Sanctuary</span>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-2">
      <RouterLink
        v-for="item in navItems"
        :key="item.path"
        :to="item.path"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all group"
        active-class="!text-blue-600 !bg-blue-50"
      >
        <component
          :is="item.icon"
          class="w-5 h-5 group-hover:scale-110 transition-transform duration-300"
        />
        <span>{{ item.label }}</span>
      </RouterLink>
    </nav>

    <div class="p-4 border-t border-slate-100">
      <button
        @click="signOut"
        class="flex items-center gap-3 px-4 py-3 w-full rounded-2xl font-bold text-red-500 hover:bg-red-50 hover:text-red-600 transition-all cursor-pointer"
      >
        <LogOut class="w-5 h-5" />
        <span>Sign Out</span>
      </button>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { LayoutDashboard, PlusCircle, BookOpen, List, LogOut, Sparkles } from 'lucide-vue-next'

import { useAuthStore } from '@/stores/auth.store'
import { PagePath } from '@/shared/core/enums/page.enum'

const router = useRouter()
const authStore = useAuthStore()

const navItems = [
  { icon: LayoutDashboard, label: 'Dashboard', path: '/' },
  { icon: BookOpen, label: 'Daily Review', path: PagePath.REVIEW },
  { icon: PlusCircle, label: 'Add Word', path: PagePath.ADD },
  { icon: List, label: 'Word List', path: PagePath.LIST },
]

const signOut = () => {
  authStore.clearAuth()
  router.push(PagePath.LOGIN)
}
</script>
