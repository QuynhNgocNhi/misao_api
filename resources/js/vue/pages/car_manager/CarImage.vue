<template>
  <div class="border p-1">
    <div class="flex justify-between mb-1">
      <span class="text-xs"
        >{{ index }} <span>{{ index === 1 ? 'メイン画像' : 'サブ画像' }}</span
        ><span v-if="index < 7" class="text-red-500 ml-2">必須</span></span
      >
      <span
        class="flex justify-center items-center bg-slate-200 rounded-full h-4 w-4 cursor-pointer text-sm"
        @click="deleteMedia(media.id)"
        >×</span
      >
    </div>
    <div class="mb-1"><img :src="media.url" class="h-32 w-full object-contain" /></div>
    <select
      v-model="position"
      class="select select-bordered rounded-none select-xs w-full max-w-xs font-normal"
      @change="updatePhotoPosition"
    >
      <option disabled value="">選択してください</option>
      <option v-for="(value, key) in photoPosition" :value="key">{{ value }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'CarImage',
  props: {
    index: {
      type: [String, Number],
    },
    media: {
      type: Object,
    },
    photoPosition: {
      type: [Object, Array],
    },
  },
  data() {
    return {
      position: this.media.photo_position ? this.media.photo_position : "",
    }
  },
  methods: {
    updatePhotoPosition() {
      this.$emit('updatePosition', {
        id: this.media.id,
        position: this.position,
      })
    },
    deleteMedia(mediaId) {
      this.$emit('deleteMedia', mediaId)
      this.$destroy()
      this.$el.parentNode.removeChild(this.$el)
    },
  },
}
</script>
