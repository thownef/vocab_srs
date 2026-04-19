<template>
  <div class="min-h-screen bg-[#F1F5F9] flex items-center justify-center p-4 lg:p-8">
    <div
      class="bg-white w-full max-w-6xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[500px]"
    >
      <div class="hidden lg:block lg:w-1/2 relative lg:min-h-full">
        <img
          src="@/assets/images/background-signin.png"
          alt="Lexis Sanctuary"
          class="absolute inset-0 w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-black/10"></div>

        <div
          class="absolute bottom-10 left-10 right-10 bg-white/60 backdrop-blur-xl p-8 rounded-3xl border border-white/30 shadow-2xl"
          v-motion
          :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { delay: 300 } }"
        >
          <h2 class="text-3xl font-extrabold text-[#0F172A] mb-3">Lexis Sanctuary</h2>
          <p class="text-[#334155] text-lg leading-relaxed font-medium">
            A curated space for the curious mind. Expand your lexicon in a digital environment
            designed for focus and flow.
          </p>
        </div>
      </div>

      <div class="lg:w-1/2 bg-white p-10 lg:p-10 flex flex-col justify-center">
        <div
          class="max-w-md mx-auto w-full space-y-8"
          v-motion
          :initial="{ opacity: 0, x: 20 }"
          :enter="{ opacity: 1, x: 0 }"
        >
          <header>
            <h1 class="text-4xl font-extrabold text-[#0F172A] tracking-tight">Create Account</h1>
            <p class="text-[#64748B] mt-2 text-lg font-medium">
              Join the sanctuary of fluid learning today.
            </p>
          </header>

          <Form
            :validation-schema="signupSchema"
            v-slot="{ isSubmitting }"
            @submit="onSubmitForm"
            class="space-y-4"
          >
            <FormInput name="name" label="Full Name" placeholder="Alex Rivera">
              <template #prefix>
                <User class="w-5 h-5 text-slate-400 mr-2" />
              </template>
            </FormInput>

            <FormInput name="email" label="Email Address" placeholder="alex@example.com">
              <template #prefix>
                <Mail class="w-5 h-5 text-slate-400 mr-2" />
              </template>
            </FormInput>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <FormInput name="password" label="Password" type="password" placeholder="••••••••">
                <template #prefix>
                  <Lock class="w-5 h-5 text-slate-400 mr-2" />
                </template>
              </FormInput>
              <FormInput
                name="passwordConfirmation"
                label="Confirm Password"
                type="password"
                placeholder="••••••••"
              >
                <template #prefix>
                  <Lock class="w-5 h-5 text-slate-400 mr-2" />
                </template>
              </FormInput>
            </div>

            <div class="pt-4">
              <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full py-4 bg-[#22A7F0] text-white rounded-2xl font-bold text-lg shadow-xl shadow-[#22A7F0]/30 hover:bg-[#1E97DA] transition-all active:scale-[0.98] disabled:opacity-70 flex items-center justify-center gap-2"
              >
                <span
                  v-if="isSubmitting"
                  class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"
                ></span>
                <span>{{ isSubmitting ? 'Creating account...' : 'Create Account' }}</span>
              </button>
            </div>
          </Form>

          <p class="text-center text-[#64748B] font-medium">
            Already a scholar?
            <RouterLink to="/login" class="text-[#22A7F0] font-bold hover:underline">
              Sign In
            </RouterLink>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useHead } from '@unhead/vue'
import { useRouter } from 'vue-router'
import { Form } from 'vee-validate'
import { signupSchema } from '@/modules/auth/core/config/form/signup-form'
import { Mail, Lock, User } from 'lucide-vue-next'
import FormInput from '@/components/Input/FormInput.vue'
import AuthService from '@/shared/services/auth.service'
import { useHandleForm } from '@/shared/composables/useHandleForm'

useHead({
  title: 'Sign Up | LexiLoom',
  meta: [{ name: 'description', content: 'Join the LexiLoom sanctuary' }],
})

const router = useRouter()

const handleSubmit = async (values: any) => {
  return AuthService.register(values)
}

const handleAfterSubmit = () => {
  router.push({ name: 'login' })
}

const { onSubmitForm } = useHandleForm({
  onSubmit: handleSubmit,
  fnAfterSubmit: handleAfterSubmit,
})
</script>

<style scoped></style>
