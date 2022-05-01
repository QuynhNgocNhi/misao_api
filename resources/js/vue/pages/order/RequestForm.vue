<template>
  <div>
    <div class="py-8 bg-slate-200">
      <h2 class="text-3xl text-center text-slate-700">在庫確認・商談申込</h2>
      <step :step="step"></step>
    </div>
    <div class="pt-10 pb-16 mt-10">
      <div class="container">
        <transition-group name="fade" tag="div">
          <ValidationObserver v-show="step === 1" ref="form" v-slot="{ passes }" key="form-1" tag="div">
            <form novalidate @submit.prevent="passes(onSubmit)">
              <p v-if="apiError" class="text-gray-400 text-red-600 text-center mb-5">{{ apiError[0] }}</p>

              <v-input
                v-model="innerContactCode"
                class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
                label="お問い合わせ車両番号"
                placeholder="半角数字"
                type="text"
                vid="contact_code"
                name="お問い合わせ車両番号"
                rules="required"
                :is-disabled="!!contactCode"
              ></v-input>
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
                :options="optionsType"
                wrapper-class="col-span-12 lg:col-span-4"
              ></v-select>

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
                  <button type="submit" class="btn btn-primary btn-lg btn-wide rounded btn-icon w-full md:w-full">
                    確認 <i class="fa fa-arrow-right"></i>
                  </button>
                </div>
              </div>
            </form>
          </ValidationObserver>

          <!-- FORM CONFIRM -->
          <div v-if="step === 2" key="form-2">
            <p class="mb-4">各ご記入内容に間違いがないか、ご確認ください。</p>
            <div class="border border-zinc-400 w-full grid grid-cols-1 bg-white">
              <AttributeShow label="お問い合わせ車両番号" :value="innerContactCode" />
              <AttributeShow label="お問い合わせ種別" :value="optionsType[type] || ''" />
              <AttributeShow label="担当者名" :value="firstName + ' ' + lastName" />
              <AttributeShow label="お問い合わせ内容" :value="content" />
            </div>
            <div class="mt-16 text-center grid grid-cols-1 w-full lg:w-80 mx-auto gap-4">
              <button type="button" class="btn btn-primary btn-lg rounded btn-icon w-full" @click="onSubmitConfirm">
                送信 <i class="fa fa-arrow-right"></i>
              </button>
              <button type="button" class="btn btn-outline-primary btn-lg rounded btn-icon w-full" @click="step = 1">
                入力に戻る <i class="fa fa-arrow-left left"></i>
              </button>
            </div>
          </div>

          <!-- FORM SUCCESS -->
          <div v-if="step === 3" key="form-3">
            <p class="text-center leading-loose">
              お問い合わせが送信されました。<br />
              お問い合わせ先企業と直接メッセージのやり取りが可能です。
            </p>
            <div class="grid grid-cols-12 gap-4 mt-8">
              <label class="col-span-12 lg:col-span-4"></label>
              <div class="col-span-12 text-center">
                <a :href="urlMessage" class="btn btn-primary btn-lg btn-wide rounded btn-icon w-full md:w-auto">
                  メッセージを確認する
                  <i class="fa fa-arrow-right"></i
                ></a>
              </div>
            </div>
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
import AttributeShow from '../../components/AttributeShow'
export default {
  name: 'OrderRequestForm',
  components: { AttributeShow },
  props: {
    typeForm: {
      type: [Object, Array, String],
      required: true,
    },
    contactCode: {
      type: [String],
      default: '',
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
      urlMessage: '',
      innerContactCode: '',
    }
  },
  computed: {
    optionsType() {
      if (typeof this.typeForm === 'string') {
        try {
          return JSON.parse(this.typeForm)
        } catch (e) {
          console.log(e)
          return []
        }
      }
      return this.typeForm
    },
  },
  watch: {
    contactCode(val) {
      if (val !== this.innerContactCode) {
        this.innerContactCode = val
      }
    },
  },
  created() {
    this.innerContactCode = this.contactCode
  },
  methods: {
    onSubmit() {
      if (this.isCallingApi) {
        return
      }

      const params = this.getFormParams()

      this.isCallingApi = true
      this.$api
        .postOrderRequest(
          params,
          success => {
            this.step = 2
            if (success.data) {
              const user = success.data
              this.firstName = user.first_name
              this.lastName = user.last_name
              this.phone = user.phone
              this.email = user.email
            }
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
        .postOrderRequest(
          params,
          success => {
            this.step = 3
            this.urlMessage =
              '/chat/?chat_room_id=' + success.data.chat_room?.id + '&tab=' + this.$config.CHAT.TYPE_BUYER
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
        contact_code: this.innerContactCode,
        type: this.type,
        first_name: this.firstName,
        last_name: this.lastName,
        phone: this.phone,
        email: this.email,
        content: this.content,
      }
    },
  },
}
</script>

<style scoped>

</style>
