<template>
  <div class="pb-4 mt-4 bg-white">
    <div class="p-3">
      <p>審査結果送信</p>
      <base-radio-admin
        v-model="car.approve"
        :items="carApprove"
        name="approve"
        wrap-class="ml-n3 mb-2"
        wrap-input-class="px-2"
        :disabled="isDisabled"
      />
      <p>審査結果内容</p>
      <base-textarea-admin
        v-model="car.approve_reason"
        name="approve_reason"
        wrap-class="ml-n3"
        wrap-input-class="p-0"
        label=""
        :disabled="isDisabled"
      />
      <p class="text-sm">内容は会員向けお知らせ情報に表示されます。</p>
      <button v-show="!isDisabled" class="btn btn-icon btn-primary btn-md text-white px-5" @click="submit()">
        送信
      </button>
    </div>
  </div>
</template>

<script>
import Toast from '../../../../commons/notyf'

export default {
  name: 'ApproveForm',
  provide() {
    return {
      getErrors: () => {
        return this.errors
      },
    }
  },
  props: {
    carData: {
      type: Object,
      required: true,
    },
    carApprove: {
      type: [Object, Array],
      required: true,
    },
  },
  data() {
    return {
      car: {},
      errors: {},
      isDisabled: false,
      loading: false,
    }
  },
  created() {
    if (Object.keys(this.carData).length) {
      this.car = this.carData
    }
    this.isDisabled = this.car.approve == 2 || this.car.approve == 3 //Approve and not approve
  },
  methods: {
    submit() {
      if (this.loading) {
        return false
      }
      this.loading = true
      let params = {
        id: this.car.id,
        approve: this.car.approve !== 0 && this.car.approve !== 1 ? parseInt(this.car.approve) : null,
        approve_reason: this.car.approve_reason,
      }
      this.$api
        .approveCar(params)
        .then(res => {
          Toast.success(res.msg)
          setTimeout(function () {
            window.location = '/admin/car-approve/'
          }, 500)
        })
        .catch(error => {
          this.errors = error.data.errors
        })
        .finally(() => {
          this.loading = false
        })
    },
  },
}
</script>










