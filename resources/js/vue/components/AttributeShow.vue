<template>
  <div class="grid grid-cols-1 lg:grid-cols-5 border-b">
    <span
      class="col-span-1 lg:col-span-1 py-1 px-3 lg:py-3 lg:px-6 font-medium text-slate-700 bg-slate-200 border-b lg:border-b-0 lg:border-r"
      >{{ label }}</span
    >
    <span class="col-span-1 lg:col-span-4 p-3 lg:py-3 lg:px-6 whitespace-pre-line">{{ value }}</span>
  </div>
</template>

<script>
export default {
  name: 'AttributeShow',
  props: ['label', 'value'],
}
</script>
