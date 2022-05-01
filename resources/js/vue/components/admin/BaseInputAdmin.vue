<template>
  <div :class="wrapClass">
    <div v-if="!!label" :class="wrapLabelClass" class="border col-3">
      {{ label }}
      <span v-if="required" class="bg-danger ml-2 py-1 px-3 text-white text-xs rounded float-lg-right">必須</span>
    </div>
    <div :class="wrapInputClass">
      <div v-if="hasAfterInputSlot || hasBeforeInputSlot" class="row pl-2">
        <slot name="beforeInput"></slot>
        <input
          v-model="localValue"
          type="text"
          :placeholder="placeholder"
          :class="inputLocalClass"
          class="form-control"
          @keypress="onlyNumber"
        />
        <slot name="afterInput"></slot>
      </div>
      <input
        v-else
        v-model="localValue"
        type="text"
        :placeholder="placeholder"
        class="form-control"
        :class="inputLocalClass"
        @keypress="onlyNumber"
      />
      <p v-if="!!help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="hasError(name)" class="text-sm text-danger">{{ showError(name) }}</p>
    </div>
  </div>
</template>

<script>
import vmodel from '../../mixins/vmodel'

export default {
  name: 'BaseInputAdmin',
  mixins: [vmodel],
  props: {
    wrapClass: {
      type: String,
      default: 'row',
    },
    wrapLabelClass: {
      type: String,
      default: 'col-12 col-md-3 px-3 pb-2 p-lg-3 label-input pb-md-2 d-flex align-items-center justify-content-between py-3 border bg-light',
    },
    wrapInputClass: {
      type: String,
      default: 'col-12 col-md-9 px-3 py-3 border',
    },
    inputLocalClass: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      required: true,
    },
    placeholder: {
      type: String,
      default: '',
    },
    help: {
      type: String,
      default: '',
    },
    required: {
      type: Boolean,
      default: false,
    },
    isOnlyNumber: {
      type: Boolean,
      default: false,
    },
    value: {
      type: String | Number,
      default: '',
    },
  },
  data() {
    return {}
  },
  computed: {
    hasBeforeInputSlot() {
      return !!this.$slots.beforeInput
    },
    hasAfterInputSlot() {
      return !!this.$slots.afterInput
    },
  },
  created() {
    this.localValue = this.value
  },
}
</script>
