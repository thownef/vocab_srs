import { camelizeKeys } from 'humps'
import type { AxiosError, AxiosResponse } from 'axios'
import { HttpErrorCodeEnum } from '@/shared/core/enums/http-error-code.enum'

// Config Response Interceptor
export const axiosInterceptorResponseConfig = (response: AxiosResponse) => {
  if (response.data?.data) {
    const { data } = response.data
    response.data.data = camelizeKeys(data)
  }

  return response
}

import { useNotificationStore } from '@/stores/notification.store'

// Config Response Error Interceptor
export const axiosInterceptorResponseError = (error: AxiosError) => {
  const notification = useNotificationStore()
  const { status } = error.response || { status: 500 }

  switch (status) {
    case HttpErrorCodeEnum.UNAUTHORIZED:
      if (error.config?.url?.includes('login')) {
        notification.error('Invalid email or password.')
      } else {
        notification.error('Session expired. Please login again.')
      }
      break
    case HttpErrorCodeEnum.NOT_FOUND:
      notification.error('The requested resource was not found.')
      break
    case HttpErrorCodeEnum.UNPROCESSABLE_CONTENT:
      const { data: errors } = error.response || {}
      return Promise.reject(errors)
    case HttpErrorCodeEnum.FORBIDDEN:
      notification.error('You do not have permission to perform this action.')
      break
    case HttpErrorCodeEnum.SERVER_ERROR:
      notification.error('Internal server error. Please try again later.')
      break
    case HttpErrorCodeEnum.GATEWAY_TIMEOUT:
      notification.error('Request timed out. Please check your connection.')
      break
    default:
      if (status >= 400 && status < 500) {
        notification.error('Something went wrong. Please try again later.')
      } else if (status >= 500) {
        notification.error('Server is currently unavailable.')
      }
  }

  return Promise.reject(error)
}
