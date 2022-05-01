<template>
  <div class="grid grid-cols-12 gap-4 mb-4 lg:mb-8">
    <label class="pt-3.5 col-span-12 lg:col-span-4 text-slate-700">
      <span>{{ label }}</span>
      <span v-if="required" class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
    </label>
    <div class="grid grid-cols-1 lg:flex" :class="containerClass">
      <ValidationProvider
        v-slot="{ errors, ariaInput, ariaMsg }"
        :class="wrapperClass"
        tag="div"
        :vid="vidFirstName"
        :rules="rulesFirstName"
        :name="firstName"
        :validate="onValidateFirstName"
      >
        <input
          :id="firstName"
          ref="input"
          v-model="innerValueFirstname"
          class="w-full h-12 px-5 text-base placeholder-gray-400 border rounded focus:shadow-outline"
          :class="{
            'border-gray-200': !(errors && errors[0]),
            'border-red-600': errors && errors[0],
            'has-value': hasValueFirstName,
          }"
          :type="type"
          :placeholder="placeholderFirstName"
          value=""
          v-bind="ariaInput"
          :set="(isErrorFirstName = !!errors.length)"
          :disabled="isDisabled"
        />
        <p v-if="helpFirstName" class="text-sm text-gray-400" v-html="helpFirstName"></p>
        <p v-if="errors && errors[0]" class="text-sm text-red-600">
          {{ errors[0] }}
        </p>
      </ValidationProvider>
      <ValidationProvider
        v-slot="{ errors, ariaInput, ariaMsg }"
        :class="wrapperClass"
        tag="div"
        :vid="vidLastName"
        :rules="rulesLastName"
        :name="lastName"
        :validate="onValidateLastName"
      >
        <input
          :id="lastName"
          ref="input"
          v-model="innerValueLastName"
          class="w-full h-12 px-5 text-base placeholder-gray-400 border rounded focus:shadow-outline"
          :class="{
            'border-gray-200': !(errors && errors[0]),
            'border-red-600': errors && errors[0],
            'has-value': hasValueLastName,
          }"
          :type="type"
          :placeholder="placeholderLastName"
          value=""
          v-bind="ariaInput"
          :set="(isErrorLastName = !!errors.length)"
          :disabled="isDisabled"
        />
        <p v-if="helpLastName" class="text-sm text-gray-400" v-html="helpLastName"></p>
        <p v-if="errors && errors[0]" class="text-sm text-red-600">
          {{ errors[0] }}
        </p>
      </ValidationProvider>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VInputFullName',
  props: {
    label: {
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
    vidFirstName: {
      type: String,
      default: undefined,
    },
    vidLastName: {
      type: String,
      default: undefined,
    },
    firstName: {
      type: String,
      default: '',
    },
    lastName: {
      type: String,
      default: '',
    },
    valueFirstName: {
      type: String,
      default: '',
    },
    valueLastName: {
      type: String,
      default: '',
    },
    placeholderFirstName: {
      type: String,
      default: '',
    },
    placeholderLastName: {
      type: String,
      default: '',
    },
    rulesFirstName: {
      type: [Object, String],
      default: '',
    },
    rulesLastName: {
      type: [Object, String],
      default: '',
    },
    helpFirstName: {
      type: String,
      default: '',
    },
    helpLastName: {
      type: String,
      default: '',
    },
    isDisabled: {
      type: Boolean,
      default: false,
    },
    wrapperClass: {
      type: [String, Object],
      default: 'relative appearance-none w-full TextInput',
    },
    containerClass: {
      type: [String, Object],
      default: 'col-span-12 lg:col-span-8 flex gap-4',
    },
  },
  data: () => ({
    innerValueFirstname: '',
    innerValueLastName: '',
    isErrorFirstName: false,
    isErrorLastName: false,
  }),
  computed: {
    hasValueFirstName() {
      return !!this.innerValueFirstname
    },
    hasValueLastName() {
      return !!this.innerValueLastName
    },
    isError() {
      return this.isErrorFirstName || this.isErrorLastName
    },
    required() {
      let rule = null
      if (typeof this.rulesFirstName === 'string') {
        rule = this.rulesFirstName.split('|')
        if (rule.includes('required')) {
          return true
        }
      } else {
        if ('required' in this.rulesFirstName) {
          return true
        }
      }

      if (typeof this.rulesLastName === 'string') {
        rule = this.rulesLastName.split('|')
        if (rule.includes('required')) {
          return true
        }
      } else {
        if ('required' in this.rulesLastName) {
          return true
        }
      }

      return false
    },
  },
  watch: {
    innerValueFirstname(value) {
      this.$emit('update:valueFirstName', value)
    },
    innerValueLastName(value) {
      this.$emit('update:valueLastName', value)
    },
    valueFirstName(val) {
      if (val !== this.innerValueFirstname) {
        this.innerValueFirstname = val
      }
    },
    valueLastName(val) {
      if (val !== this.innerValueLastName) {
        this.innerValueLastName = val
      }
    },
  },
  created() {
    if (this.valueFirstName) {
      this.innerValueFirstname = this.valueFirstName
    }
    if (this.valueLastName) {
      this.innerValueLastName = this.valueLastName
    }
  },
  methods: {
    onValidateFirstName(e) {
      console.log(e)
    },
    onValidateLastName(e) {
      console.log(e)
    },
  },
}
</script>
