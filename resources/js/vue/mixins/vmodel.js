export default {
  inject: ['getErrors'],
  props: {
    carForm: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      localValue: '',
    }
  },
  computed: {
    errors() {
      return this.getErrors()
    },
  },
  created() {
    this.localValue = this.value
  },
  methods: {
    hasError(field) {
      return !!this.errors?.[field]
    },
    showError(field) {
      return this.errors?.[field][0]
    },
    onlyNumber($event) {
      if (typeof this.isOnlyNumber === 'undefined' || !this.isOnlyNumber) return false
      let keyCode = $event.keyCode ? $event.keyCode : $event.which
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault()
      }
    },
  },
  watch: {
    localValue(value) {
      this.$emit('input', value)
    },
  },
}
