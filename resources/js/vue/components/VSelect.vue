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
      <select
        :id="name"
        v-model="innerValue"
        :name="name"
        class="select select-bordered w-full rounded bg-white font-normal text-base"
        :class="{
          'border-gray-200': !errors[0],
          'border-red-600': errors[0],
          'has-value': hasValue,
          'text-gray-400': !hasValue,
        }"
        :multiple="isMultiple"
        :disabled="isDisabled"
        :placeholder="placeholder"
        v-bind="ariaInput"
      >
        <slot name="options">
          <option v-if="defaultText" :class="defaultOptionClass" value="">
            {{ defaultText }}
          </option>
          <option
            v-for="(option, index) in options"
            :key="index"
            :class="optionClass"
            :value="valueSelectOption(option, index)"
          >
            {{ displayOption(option) }}
          </option>
        </slot>
      </select>
      <p v-if="help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="errors[0]" class="text-sm text-red-600">{{ errors[0] }}</p>
    </div>
  </ValidationProvider>
</template>

<script>
export default {
  name: 'VSelect',
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
    options: {
      type: [Array, Object],
      default: () => {
        return []
      },
    },
    optionClass: {
      type: String,
      default: '',
    },
    defaultText: {
      type: String,
      default: '',
    },
    defaultOptionClass: {
      type: String,
      default: '',
    },
    isDisabled: {
      type: Boolean,
      default: false,
    },
    isMultiple: {
      type: Boolean,
      default: false,
    },
    wrapperClass: {
      type: [String, Object],
      default: 'col-span-12 lg:col-span-4',
    },
    keyDisplay: {
      type: String,
      default: 'label',
    },
    keyValue: {
      type: String,
      default: 'value',
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
  methods: {
    displayOption(value) {
      return typeof value == 'object' ? value[this.keyDisplay] : value
    },
    valueOption(value) {
      return typeof value == 'object' ? value[this.keyValue] : value
    },
    valueSelectOption(value, index) {
      return typeof value == 'object' ? value[this.keyValue] : index
    },
  },
}
</script>
