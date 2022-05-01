<template>
  <div class="grid grid-cols-12 gap-4 mb-4 lg:mb-8">
    <label class="pt-3.5 col-span-12 lg:col-span-4 text-slate-700">
      <span>{{ label }}</span>
      <span v-if="required" class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
    </label>
    <div class="col-span-12 lg:col-span-8">
      <div class="flex gap-4">
        <ValidationProvider
          v-slot="{ errors, ariaInput }"
          :class="wrapperClass"
          tag="div"
          :rules="rulesInput1"
          :name="name"
        >
          <input
            v-model="innerValueInput1"
            class="w-full h-12 px-5 text-base placeholder-gray-400 border rounded"
            :class="[isError ? 'border-red-600' : 'border-gray-200']"
            :type="type"
            :placeholder="placeholderInput1"
            value=""
            v-bind="ariaInput"
            :disabled="isDisabled"
            :set="(isErrorInput1 = !!errors.length) && (errorCommon = errors[0])"
          />
        </ValidationProvider>
        <ValidationProvider
          v-slot="{ errors, ariaInput }"
          :class="wrapperClass"
          tag="div"
          :rules="rulesInput2"
          :name="name"
        >
          <input
            v-model="innerValueInput2"
            class="w-full h-12 px-5 text-base placeholder-gray-400 border rounded"
            :class="[isError ? 'border-red-600' : 'border-gray-200']"
            :type="type"
            :placeholder="placeholderInput2"
            value=""
            v-bind="ariaInput"
            :disabled="isDisabled"
            :set="(isErrorInput2 = !!errors.length) && (errorCommon = errors[0])"
          />
        </ValidationProvider>
      </div>
      <p v-if="isError" class="text-sm text-gray-400 text-red-600">{{ errorCommon }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VInputTwo',
  props: {
    label: {
      type: String,
      default: '',
    },
    name: {
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
    vidInput1: {
      type: String,
      default: undefined,
    },
    vidInput2: {
      type: String,
      default: undefined,
    },
    valueInput1: {
      type: String,
      default: '',
    },
    valueInput2: {
      type: String,
      default: '',
    },
    placeholderInput1: {
      type: String,
      default: '',
    },
    placeholderInput2: {
      type: String,
      default: '',
    },
    rulesInput1: {
      type: [Object, String],
      default: '',
    },
    rulesInput2: {
      type: [Object, String],
      default: '',
    },
    isDisabled: {
      type: Boolean,
      default: false,
    },
    wrapperClass: {
      type: [String, Object],
      default: 'relative appearance-none w-full',
    },
    required: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    innerValueInput1: '',
    innerValueInput2: '',
    isErrorInput1: false,
    isErrorInput2: false,
    errorCommon: '',
  }),
  computed: {
    isError() {
      return this.isErrorInput1 || this.isErrorInput2
    },
  },
  watch: {
    innerValueInput1(value) {
      this.$emit('update:valueInput1', value)
    },
    innerValueInput2(value) {
      this.$emit('update:valueInput2', value)
    },
    valueInput1(val) {
      if (val !== this.innerValueInput1) {
        this.innerValueInput1 = val
      }
    },
    valueInput2(val) {
      if (val !== this.innerValueInput2) {
        this.innerValueInput2 = val
      }
    },
  },
  created() {
    if (this.valueInput1) {
      this.innerValueInput1 = this.valueInput1
    }
    if (this.valueInput2) {
      this.innerValueInput2 = this.valueInput2
    }
  },
}
</script>
