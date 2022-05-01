<template>
  <div>
    <template v-if="isEdit">
      <ValidationObserver :ref="refName" v-slot="{ passes }" tag="div" novalidate @submit.prevent>
        <form>
          <!-- render input -->
          <div v-if="!!$slots.default"><slot></slot></div>
          <div v-else>
            <v-input
              v-model="innerValue"
              class="grid grid-cols-12 gap-4 mb-4 lg:mb-8"
              :label="label"
              :type="type"
              vid="value"
              :name="label"
              :rules="rules"
              :show-label="false"
            ></v-input>
          </div>

          <!-- render button -->
          <div v-if="!!$slots.button"><slot name="button"></slot></div>
          <div v-else>
            <button type="button" class="btn btn-md btn-icon btn-outline px-8" @click.prevent="onCancel">
              キャンセル
            </button>
            <button type="submit" class="btn btn-md btn-icon btn-black px-8" @click="passes(onSubmit)">変更する</button>
          </div>
        </form>
      </ValidationObserver>
    </template>
    <!-- render text value and button edit -->
    <template v-else>
      <template v-if="$slots.content">
        <slot name="content"></slot>
      </template>
      <template v-else>
        {{ value }}
        <a class="btn btn-md btn-icon px-16" @click.prevent="show"><i class="fa fa-arrow-right"></i>変更する</a>
      </template>
    </template>
  </div>
</template>
<script>
export default {
  name: 'OneFieldEdit',
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: null,
      required: true,
    },
    submitText: {
      type: String,
      required: false,
      default: '変更',
    },
    refName: {
      type: String,
      default: 'form',
    },
    rules: {
      type: [String, Object, Array],
      default: '',
    },
    type: {
      type: String,
      default: 'text',
      validator(value) {
        return ['url', 'text', 'password', 'tel', 'search', 'number', 'email'].includes(value)
      },
    },
  },
  data() {
    return {
      isEdit: false,
      innerValue: '',
    }
  },
  watch: {
    value(val) {
      if (val !== this.innerValue) {
        this.innerValue = val
      }
    },
    innerValue(value) {
      this.$emit('input', value)
    },
  },
  created() {
    if (this.value) {
      this.innerValue = this.value
    }
  },
  methods: {
    onValidation() {
      this.error = ''
    },
    onSubmit() {
      this.$emit('submit', this)
    },
    onCancel() {
      this.isEdit = false
      this.innerValue = this.value
      this.$emit('cancel', this)
    },
    setError(error) {
      this.error = error
    },
    show() {
      this.isEdit = true
    },
    hide() {
      this.onCancel()
    },
    getForm() {
      return this.$refs[this.refName]
    },
  },
}
</script>
<style scoped>
.is-primary {
  cursor: pointer;
  user-select: none;
}
.button-submit {
  margin-top: -5px;
}
</style>
