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
      <textarea
        :id="name"
        ref="input"
        v-model="innerValue"
        class="form-textarea block w-full resize-none py-3 px-5 rounded bg-white border"
        :class="{ 'border-gray-200': !errors[0], 'border-red-600': errors[0], 'has-value': hasValue }"
        :placeholder="placeholder"
        value=""
        v-bind="ariaInput"
        :disabled="isDisabled"
        :rows="rows"
      />
      <p v-if="help" class="text-sm text-slate-700 mt-1" v-html="help"></p>
      <p v-if="errors[0]" class="text-sm text-red-600">{{ errors[0] }}</p>
    </div>
  </ValidationProvider>
</template>

<script>
export default {
  name: 'VTextarea',
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
    rows: {
      type: [Number, String],
      default: 5,
    },
  },
  data: () => ({
    innerValue: '',
  }),
  computed: {
    hasValue() {
      return !!this.innerValue
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
