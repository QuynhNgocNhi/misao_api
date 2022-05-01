<template>
  <ValidationObserver v-if="!success" ref="form" v-slot="{ passes }" tag="div">
    <p class="text-center mb-10 w-full lg:w-10/12 mx-auto">
      ご登録されたログインID（メールアドレスを）を入力して、「送信する」をクリックしてください。<br />
      入力していただいたメールアドレスに、パスワード再設定ページへのリンクを記載したメールをお送りいたします。
    </p>
    <form novalidate @submit.prevent="passes(onSubmit)" @keyup.enter="passes(onSubmit)">
      <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>
      <v-input
        v-model="email"
        class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
        label="メールアドレス"
        help="※ご登録メールアドレスを入力してください。"
        placeholder="steerlink@steerlink.com"
        type="text"
        vid="email"
        name="ログインID"
        rules="required"
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
  <p v-else class="w-full lg:w-3/4 mx-auto text-center leading-loose">
    ご入力いただきましたメールアドレス宛にパスワード変更用URLを記載したメールを送信いたしました。<br />
    メール内に記載されているURLにアクセスいただき登録内容を変更してください
  </p>
</template>

<script>
export default {
  name: 'PasswordEmailForm',
  data() {
    return {
      email: '',
      success: false,
    }
  },

  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = {
        email: this.email,
        password: this.password,
      }
      this.isCallingApi = true
      this.$api
        .postPasswordEmail(
          params,
          success => {
            this.success = true
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
