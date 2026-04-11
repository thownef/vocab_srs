import { HttpErrorCodeEnum } from '@/shared/core/enums/http-error-code.enum'
import type { AxiosResponse } from 'axios'
import _ from 'lodash'

export interface UseHandleFormOptions<T> {
  onSubmit: (values: T) => Promise<AxiosResponse<any, any>>
  fnAfterSubmit?: (data: any) => void
}

export function useHandleForm<T>({ onSubmit, fnAfterSubmit }: UseHandleFormOptions<T>) {
  const handleSubmitForm = async (values: T, actions: any) => {
    try {
      const res = await onSubmit(values)
      if (fnAfterSubmit) {
        fnAfterSubmit(res.data)
      }
    } catch (error: any) {
      if (error.code === HttpErrorCodeEnum.UNPROCESSABLE_CONTENT) {
        const { errors } = error
        if (errors && Array.isArray(errors)) {
          const formattedErrors = errors.map((curr: any) => {
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
