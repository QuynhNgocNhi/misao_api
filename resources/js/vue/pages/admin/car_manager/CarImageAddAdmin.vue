<template>
  <div class="col-6 col-md-4 col-lg-3">
    <div class="border p-5" style="height: 220px">
      <div class="d-flex justify-content-center align-self-center pt-md-5">
        <input ref="file" type="file" multiple="multiple" class="d-none" @change="submitFile" />
        <button class="btn btn-outline-secondary btn-sm rounded" @click.prevent="openUpload">画像を追加</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CarImageAddAdmin',
  data() {
    return {
      media: null,
    }
  },
  methods: {
    openUpload() {
      this.$refs.file.click()
    },
    submitFile() {
      let formData = new FormData()
      for (let i = 0; i < this.$refs.file.files.length; i++) {
        let file = this.$refs.file.files[i]
        formData.append('files[' + i + ']', file)
      }
      this.$api
        .uploadMediaAdmin(formData)
        .then(res => {
          this.$emit('uploadDone', res.data)
          formData.append('is_required_image', 0)
        })
        .catch(error => {
          this.$emit('updateError', {
            media_active: error.data.errors[Object.keys(error.data.errors)[0]],
          })
        })
    },
  },
}
</script>
