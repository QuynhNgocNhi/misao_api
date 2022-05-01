<template>
  <div :class="wrapClass">
    <div v-if="!!label" :class="wrapLabelClass" class="border">
      {{ label }}
      <span v-if="required" class="bg-danger ml-2 py-1 px-3 text-white text-xs rounded float-lg-right">必須</span>
    </div>
    <div :class="wrapInputClass">
      <div v-if="hasAfterInputSlot" :class="wrapSelectClass">
        <select v-model="localValue" :class="inputLocalClass" class="form-control">
          <option disabled="disabled" selected="selected">{{ placeholder }}</option>
          <option v-for="(item, key) in items" :key="key" :value="key">{{ item }}</option>
        </select>
        <slot name="afterInput"></slot>
      </div>
      <select v-else v-model="localValue" class="" :class="inputLocalClass">
        <option disabled="disabled" value="">{{ placeholder }}</option>
        <option v-for="(item, key) in items" :key="key" :value="key">{{ item }}</option>
      </select>
      <p v-if="help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="hasError(name)" class="text-sm text-danger">{{ showError(name) }}</p>
    </div>
  </div>
</template>

<script>
import vmodel from '../../mixins/vmodel'
export default {
  name: 'BaseSelectAdmin',
  mixins: [vmodel],
  props: {
    wrapClass: {
      type: String,
      default: 'row',
    },
    wrapLabelClass: {
      type: String,
      default: 'px-3 pb-2 p-lg-3 label-input pb-md-2 d-flex align-items-center justify-content-between py-3 border bg-light',
    },
    wrapSelectClass: {
      type: String,
      default: '',
    },
    wrapInputClass: {
      type: String,
      default: '',
    },
    inputLocalClass: {
      type: String,
      default: '',
    },
    items: {
      type: Object,
      required: true,
    },
    label: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      required: false,
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
      type: String | Number,
      default: '',
    },
  },
  data() {
    return {}
  },
  computed: {
    hasAfterInputSlot() {
      return !!this.$slots.afterInput
    },
  },
}
</script>
