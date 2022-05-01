<template>
  <div :class="[wrapClass, { 'gap-0 lg:gap-4 !mb-0 border': carForm }]">
    <div
      v-if="!!label"
      :class="[wrapLabelClass, { 'lg:!p-4 lg:border-r !bg-slate-200': carForm }]"
      class="text-slate-700 bg-slate-200 py-1 px-3 lg:p-0 lg:bg-white"
    >
      {{ label }}
      <span v-if="required" class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
    </div>
    <div :class="[wrapInputClass, { '!p-4 lg:!pl-0': carForm }]" class="py-1 px-3 lg:p-0">
      <textarea v-model="localValue" class="textarea h-64 textarea-bordered" :class="inputLocalClass" tabindex="3"></textarea>
      <p v-if="!!help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="hasError(name)" class="invalid text-sm text-gray-400 text-red-600">{{ showError(name) }}</p>
    </div>
  </div>
</template>

<script>
import vmodel from '../mixins/vmodel'

export default {
  name: 'BaseTextarea',
  mixins: [vmodel],
  props: {
    wrapClass: {
      type: String,
      default: 'grid grid-cols-12 gap-4 mb-4 lg:mb-8',
    },
    wrapLabelClass: {
      type: String,
      default: 'col-span-12 lg:col-span-4',
    },
    wrapInputClass: {
      type: String,
      default: 'col-span-12 lg:col-span-8',
    },
    inputLocalClass: {
      type: String,
      default: 'w-full',
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
    value: {
      type: String,
      default: '',
    },
  },
  data() {
    return {}
  },
}
</script>
