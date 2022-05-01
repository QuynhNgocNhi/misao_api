<template>
  <div v-if="url" class="col-6 col-md-4 col-lg-3 mb-3">
    <div class="border p-1">
      <div class="d-flex justify-content-between mb-1">
        <span class="text-xs">{{ index }}
          <template v-if="index - 1 === 0">メイン画像</template>
          <template v-else>サブ画像</template>
          <span class="text-danger">必須</span>
        </span>
        <span class="bg-light rounded cursor-pointer text-sm" @click="deleteMedia(media.id)" style="cursor: pointer">×</span>
      </div>
      <div class="mb-1"><img :src="url" class="w-100" style="height: 157px; object-fit: cover" /></div>
      <select v-model="position" @change="updatePhotoPosition" class="select border border-gray rounded-none select-xs w-100 max-w-xs">
        <option disabled="" selected=""></option>
        <option v-for="position in photoPosition">{{ position }}</option>
      </select>
    </div>
  </div>
  <div v-else class="col-6 col-md-4 col-lg-3 mb-3">
    <div class="border p-5" style="height: 220px">
      <div class="d-flex flex-column justify-content-center align-self-center pt-md-4">
        <input ref="file" type="file" class="d-none" @change="submitFile" />
        <span class="text-danger text-center">必須</span>
        <button class="btn btn-outline-secondary btn-sm rounded" @click.prevent="openUpload">画像を追加</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CarRequiredImageAddAdmin',
  props: {
    index: {
      type: String|Number,
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
        .updatePhotoPositionAdmin(formData)
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
        .uploadMediaAdmin(formData)
        .then(res => {
          this.mediaId = res.data[0].id
          this.$emit('uploadDone', res.data)
        })
        .catch(error => {})
    },
  },
}
</script>
