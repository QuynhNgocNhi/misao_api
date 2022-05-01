<template>
  <div :class="wrapClass">
    <div v-if="!!label" :class="wrapLabelClass" class="border py-1 px-3">
      {{ label }}
      <span v-if="required" class="bg-danger ml-2 py-1 px-3 text-white text-xs rounded float-lg-right">必須</span>
    </div>
    <div :class="wrapInputClass" class="py-1 px-3">
      <textarea v-model="localValue" class="textarea textarea-bordered" :class="inputLocalClass" rows="5" :disabled="disabled"></textarea>
      <p v-if="!!help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="hasError(name)" class="text-sm text-danger">{{ showError(name) }}</p>
    </div>
  </div>
</template>

<script>
import vmodel from '../../mixins/vmodel'

export default {
  name: 'BaseTextareaAdmin',
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
      default: 'col-12 col-md-9 py-3 border',
    },
    inputLocalClass: {
      type: String,
      default: 'form-control',
    },
    label: {
      type: String,
      default: 'label-input font-weight-bold',
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
    value: {
      type: String,
      default: '',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {}
  },
}
</script>
