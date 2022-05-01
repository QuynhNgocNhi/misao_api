<template>
  <div :class="wrapClass">
    <div v-if="!!label" :class="wrapLabelClass" class="border py-1 px-3">
      {{ label }}
      <span v-if="required" class="bg-danger ml-2 py-1 px-3 text-white text-xs rounded float-lg-right">必須</span>
    </div>
    <div :class="wrapInputClass" class="py-1 px-3">
      <div :class="inputLocalClass" class="flex">
        <div v-for="(item, key) in items" :key="key" class="checkbox label py-1 mb-2 mr-2 px-2 d-inline-block align-items-center">
          <input
            :id="name + key"
            v-model="localValue"
            :name="name"
            class="form-check-inline checkbox-xs bg-white m-0"
            type="checkbox"
            :value="key"
          />
          <label class="font-weight-normal ml-1 mb-0" :for="name + key">{{ item }}</label>
        </div>
      </div>
      <p v-if="help" class="text-sm text-slate-700" v-html="help"></p>
      <p v-if="hasError(name)" class="text-sm text-danger">{{ showError(name) }}</p>
    </div>
  </div>
</template>

<script>
import vmodel from '../../mixins/vmodel'
export default {
  name: 'BaseCheckboxAdmin',
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
    return {
      localValue: [],
    }
  },
  created() {
    this.localValue = this.value || []
  },
}
</script>
