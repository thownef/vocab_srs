<script setup lang="ts">
import { useHead } from '@unhead/vue'
import { LayoutDashboard, BookOpen, Star, Clock } from 'lucide-vue-next'

useHead({
  title: 'Dashboard',
  meta: [{ name: 'description', content: 'Welcome to your LexiLoom Sanctuary' }],
})

const stats = [
  { label: 'Words Learned', value: '128', icon: BookOpen, color: 'text-blue-500' },
  { label: 'Mastered', value: '45', icon: Star, color: 'text-yellow-500' },
  { label: 'Daily Streak', value: '7 days', icon: Clock, color: 'text-orange-500' },
]
</script>

<template>
  <div class="min-h-screen bg-[#F8FAFC] p-8">
    <div class="max-w-7xl mx-auto">
      <header class="mb-10">
        <div class="flex items-center gap-3 mb-2">
          <LayoutDashboard class="w-8 h-8 text-blue-600" />
          <h1 class="text-3xl font-extrabold text-slate-900">Sanctuary Dashboard</h1>
        </div>
        <p class="text-slate-500 text-lg">Welcome back, Scholar. Your lexicon is waiting.</p>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div 
          v-for="stat in stats" 
          :key="stat.label"
          class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow"
        >
          <div :class="['p-4 rounded-2xl bg-slate-50', stat.color]">
            <component :is="stat.icon" class="w-6 h-6" />
          </div>
          <div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">{{ stat.label }}</p>
            <p class="text-2xl font-black text-slate-900">{{ stat.value }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 text-center">
        <h2 class="text-2xl font-bold text-slate-900 mb-4">Start your daily flow</h2>
        <p class="text-slate-500 mb-8 max-w-md mx-auto">
          Review your personalized word deck using spaced repetition to ensure long-term retention.
        </p>
        <button class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
          Begin Session
        </button>
      </div>
    </div>
  </div>
</template>
