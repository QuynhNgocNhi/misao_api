<template>
  <div>
    <div class="py-8 bg-slate-200">
      <h2 class="text-3xl text-center">お問い合わせ</h2>
      <step :step="step"></step>
    </div>
    <div class="pt-10 pb-16">
      <div class="container">
        <transition-group name="fade" tag="div">
          <ValidationObserver v-show="step === 1" ref="form" v-slot="{ passes }" key="form-1" tag="div">
            <form novalidate @submit.prevent="passes(onSubmit)">
              <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>
              <v-select
                v-model="type"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="お問い合わせ種別"
                placeholder="選択してください"
                option-class="text-black"
                default-option-class="text-gray-400"
                vid="type"
                name="お問い合わせ種別"
                rules="required"
                default-text="選択してください"
                :options="contactType"
                wrapper-class="col-span-12 lg:col-span-3"
              ></v-select>
              <v-input
                v-model="companyName"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="会社名"
                placeholder="会社名"
                type="text"
                vid="company_name"
                name="会社名"
                rules="required|max:255"
              ></v-input>
              <v-input-full-name
                :value-first-name.sync="firstName"
                :value-last-name.sync="lastName"
                container-class="col-span-12 lg:col-span-6 flex gap-4"
                label="担当者名"
                placeholder-first-name="姓"
                placeholder-last-name="名"
                type="text"
                vid-first-name="first_name"
                vid-last-name="last_name"
                first-name="姓"
                last-name="名"
                rules-first-name="required|max:255"
                rules-last-name="required|max:255"
              ></v-input-full-name>
              <v-input
                v-model="phone"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="携帯電話番号"
                help="※ハイフンなしの電話番号を入力してください。"
                placeholder="半角数字"
                type="text"
                vid="phone"
                name="携帯電話番号"
                rules="required|phone"
              ></v-input>
              <v-input
                v-model="email"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="メールアドレス"
                help=""
                placeholder="steerlink@steerlink.com"
                type="text"
                vid="email"
                name="メールアドレス"
                rules="required"
              ></v-input>
              <v-textarea
                v-model="content"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="お問い合わせ内容"
                help="400文字以内でご入力ください。"
                placeholder="お問い合わせ内容の詳細をご入力ください。"
                vid="content"
                name="お問い合わせ内容"
                rules="required|max:400"
                rows="10"
                @keyup.enter.stop=""
              ></v-textarea>
              <div class="grid grid-cols-12 gap-8 mb-2 lg:mb-10">
                <label class="col-span-12 lg:col-span-4"></label>
                <div class="col-span-12 lg:col-span-4">
                  <button type="submit" class="btn btn-primary rounded w-full btn-icon h-14 px-16">
                    確認する<i class="fa fa-arrow-right"></i>
                  </button>
                </div>
              </div>
            </form>
          </ValidationObserver>

          <!-- FORM CONFIRM -->
          <div v-if="step === 2" key="form-2">
            <p class="mb-4">各ご記入内容に間違いがないか、ご確認ください。</p>
            <table class="table table-fixed border w-full bg-white">
              <tbody>
                <tr class="flex flex-col lg:table-row">
                  <td class="text-slate-700 bg-slate-200 py-1 w-full lg:w-48 bg-label lg:border-r">お問い合わせ種別</td>
                  <td class="py-2">{{ contactType[type] || '' }}</td>
                </tr>
                <tr class="flex flex-col lg:table-row">
                  <td class="text-slate-700 bg-slate-200 py-1 w-full lg:w-48 bg-label lg:border-r">会社名</td>
                  <td class="py-2">{{ companyName || '' }}</td>
                </tr>
                <tr class="flex flex-col lg:table-row">
                  <td class="text-slate-700 bg-slate-200 py-1 w-full lg:w-48 bg-label lg:border-r">担当者名</td>
                  <td class="py-2">{{ firstName + ' ' + lastName }}</td>
                </tr>
                <tr class="flex flex-col lg:table-row">
                  <td class="text-slate-700 bg-slate-200 py-1 w-full lg:w-48 bg-label lg:border-r">携帯電話番号</td>
                  <td class="py-2">{{ phone }}</td>
                </tr>
                <tr class="flex flex-col lg:table-row">
                  <td class="text-slate-700 bg-slate-200 py-1 w-full lg:w-48 bg-label lg:border-r">メールアドレス</td>
                  <td class="py-2">{{ email }}</td>
                </tr>
                <tr class="flex flex-col lg:table-row">
                  <td class="text-slate-700 bg-slate-200 py-1 w-full lg:w-48 bg-label lg:border-r">お問い合わせ内容</td>
                  <td class="py-2">
                    <span class="whitespace-pre-wrap">{{ content }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="mt-16 text-center grid grid-cols-1 w-full lg:w-80 mx-auto gap-4">
              <button type="button" class="btn btn-primary btn-lg rounded btn-icon w-full" @click="onSubmitConfirm">
                送信 <i class="fa fa-arrow-right"></i>
              </button>
              <button type="button" class="btn btn-outline-primary btn-lg rounded btn-icon w-full" @click="step = 1">
                入力に戻る <i class="fa fa-arrow-left left"></i>
              </button>
            </div>
          </div>
          <div v-if="step === 3" key="form-3">
            <p class="text-center leading-loose">
              お問い合わせが送信されました。
              <br />
              5日営業日以内にご連絡させていただきます。
            </p>
            <div class="grid grid-cols-12 gap-4 mt-8">
              <label class="col-span-12 lg:col-span-4"></label>
              <div class="col-span-12 lg:col-span-4">
                <a href="/" class="btn btn-primary rounded w-full btn-icon h-14 px-16">
                  トップに戻る <i class="fa fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ContactForm',
  props: {
    contactType: {
      type: [Object, Array, String],
      required: true,
    },
    user: {
      type: [Object],
      required: true,
    },
  },
  data() {
    return {
      step: 1,
      firstName: '',
      lastName: '',
      phone: '',
      email: '',
      content: '',
      type: '',
      companyName: '',
    }
  },
  created() {
    if (this.user && Object.keys(this.user).length) {
      this.firstName = this.user.first_name
      this.lastName = this.user.last_name
      this.phone = this.user.phone
      this.email = this.user.email
      this.companyName = this.user.company_name
    }
  },
  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }
      const params = this.getFormParams()
      this.isCallingApi = true

      this.$api
        .postContactRequest(
          params,
          success => {
            this.step = 2
            this.scrollToTop()
          },
          error => {
            this.showValidateError(error)
          }
        )
        .finally(() => {
          this.isCallingApi = false
        })
    },
    onSubmitConfirm() {
      if (this.isCallingApi) {
        return
      }

      const params = this.getFormParams()
      params.confirm = true
      this.isCallingApi = true

      this.$api
        .postContactRequest(
          params,
          success => {
            this.step = 3
            this.scrollToTop()
          },
          error => {
            this.step = 1
            this.showValidateError(error)
          }
        )
        .finally(() => {
          this.isCallingApi = false
        })
    },
    getFormParams() {
      return {
        type: this.type,
        first_name: this.firstName,
        last_name: this.lastName,
        phone: this.phone,
        email: this.email,
        content: this.content,
        company_name: this.companyName,
      }
    },
    scrollToTop() {
      window.scrollTo(0, 0)
    },
  },
}
</script>
