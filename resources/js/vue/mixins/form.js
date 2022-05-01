export default {
  data() {
    return {
      apiError: '',
      isCallingApi: false,
    }
  },
  methods: {
    showValidateError(error, customError, ref) {
      ref = ref || this.$refs.form

      let inputErrors = error?.error ?? {}
      let formErrors = error?.error?.error ? [error.error.error] : []
      if (typeof customError === 'object' && !!customError) {
        if (customError.inputErrors && typeof customError.inputErrors === 'object' && !!customError.inputErrors) {
          inputErrors = { ...inputErrors, ...customError.inputErrors }
        }
        if (Array.isArray(customError.formErrors)) {
          formErrors = [...formErrors, ...customError.formErrors]
        }
      }

      ref?.setErrors(inputErrors)
      this.apiError = formErrors
    },
  },
}
