<template>
  <div class="col-6 col-md-4 col-lg-3 mb-3">
    <div class="border p-1">
      <div class="d-flex justify-content-between mb-1 text-sm">
        <span>{{ index }}
          <span>{{ index === 1 ? 'メイン画像' : 'サブ画像' }}</span>
          <span v-if="index < 7" class="text-danger text-xs">必須</span>
        </span>
        <span class="bg-light text-sm btn-delete-image text-center" @click="deleteMedia(media.id)">×</span>
      </div>
      <div class="mb-1"><img :src="media.url" class="w-100" style="height: 157px; object-fit: cover;" /></div>
      <select v-model="position" @change="updatePhotoPosition" class="select border border-gray rounded-none select-xs w-100 max-w-xs text-sm font-normal">
        <option disabled value="">選択してください</option>
        <option v-for="(value, key) in photoPosition" :value="key">{{ value }}</option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  name: "CarImageAdmin",
  props: {
    index: {
      type: String|Number,
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
      position: this.$props.media.photo_position ? this.$props.media.photo_position : "",
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
};
</script>
