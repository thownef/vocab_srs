import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'

export const loginFormSchema = z.object({
  email: z.string().min(1, 'Email is required').email('Invalid email format'),
  password: z.string().min(6, 'Password must be at least 6 characters'),
})

export const loginSchema = toTypedSchema(loginFormSchema)

export type LoginFormValues = z.infer<typeof loginFormSchema>
