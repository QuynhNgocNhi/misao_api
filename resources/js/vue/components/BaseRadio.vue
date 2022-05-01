<template>
  <div :class="[wrapClass, { 'gap-0 lg:gap-4 !mb-0 border': carForm }]">
    <div
      v-if="!!label"
      class="text-slate-700 bg-slate-200 py-1 px-3 lg:p-0 lg:bg-white"
      :class="[wrapLabelClass, { 'lg:!p-4 lg:border-r !bg-slate-200': carForm }]"
    >
      {{ label }}
      <span v-if="required" class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
    </div>
    <div :class="[wrapInputClass, { '!p-4 lg:!pl-0': carForm }]" class="py-1 px-3 lg:p-0">
      <div :class="inputLocalClass" class="flex flex-wrap gap-1 lg:gap-2">
        <div v-for="(item, key) in items" :key="key" class="cursor-pointer label py-1 px-2 bg-gray-200">
          <input :id="name + key" v-model="localValue" class="radio radio-xs bg-white" type="radio" :value="key" tabindex="0"/>
          <label class="label-text ml-1" :for="name + key">{{ item }}</label>
        </div>
      </div>
      <p v-if="!!help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="hasError(name)" class="invalid text-sm text-gray-400 text-red-600">{{ showError(name) }}</p>
    </div>
  </div>
</template>

<script>
import vmodel from '../mixins/vmodel'
export default {
  name: 'BaseRadio',
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
    items: {
      type: Array | Object,
      required: true,
    },
    label: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      required: true,
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
      type: String | Number,
      default: '',
    },
  },
  data() {
    return {}
  },
}
</script>
