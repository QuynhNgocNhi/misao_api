export default {
  props: {
    car: {
      type: Object,
    },
    loading: {
      type: Boolean,
    },
    check: {
      type: Object | Array,
      required: true,
    },
  },
  data() {
    return {
      wrapClass: 'row',
      wrapLabelClass: 'col-12 col-md-3 px-3 p-lg-3 label-input py-2 pb-md-2 d-flex align-items-center justify-content-between py-3 border bg-light',
      wrapInputClass: 'col-12 col-md-9 py-3 border',
    }
  },
  computed: {
    year() {
      var max = new Date().getFullYear()
      var min = max - 30
      var years = {}

      for (var i = max; i >= min; i--) {
        years[i] = i
      }
      return years
    },
  },
  methods: {
    submit() {
      this.$emit('submit')
    },
  },
}
