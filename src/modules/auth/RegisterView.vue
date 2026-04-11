<template>
  <div
    v-if="layout === LayoutEnum.AUTH"
    class="min-h-screen bg-[#F1F5F9] flex items-center justify-center p-4 lg:p-8"
  >
    <div
      class="bg-white w-full max-w-6xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row"
    >
      <div class="lg:w-1/2 bg-white p-4 flex flex-col justify-center">
        <div
          class="max-w-md mx-auto w-full space-y-8"
          v-motion
          :initial="{ opacity: 0, x: -20 }"
          :enter="{ opacity: 1, x: 0 }"
        >
          <div>
            <h1 class="text-4xl font-extrabold text-[#0F172A] tracking-tight">
              Start Your Journey.
            </h1>
          </div>

          <Form
            :validation-schema="signupSchema"
            v-slot="{ isSubmitting }"
            @submit="onSubmitForm"
            class="space-y-4"
          >
            <FormInput name="name" label="Full Name" placeholder="Enter your full name">
              <template #prefix>
                <UserIcon class="w-5 h-5 text-slate-400 mr-2" />
              </template>
            </FormInput>

            <FormInput name="email" label="Email" placeholder="scholar@lexiloom.com">
              <template #prefix>
                <Mail class="w-5 h-5 text-slate-400 mr-2" />
              </template>
            </FormInput>

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

            <div class="flex flex-col gap-1">
              <label class="flex items-center gap-3 cursor-pointer group">
                <div class="relative flex items-center mt-1">
                  <Field
                    name="agreement"
                    type="checkbox"
                    :value="true"
                    class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-md checked:bg-[#22A7F0] checked:border-[#22A7F0] transition-all cursor-pointer"
                  />
                  <CheckIcon
                    class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transition-opacity pointer-events-none"
                  />
                </div>
                <span class="text-sm text-[#64748B] font-medium leading-tight">
                  I agree to the
                  <a href="#" class="text-[#22A7F0] hover:underline">Terms of Service</a> and
                  <a href="#" class="text-[#22A7F0] hover:underline">Privacy Policy</a>
                </span>
              </label>
              <ErrorMessage name="agreement" class="text-xs text-red-500 font-medium px-8" />
            </div>

            <button
              type="submit"
              :disabled="isSubmitting"
              class="w-full py-4 bg-[#22A7F0] text-white rounded-2xl font-bold text-lg shadow-xl shadow-[#22A7F0]/30 hover:bg-[#1E97DA] transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2 mt-4"
            >
              <span
                v-if="isSubmitting"
                class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"
              ></span>
              <span>{{ isSubmitting ? 'Creating account...' : 'Sign Up' }}</span>
            </button>
          </Form>

          <p class="text-center text-[#64748B] font-medium">
            Already a scholar?
            <RouterLink to="/login" class="text-[#22A7F0] font-bold hover:underline">
              Sign In
            </RouterLink>
          </p>
        </div>
      </div>

      <div
        class="hidden lg:flex lg:w-1/2 relative bg-[#E9EFFF] p-10 lg:p-14 items-center justify-center"
      >
        <div class="grid grid-cols-2 gap-6 w-full max-w-xl">
          <div
            class="col-span-1 bg-white p-8 rounded-4xl shadow-sm flex flex-col gap-4 self-end"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 200 } }"
          >
            <BookOpen class="w-10 h-10 text-[#22A7F0]" />
            <div>
              <h3 class="font-bold text-[#0F172A] text-lg">Curated Library</h3>
              <p class="text-slate-500 text-sm font-medium leading-relaxed mt-1">
                Access thousands of academic resources curated for the modern fluid scholar.
              </p>
            </div>
          </div>

          <div
            class="col-span-1"
            v-motion
            :initial="{ opacity: 0, scale: 0.9 }"
            :enter="{ opacity: 1, scale: 1, transition: { delay: 400 } }"
          >
            <img
              src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800"
              alt="Scholar"
              class="w-full aspect-square object-cover rounded-[2.5rem] shadow-lg"
            />
          </div>

          <div
            class="col-span-1 relative"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 600 } }"
          >
            <img
              src="https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=800"
              alt="Art"
              class="w-full aspect-4/5 object-cover rounded-[2.5rem] shadow-lg"
            />
            <div
              class="absolute -bottom-6 -right-12 bg-white/90 backdrop-blur-md p-6 rounded-3xl shadow-xl max-w-[300px] border border-white/50"
            >
              <p class="text-[#0F172A] font-medium leading-relaxed italic text-sm">
                "The LexisLoom method transformed my vocabulary from functional to expressive in
                just weeks."
              </p>
              <div class="flex items-center gap-3 mt-4">
                <div class="w-4 h-4 rounded-full bg-[#22A7F0]"></div>
                <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-widest"
                  >Journal of Modern Philology</span
                >
              </div>
            </div>
          </div>

          <div
            class="col-span-1 bg-[#006080] p-8 rounded-4xl shadow-sm flex flex-col gap-4 text-white self-start mt-12"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 800 } }"
          >
            <Lightbulb class="w-10 h-10 text-[#5AC8FA]" />
            <div>
              <h3 class="font-bold text-lg">Infinite Growth</h3>
              <p class="text-white/80 text-sm font-medium leading-relaxed mt-1">
                Master new languages and complex concepts through our fluid methodology.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useHead } from '@unhead/vue'
import { useRouter } from 'vue-router'
import { Form, Field, ErrorMessage } from 'vee-validate'
import { signupSchema } from '@/modules/auth/core/config/form/signup-form'
import {
  Mail,
  Lock,
  User as UserIcon,
  Check as CheckIcon,
  BookOpen,
  Lightbulb,
} from 'lucide-vue-next'
import FormInput from '@/components/Input/FormInput.vue'
import { LayoutEnum } from '@/shared/core/enums/layout.enum'
import { useGeneralStore } from '@/stores/general.store'
import AuthService from '@/shared/services/auth.service'
import { useHandleForm } from '@/shared/composables/useHandleForm'

const { layout } = useGeneralStore()

useHead({
  title: 'Sign Up',
  meta: [{ name: 'description', content: 'Join LexiLoom and start your journey' }],
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
