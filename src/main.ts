import { createApp } from 'vue'
import { pinia } from '@/stores/pinia'
import { createHead } from '@unhead/vue/client'
import { MotionPlugin } from '@vueuse/motion'

import App from '@/App.vue'
import router from '@/router'
import '@/styles/main.css'

const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(createHead())
app.use(MotionPlugin)

app.mount('#app')
