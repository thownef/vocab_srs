import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'

export const signupFormSchema = z
  .object({
    name: z.string().min(1, 'Full name is required'),
    email: z.string().min(1, 'Email is required').email('Invalid email format'),
    password: z.string().min(6, 'Password must be at least 6 characters'),
    passwordConfirmation: z.string().min(1, 'Please confirm your password'),
    agreement: z.boolean().refine((val) => val === true, {
      message: 'You must agree to the Terms of Service and Privacy Policy',
    }),
  })
  .refine((data) => data.password === data.passwordConfirmation, {
    message: "Passwords don't match",
    path: ['passwordConfirmation'],
  })

export const signupSchema = toTypedSchema(signupFormSchema)

export type SignupFormValues = z.infer<typeof signupFormSchema>
