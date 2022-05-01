<template>
  <ValidationObserver ref="form" v-slot="{ passes }" tag="div">
    <form novalidate @submit.prevent="passes(onSubmit)" @keyup.enter="passes(onSubmit)">
      <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>
      <v-input
        v-model="password"
        class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
        label="パスワード"
        help="※半角英数字 8文字以上で入力してください。"
        placeholder=""
        type="password"
        vid="password"
        name="パスワード"
        rules="required|min:8"
      ></v-input>
      <v-input
        v-model="passwordConfirmation"
        class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
        label="パスワード確認"
        help="※確認のため入力したパスワードを再度入力してください。"
        placeholder=""
        type="password"
        vid="password_confirmation"
        name="パスワード確認"
        rules="required|confirmed:password"
      ></v-input>

      <div class="grid grid-cols-12 gap-8 mb-2 lg:mb-10">
        <label class="col-span-12 lg:col-span-4"></label>
        <div class="col-span-12 lg:col-span-4">
          <button type="submit" class="btn btn-icon btn-primary w-full h-14 px-16">
            送信する <i class="fa fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
export default {
  name: 'PasswordResetForm',
  props: {
    token: {
      type: String,
      required: true,
    },
    email: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      password: '',
      passwordConfirmation: '',
    }
  },

  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = {
        email: this.email,
        token: this.token,
        password: this.password,
        password_confirmation: this.passwordConfirmation,
      }
      this.isCallingApi = true
      this.$api
        .postPasswordReset(
          params,
          success => {
            window.location.href = '/'
          },
          error => {
            const customError = {}
            if ('email' in error.error) {
              customError.formErrors = [error.error.email]
            }

            this.showValidateError(error, customError)
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
