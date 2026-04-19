<template>
  <div class="min-h-screen bg-[#F8FAFC]">
    <div
      class="max-w-7xl mx-auto space-y-8"
      v-motion
      :initial="{ opacity: 0, y: 20 }"
      :enter="{ opacity: 1, y: 0 }"
    >
      <div class="flex items-end justify-between">
        <div>
          <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Welcome back, {{ authStore.profile?.name || 'Scholar' }}
          </h1>
          <p class="text-slate-500 mt-1">
            You're {{ MOCK_STATS.dailyGoal - MOCK_STATS.dailyProgress }} words away from your daily
            goal.
          </p>
        </div>
        <router-link
          to="/review"
          class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-2xl font-semibold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95"
        >
          <Zap class="w-4 h-4" />
          <span>Start Review</span>
        </router-link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
          v-for="(stat, i) in stats"
          :key="i"
          class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow"
        >
          <div :class="['w-14 h-14 rounded-2xl flex items-center justify-center', stat.bg]">
            <component :is="stat.icon" :class="['w-7 h-7', stat.color]" />
          </div>
          <div>
            <p class="text-sm font-medium text-slate-400">{{ stat.label }}</p>
            <p class="text-2xl font-bold text-slate-900">{{ stat.value }}</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-slate-900">Learning Progress</h2>
              <div class="flex items-center gap-2 text-sm font-medium text-slate-400">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span>Words Mastered</span>
              </div>
            </div>

            <div class="h-64 flex items-end justify-between gap-2 px-4">
              <div
                v-for="(height, i) in [45, 60, 40, 80, 55, 90, 70]"
                :key="i"
                class="flex-1 flex flex-col items-center gap-3 group"
              >
                <div
                  class="w-full bg-blue-50 rounded-t-xl transition-all duration-500 group-hover:bg-blue-100 relative"
                  :style="{ height: `${height}%` }"
                >
                  <div
                    class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity"
                  >
                    {{ height }}
                  </div>
                </div>
                <span class="text-xs font-medium text-slate-400">
                  {{ ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'][i] }}
                </span>
              </div>
            </div>
          </div>

          <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-slate-900">Recent Additions</h2>
              <router-link
                to="/list"
                class="text-blue-600 text-sm font-semibold hover:underline flex items-center gap-1"
              >
                View All <ChevronRight class="w-4 h-4" />
              </router-link>
            </div>
            <div class="space-y-4">
              <div
                v-for="word in MOCK_WORDS.slice(0, 3)"
                :key="word.id"
                class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors cursor-pointer group"
              >
                <div class="flex items-center gap-4">
                  <div
                    class="w-12 h-12 bg-white rounded-xl flex items-center justify-center border border-slate-200 group-hover:border-blue-200"
                  >
                    <span class="text-lg font-bold text-blue-600">{{ word.word[0] }}</span>
                  </div>
                  <div>
                    <h3 class="font-bold text-slate-900">{{ word.word }}</h3>
                    <p class="text-sm text-slate-500 truncate max-w-[200px]">
                      {{ word.meaning }}
                    </p>
                  </div>
                </div>
                <div class="flex items-center gap-4">
                  <span
                    :class="[
                      'px-3 py-1 rounded-full text-xs font-bold',
                      word.status === 'Mastered'
                        ? 'bg-emerald-100 text-emerald-600'
                        : word.status === 'Familiar'
                          ? 'bg-blue-100 text-blue-600'
                          : 'bg-orange-100 text-orange-600',
                    ]"
                  >
                    {{ word.status }}
                  </span>
                  <ArrowRight
                    class="w-4 h-4 text-slate-300 group-hover:text-blue-500 transition-colors"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div
            class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-3xl text-white shadow-xl shadow-blue-200 relative overflow-hidden"
          >
            <Sparkles class="absolute -right-4 -top-4 w-32 h-32 text-white/10 rotate-12" />
            <h3 class="text-xl font-bold mb-2 relative z-10">Daily Mastery</h3>
            <p class="text-blue-100 text-sm mb-6 relative z-10">
              You've mastered 12 new words this week. Keep the momentum!
            </p>
            <div class="space-y-4 relative z-10">
              <div class="flex justify-between text-sm font-medium">
                <span>Progress</span>
                <span>60%</span>
              </div>
              <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                <div
                  class="h-full bg-white w-[60%] rounded-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"
                ></div>
              </div>
            </div>
          </div>

          <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Review Queue</h2>
            <div class="space-y-6">
              <div
                v-for="(item, i) in queueItems"
                :key="i"
                class="flex items-center justify-between"
              >
                <div class="flex items-center gap-3">
                  <div :class="['w-2 h-2 rounded-full', item.color || 'bg-slate-300']"></div>
                  <span class="text-sm font-medium text-slate-600">{{ item.label }}</span>
                </div>
                <span :class="['text-sm font-bold', item.countColor || 'text-slate-900']">{{
                  item.count
                }}</span>
              </div>
            </div>
            <button
              class="w-full mt-8 py-3 border-2 border-slate-100 rounded-2xl text-slate-600 font-bold hover:bg-slate-50 transition-colors"
            >
              Manage Queue
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useHead } from '@unhead/vue'
import { useAuthStore } from '@/stores/auth.store'
import { TrendingUp, Zap, Target, ArrowRight, ChevronRight, Sparkles } from 'lucide-vue-next'
import { MOCK_STATS, MOCK_WORDS } from './mockData'

useHead({
  title: 'Home | Sanctuary',
  meta: [
    { name: 'description', content: "Track your progress and mastery in the Scholar's Sanctuary" },
  ],
})

const authStore = useAuthStore()

const stats = [
  {
    label: 'Day Streak',
    value: MOCK_STATS.streak,
    icon: Zap,
    color: 'text-orange-500',
    bg: 'bg-orange-50',
  },
  {
    label: 'Total Words',
    value: MOCK_STATS.totalWords,
    icon: TrendingUp,
    color: 'text-blue-500',
    bg: 'bg-blue-50',
  },
  {
    label: 'Accuracy',
    value: `${MOCK_STATS.accuracy}%`,
    icon: Target,
    color: 'text-emerald-500',
    bg: 'bg-emerald-50',
  },
]

const queueItems = [
  { label: 'Critical Review', count: 8, color: 'bg-red-500' },
  { label: 'Upcoming', count: 14, countColor: 'text-slate-500' },
  { label: 'Mastered', count: 124, countColor: 'text-emerald-500' },
]
</script>
