<template>
  <div>
    <div v-if="url" class="border p-1">
      <div class="flex justify-between mb-1">
        <span class="text-xs"
          >{{ index }}
          <template v-if="index - 1 === 0">メイン画像</template>
          <template v-else>サブ画像</template>
          <span class="text-red-600">必須</span>
        </span>
        <span
          class="flex justify-center items-center bg-slate-200 rounded-full h-4 w-4 cursor-pointer text-sm"
          @click="deleteMedia(media.id)"
          >×</span
        >
      </div>
      <div class="mb-1"><img :src="url" class="h-32 w-full object-contain" /></div>
      <select
        v-model="position"
        class="select select-bordered rounded-none select-xs w-full max-w-xs"
        @change="updatePhotoPosition()"
      >
        <option disabled="" selected=""></option>
        <option v-for="position in photoPosition">{{ position }}</option>
      </select>
    </div>
    <div v-else class="border border-dashed">
      <div class="p-1 h-[192px] flex flex-col justify-center items-center">
        <input ref="file" type="file" class="h-0 w-0" @change="submitFile" />
        <div class="text-red-600">必須</div>
        <button v-if="!isHidden" class="btn btn-outline btn-sm rounded-none" @click.prevent="openUpload">
          画像を追加
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CarRequiredImageAdd',
  props: {
    index: {
      type: String | Number,
    },
    media: {
      type: [Object, Number],
    },
    photoPosition: {
      type: [Object, Array],
    },
  },
  data() {
    return {
      url: null,
      isHidden: false,
      position: '',
      mediaId: '',
    }
  },
  created() {
    this.url = this.$props.media.url
    this.position = this.$props.media.photo_position
    this.mediaId = this.$props.media.id ? this.$props.media.id : null
  },
  methods: {
    openUpload() {
      this.$refs.file.click()
    },
    updatePhotoPosition() {
      let formData = new FormData()
      formData.append('media_id', this.mediaId)
      formData.append('photo_position', this.position)
      this.$api
        .updatePhotoPosition(formData)
        .then(res => {
          console.log(res)
        })
        .catch(error => {})
    },
    deleteMedia(mediaId) {
      this.$emit('deleteMedia', mediaId)
      this.url = null
      this.position = null
      this.isHidden = false
    },
    submitFile(e) {
      const file = e.target.files[0]
      this.url = URL.createObjectURL(file)
      this.isHidden = true
      let formData = new FormData()
      for (let i = 0; i < this.$refs.file.files.length; i++) {
        let file = this.$refs.file.files[i]
        formData.append('files[' + i + ']', file)
        formData.append('is_required_image', 1)
      }
      this.$api
        .uploadMedia(formData)
        .then(res => {
          this.mediaId = res.data[0].id
          this.$emit('uploadDone', res.data)
        })
        .catch(error => {})
    },
  },
}
</script>
