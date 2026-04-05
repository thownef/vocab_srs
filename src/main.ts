import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createHead } from '@unhead/vue/client'
import { MotionPlugin } from '@vueuse/motion'

import App from './components/App.vue'
import router from '@/router'
import './assets/main.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(createHead())
app.use(MotionPlugin)

app.mount('#app')
