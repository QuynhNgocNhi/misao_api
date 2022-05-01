<template>
  <ValidationObserver ref="form" v-slot="{ passes }" tag="div">
    <form novalidate @submit.prevent="passes(onSubmit)" @keyup.enter="passes(onSubmit)">
      <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>
      <v-input
        v-model="email"
        class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
        label="ログインID"
        help="※ご登録メールアドレスを入力してください。"
        placeholder="steerlink@steerlink.com"
        type="text"
        vid="email"
        name="ログインID"
        rules="required"
      ></v-input>
      <v-input
        v-model="password"
        class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
        label="パスワード"
        :help="helpPassword"
        placeholder=""
        type="password"
        vid="password"
        name="パスワード"
        rules="required"
      ></v-input>
      <div class="grid grid-cols-12 gap-4 mb-4 lg:mb-8">
        <div class="md:col-start-5 col-span-8 flex align-items-center">
          <input v-model="remember" type="checkbox" class="w-[20px] h-[20px] border border-gray-200 mr-2" />
          <span class="text-slate-700">ログイン情報を記憶</span>
        </div>
      </div>
      <div class="grid grid-cols-12 gap-8 mb-2 lg:mb-10">
        <label class="col-span-12 lg:col-span-4"></label>
        <div class="col-span-12 lg:col-span-4">
          <button type="submit" class="btn btn-icon btn-primary w-full h-14 px-16">
            ログイン <i class="fa fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
export default {
  name: 'LoginForm',
  props: {
    urlForgetPassword: {
      type: String,
      required: false,
      default: '/forget-password',
    },
    redirectUrl: {
      type: String,
      required: false,
      default: '/',
    },
  },
  data() {
    return {
      email: '',
      password: '',
      remember: false,
    }
  },
  computed: {
    helpPassword() {
      return 'パスワードを忘れた方は<a href="' + this.urlForgetPassword + '" class="underline">こちら</a>'
    },
  },
  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = {
        email: this.email,
        password: this.password,
        remember: this.remember,
      }
      this.isCallingApi = true
      this.$api
        .postLogin(
          params,
          success => {
            window.location.href = this.redirectUrl
          },
          error => {
            this.showValidateError(error)
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
