<template>
  <div class="border border-dashed p-1 h-[192px] flex justify-center items-center relative">
    <input ref="file" type="file" multiple="multiple" class="h-0 w-0" @change="submitFile" />
    <button class="btn btn-outline btn-sm rounded-none" @click.prevent="openUpload">画像を追加</button>
    <div v-if="loading" class="absolute opacity-70"><img src="/images/default/loading.gif" /></div>
  </div>
</template>

<script>
export default {
  name: 'CarImageAdd',
  data() {
    return {
      media: null,
      loading: false,
    }
  },
  methods: {
    openUpload() {
      this.$refs.file.click()
    },
    submitFile() {
      this.loading = true
      let formData = new FormData()
      for (let i = 0; i < this.$refs.file.files.length; i++) {
        let file = this.$refs.file.files[i]
        formData.append('files[' + i + ']', file)
      }
      this.$api
        .uploadMedia(formData)
        .then(res => {
          this.$emit('uploadDone', res.data)
          this.$emit('updateError', {
            media_active: {},
          })
        })
        .catch(error => {
          this.$emit('updateError', {
            media_active: error.data.errors[Object.keys(error.data.errors)[0]],
          })
        })
        .finally(() => {
          this.loading = false
        })
    },
  },
}
</script>
