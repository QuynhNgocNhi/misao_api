<template>
  <div class="pt-10 pb-16">
    <div class="container">
      <ValidationObserver ref="form" v-slot="{ passes }" tag="div">
        <form novalidate @submit.prevent="passes(onSubmit)" @keyup.enter="passes(onSubmit)">
          <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>
          <v-input
            v-model="currentPassword"
            class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
            label="現在のパスワード"
            type="password"
            vid="current_password"
            name="現在のパスワード"
            rules="required|min:8"
          ></v-input>
          <v-input
            v-model="password"
            class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
            label="新しいパスワード"
            help="※半角英数字 8文字以上で入力してください。"
            type="password"
            vid="password"
            name="新しいパスワード"
            rules="required|min:8"
          ></v-input>
          <v-input
            v-model="passwordConfirmation"
            class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
            label="パスワード確認"
            help="※確認のため入力したパスワードを再度入力してください。"
            type="password"
            vid="password_confirmation"
            name="パスワード確認"
            rules="required|confirmed:password"
          ></v-input>

          <div class="grid grid-cols-12 gap-8 mb-2 lg:mb-10">
            <label class="col-span-12 lg:col-span-4"></label>
            <div class="col-span-12 lg:col-span-4">
              <button type="submit" class="btn btn-icon btn-primary w-full h-14 px-16">
                再設定する <i class="fa fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </form>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
import Toast from '@/commons/notyf'

export default {
  name: 'EditPasswordForm',
  data() {
    return {
      currentPassword: '',
      password: '',
      passwordConfirmation: '',
    }
  },
  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = this.getFormParams()
      params.confirm = true
      this.isCallingApi = true
      this.$api
        .postUpdatePassword(
          params,
          success => {
            Toast.success(success.msg)
            setTimeout(function () {
              window.location = '/account/info/'
            }, 500)
          },
          error => {
            this.showValidateError(error)
          }
        )
        .finally(() => {
          this.isCallingApi = false
        })
    },
    getFormParams() {
      return {
        current_password: this.currentPassword,
        password: this.password,
        password_confirmation: this.passwordConfirmation,
      }
    },
  },
}
</script>
