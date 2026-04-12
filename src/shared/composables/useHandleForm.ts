import { HttpErrorCodeEnum } from '@/shared/core/enums/http-error-code.enum'
import type { AxiosResponse } from 'axios'
import _ from 'lodash'
import { useNotificationStore } from '@/stores/notification.store'
import { useRoute } from 'vue-router'

export interface UseHandleFormOptions<T> {
  onSubmit: (values: T) => Promise<AxiosResponse<any, any>>
  fnAfterSubmit?: (data: any) => void
}

export function useHandleForm<T>({ onSubmit, fnAfterSubmit }: UseHandleFormOptions<T>) {
  const notification = useNotificationStore()
  const route = useRoute()

  const handleSubmitForm = async (values: T, actions: any) => {
    try {
      const res = await onSubmit(values)

      const isLogin = route.path.includes('login')
      const isRegister = route.path.includes('register')

      const message = isLogin
        ? 'Welcome back! You have successfully logged in.'
        : isRegister
          ? 'Registration successful! Please sign in to continue.'
          : 'Successfully!'

      notification.success(message)

      if (fnAfterSubmit) {
        fnAfterSubmit(res.data)
      }
    } catch (error: any) {
      if (error.code === HttpErrorCodeEnum.UNPROCESSABLE_CONTENT) {
        const { errors } = error
        if (error.response?.data?.errors && Array.isArray(error.response.data.errors)) {
          const formattedErrors = error.response.data.errors.map((curr: any) => {
            const field = _.camelCase(curr.field)
            return { [field]: curr.message[0] }
          })
          actions.setErrors(Object.assign({}, ...formattedErrors))
        } else if (error.errors && Array.isArray(error.errors)) {
          const formattedErrors = error.errors.map((curr: any) => {
            const field = _.camelCase(curr.field)
            return { [field]: curr.message[0] }
          })
          actions.setErrors(Object.assign({}, ...formattedErrors))
        }
      }
    }
  }

  return {
    onSubmitForm: handleSubmitForm,
  }
}
