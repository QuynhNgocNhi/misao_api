<template>
  <ValidationProvider
    v-slot="{ errors, ariaInput, ariaMsg }"
    class=""
    tag="div"
    :vid="vid"
    :rules="rules"
    :name="name || label"
  >
    <div class="flex justify-center mt-8" :class="{ 'justify-center': isCenter }">
      <label class="inline-flex items-center text-slate-700">
        <input
          :id="name"
          ref="input"
          v-model="innerValue"
          :class="getClassName(errors)"
          type="checkbox"
          :placeholder="placeholder"
          value=""
          v-bind="ariaInput"
          :disabled="isDisabled"
        />
        <span class="ml-2">{{ label }}</span>
      </label>
    </div>
    <p v-if="help" class="text-sm text-slate-700" :class="{ 'text-center': isCenter }" v-html="help"></p>
    <p v-if="errors[0]" class="text-sm text-red-600" :class="{ 'text-center': isCenter }">
      {{ errors[0] }}
    </p>
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
    inputClass: {
      type: [String, Object],
      default: '',
    },
    isCenter: {
      type: Boolean,
      default: false,
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
    getClassName(errors) {
      let classList = { 'border-gray-700': !errors[0], 'border-red-600': errors[0], 'has-value': this.hasValue }

      if (typeof this.inputClass === 'string') {
        this.inputClass.split(' ').map(name => {
          classList[name] = true
        })
      } else {
        classList = { ...this.inputClass, classList }
      }

      return classList
    },
  },
}
</script>
