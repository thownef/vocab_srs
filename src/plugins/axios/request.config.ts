import { decamelizeKeys } from 'humps'
import Cookie from 'js-cookie'
import type { AxiosError, InternalAxiosRequestConfig } from 'axios'

// Config Request Interceptor
export const axiosInterceptorRequestConfig = (config: InternalAxiosRequestConfig) => {
  const accessToken = Cookie.get('accessToken')
  if (accessToken) {
    config.headers['Authorization'] = `Bearer ${accessToken}`
  }

  if (config.data instanceof FormData) {
    config.headers['Content-Type'] = 'multipart/form-data'
  } else {
    config.headers['Content-Type'] = 'application/json'
  }

  if (config.data) {
    config.data = decamelizeKeys(config.data)
  }

  if (config.params) {
    config.params = decamelizeKeys(config.params)
  }

  return config
}

// Config Request Error Interceptor
export const axiosInterceptorRequestError = (error: AxiosError) => {
  return Promise.reject(error)
}
