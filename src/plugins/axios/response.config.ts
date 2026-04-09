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

// Config Response Error Interceptor
export const axiosInterceptorResponseError = (error: AxiosError) => {
  const resError = JSON.parse(JSON.stringify(error))

  // Timeout web
  if (resError?.message?.includes('timeout of 30000ms exceeded')) {
  }
  const { status } = error.response || { status: 500 }

  // Redirect to Error Page
  if (status === HttpErrorCodeEnum.UNAUTHORIZED) {
  }
  if (status === HttpErrorCodeEnum.NOT_FOUND) {
  }

  if (status === HttpErrorCodeEnum.FORBIDDEN) {
    // Redirect Error Page
  }

  if (status === HttpErrorCodeEnum.UNPROCESSABLE_CONTENT) {
    const { data: errors } = error.response || {}

    return Promise.reject(errors)
  }

  if (status === HttpErrorCodeEnum.SERVER_ERROR) {
  }

  if (status === HttpErrorCodeEnum.BAD_REQUEST) {
  }

  return Promise.reject(error)
}
