import { defineStore } from 'pinia'
import { ref } from 'vue'

export type NotificationType = 'success' | 'error' | 'info' | 'warning'

export interface Notification {
  id: number
  type: NotificationType
  message: string
  duration?: number
}

export const useNotificationStore = defineStore('notification', () => {
  const notifications = ref<Notification[]>([])

  const addNotification = (message: string, type: NotificationType = 'info', duration = 3000) => {
    const id = Date.now()
    notifications.value.push({ id, message, type, duration })

    if (duration > 0) {
      setTimeout(() => {
        removeNotification(id)
      }, duration)
    }
  }

  const removeNotification = (id: number) => {
    notifications.value = notifications.value.filter((n) => n.id !== id)
  }

  return {
    notifications,
    success: (msg: string) => addNotification(msg, 'success'),
    error: (msg: string) => addNotification(msg, 'error'),
    info: (msg: string) => addNotification(msg, 'info'),
    warning: (msg: string) => addNotification(msg, 'warning'),
    removeNotification,
  }
})
