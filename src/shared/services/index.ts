import axios from 'axios'
import {
  axiosInterceptorRequestConfig,
  axiosInterceptorRequestError,
} from '@/plugins/axios/request.config'
import {
  axiosInterceptorResponseConfig,
  axiosInterceptorResponseError,
} from '@/plugins/axios/response.config'

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-Frame-Options': 'SAMEORIGIN',
  },
  timeout: 30000, // request timeout
})

// Interceptor functions
axiosInstance.interceptors.request.use(axiosInterceptorRequestConfig, axiosInterceptorRequestError)

axiosInstance.interceptors.response.use(
  axiosInterceptorResponseConfig,
  axiosInterceptorResponseError,
)

export const ApiService = {
  get(url: string, params = {}, headers = {}, options = {}) {
    return axiosInstance.get(`${url}`, { params, headers, ...options })
  },

  post(url: string, body: any, config = {}) {
    return axiosInstance.post(`${url}`, body, config)
  },

  put(url: string, body: any, params = {}) {
    return axiosInstance.put(`${url}`, body, { params })
  },

  delete(url: string, params = {}) {
    return axiosInstance.delete(`${url}`, { params })
  },
}
