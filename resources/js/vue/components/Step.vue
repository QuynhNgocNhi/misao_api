<template>
  <div class="lg:w-2/4 mx-auto">
    <div class="p-4 h-[112px]">
      <div class="flex items-center">
        <div class="flex items-center text-black relative">
          <div
            class="rounded-full transition duration-500 h-12 w-12 py-3 text-center"
            :class="{
              'bg-slate-700': step === 1,
              'text-white': step === 1,
              'bg-gray-50': step !== 1,
              'text-gray-300': step !== 1,
            }"
          >
            <div v-if="step == 1">1</div>
            <div v-else><i class="fas fa-check"></i></div>
          </div>
          <div
            class="absolute top-0 -ml-10 text-center mt-16 w-32 text-sm"
            :class="{
              'text-black': step === 1,
              'text-gray-500': step !== 1,
            }"
          >
            入力
          </div>
        </div>
        <div class="flex-auto border-t-2 transition duration-500 border-gray mx-4 lg:mx-8"></div>
        <div class="flex items-center relative">
          <div
            class="rounded-full transition duration-500 h-12 w-12 py-3 text-center"
            :class="{
              'bg-slate-700': step === 2,
              'text-white': step === 2,
              'bg-gray-50': step !== 2,
              'text-gray-300': step !== 2,
            }"
          >
            <div v-if="step <= 2">2</div>
            <div v-else><i class="fas fa-check"></i></div>
          </div>
          <div
            class="absolute top-0 -ml-10 text-center mt-16 w-32 text-sm"
            :class="{
              'text-black': step === 2,
              'text-gray-500': step !== 2,
            }"
          >
            確認
          </div>
        </div>
        <div class="flex-auto border-t-2 transition duration-500 border-gray mx-4 lg:mx-8"></div>
        <div class="flex items-center text-gray-500 relative">
          <div
            class="rounded-full transition duration-500 h-12 w-12 py-3 text-center"
            :class="{
              'bg-slate-700': step === 3,
              'text-white': step === 3,
              'bg-gray-50': step !== 3,
              'text-gray-300': step !== 3,
            }"
          >
            <div v-if="step <= 3">3</div>
            <div v-else><i class="fas fa-check"></i></div>
          </div>
          <div
            class="absolute top-0 -ml-10 text-center mt-16 w-32 text-sm"
            :class="{
              'text-black': step === 3,
              'text-gray-500': step !== 3,
            }"
          >
            完了
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Step',
  props: {
    step: {
      type: Number,
      required: true,
    },
  },
}
</script>
