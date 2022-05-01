<template>
  <ValidationProvider
    v-slot="{ errors, required, ariaInput, ariaMsg }"
    class="relative appearance-none w-full TextInput"
    tag="div"
    :vid="vid"
    :rules="rules"
    :name="name || label"
  >
    <label v-if="showLabel" class="pt-3.5 col-span-12 lg:col-span-4 text-slate-700" :for="name">
      <span>{{ label || name }}</span>
      <span v-if="required" class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
    </label>
    <div :class="wrapperClass">
      <div :class="hasAfterInputSlot ? 'flex items-center' : null">
        <input
          :id="name"
          ref="input"
          v-model="innerValue"
          class="w-full h-12 px-5 text-base placeholder-gray-400 border rounded focus:shadow-outline"
          :class="{
            'border-gray-200': !errors[0],
            'border-red-600': errors[0],
            'has-value': hasValue,
            'bg-gray-200': isDisabled,
          }"
          :type="type"
          :placeholder="placeholder"
          value=""
          v-bind="ariaInput"
          :disabled="isDisabled"
        />
        <slot name="afterInput"></slot>
      </div>
      <p v-if="help" class="text-sm text-slate-700 opacity-70 whitespace-nowrap" v-html="help"></p>
      <p v-if="errors[0]" v-bind="ariaMsg" class="text-sm text-red-600 whitespace-nowrap">{{ errors[0] }}</p>
    </div>
  </ValidationProvider>
</template>

<script>
export default {
  name: 'VInput',
  props: {
    vid: {
      type: String,
      default: undefined,
    },
    name: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    showLabel: {
      type: Boolean,
      default: true,
    },
    rules: {
      type: [Object, String],
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    help: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'text',
      validator(value) {
        return ['url', 'text', 'password', 'tel', 'search', 'number', 'email'].includes(value)
      },
    },
    value: {
      type: null,
      default: '',
    },
    isDisabled: {
      type: Boolean,
      default: false,
    },
    wrapperClass: {
      type: [String, Object],
      default: 'col-span-12 lg:col-span-6',
    },
  },
  data: () => ({
    innerValue: '',
  }),
  computed: {
    hasValue() {
      return !!this.innerValue
    },
    hasAfterInputSlot() {
      return !!this.$slots.afterInput
    },
  },
  watch: {
    innerValue(value) {
      this.$emit('input', value)
    },
    value(val) {
      if (val !== this.innerValue) {
        this.innerValue = val
      }
    },
  },
  created() {
    if (this.value) {
      this.innerValue = this.value
    }
  },
}
</script>
