<template>
  <one-field-edit ref="statusForm" :value="label" label="" ref-name="form" @submit="onSubmit" @cancel="onCancel">
    <v-select
      v-model="status"
      label=""
      :show-label="false"
      placeholder="選択してください"
      option-class="text-black"
      default-option-class="text-gray-400"
      vid="status"
      name="ステータス"
      rules="required"
      default-text="選択してください"
      :options="options"
      wrapper-class=""
      class="mb-5"
    ></v-select>
  </one-field-edit>
</template>

<script>
export default {
  name: 'OrderEditStatusForm',
  props: {
    orderId: {
      type: [String, Number],
      required: true,
    },
    options: {
      type: [Array, Object],
      default: () => {
        return []
      },
    },
    value: {
      type: null,
      default: '',
    },
  },
  data() {
    return {
      status: '',
      defaultValue: '',
    }
  },
  computed: {
    label() {
      return this.options[this.defaultValue] ?? ''
    },
  },
  watch: {},
  created() {
    if (this.value) {
      this.status = this.value
      this.defaultValue = '' + this.value
    }
  },
  methods: {
    onCancel() {
      this.status = this.defaultValue
    },
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = { status: this.status }

      this.isCallingApi = true
      this.$api
        .postOrderUpdateStatus(
          this.orderId,
          params,
          success => {
            this.defaultValue = '' + params.status
            this.$refs.statusForm.hide()
          },
          error => {
            this.showValidateError(error, [], this.$refs.statusForm.getForm())
          }
        )
        .finally(() => {
          this.isCallingApi = false
        })
    },
  },
}
</script>

<style scoped>

</style>
