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
      wrapClass: 'grid grid-cols-12 gap-4 mb-4 lg:mb-8 gap-0 lg:gap-4 !mb-0 border',
      wrapLabelClass:
        'col-span-12 lg:col-span-4 text-slate-700 bg-slate-200 py-1 px-3 lg:p-0 lg:bg-white lg:!p-4 lg:border-r !bg-slate-200',
      wrapInputClass: 'col-span-12 lg:col-span-8 !py-4 lg:!pl-0',
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
