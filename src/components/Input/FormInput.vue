<template>
  <div class="mb-4">
    <label v-if="label" :for="name" class="block text-sm font-bold text-slate-700 mb-2 ml-1">
      {{ label }}
      <span v-if="required" class="text-red-500 ml-1" aria-hidden="true">*</span>
    </label>

    <div class="relative flex items-center">
      <div
        v-if="$slots.prefix"
        class="absolute left-4 flex items-center justify-center pointer-events-none text-slate-400"
      >
        <slot name="prefix" />
      </div>

      <input
        :id="name"
        v-model="value"
        :type="inputType"
        :placeholder="placeholder"
        :disabled="disabled"
        v-bind="attrs"
        autocomplete="off"
        class="w-full rounded-2xl bg-[#F1F5F9] border-none outline-none transition-shadow duration-200"
        :class="[
          size === 'small' ? 'py-2' : size === 'middle' ? 'py-2.5' : 'py-3.5',
          $slots.prefix ? 'pl-11' : 'pl-4',
          $slots.suffix || isPassword ? 'pr-11' : 'pr-4',
          validateStatus === 'error'
            ? 'ring-2 ring-red-500/20 focus:ring-2 focus:ring-red-500/30'
            : 'focus:ring-2 focus:ring-[#22A7F0]/25',
          disabled ? 'opacity-60 cursor-not-allowed' : '',
        ]"
        @blur="handleBlur"
      />

      <div
        v-if="$slots.suffix && !isPassword"
        class="absolute right-4 flex items-center justify-center pointer-events-none text-slate-400"
      >
        <slot name="suffix" />
      </div>

      <button
        v-if="isPassword"
        type="button"
        class="absolute right-4 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none focus:text-slate-600"
        @click="togglePassword"
        :aria-label="showPassword ? 'Hide password' : 'Show password'"
      >
        <EyeOff v-if="showPassword" class="w-5 h-5" />
        <Eye v-else class="w-5 h-5" />
      </button>
    </div>

    <div
      v-if="helpText"
      class="mt-1 ml-2 text-xs font-bold transition-colors"
      :class="validateStatus === 'error' ? 'text-red-500' : 'text-slate-500'"
    >
      {{ helpText }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { useField } from 'vee-validate'
import { computed, useAttrs, ref } from 'vue'
import { Eye, EyeOff } from 'lucide-vue-next'

const props = withDefaults(
  defineProps<{
    name: string
    label?: string
    placeholder?: string
    type?: 'text' | 'password' | 'email' | 'number'
    size?: 'large' | 'middle' | 'small'
    disabled?: boolean
    required?: boolean
  }>(),
  {
    type: 'text',
    size: 'large',
    disabled: false,
    required: false,
  },
)

defineOptions({ inheritAttrs: false })
const attrs = useAttrs()

const { value, errorMessage, handleBlur, meta } = useField(props.name)

const validateStatus = computed(() => {
  if (!meta.touched) return ''
  return errorMessage.value ? 'error' : 'success'
})

const helpText = computed(() => {
  return meta.touched && errorMessage.value ? errorMessage.value : ''
})

const isPassword = computed(() => props.type === 'password')

const showPassword = ref(false)
const inputType = computed(() => {
  if (isPassword.value) {
    return showPassword.value ? 'text' : 'password'
  }
  return props.type
})

const togglePassword = () => {
  showPassword.value = !showPassword.value
}
</script>
