<template>
  <div>
    <div class="bg-slate-700 lg:bg-slate-200 lg:py-4">
      <div class="container">
        <h2 class="p-4 font-weight-bold crud-label text-center">画像の更新</h2>
      </div>
      <div class="text-center text-sm mt-n3">
        登録する画像（現在の枚数：{{ car.medias.length }}枚） 上限登録数：32枚
      </div>
    </div>
    <p v-if="hasError('media_active')" class="text-danger text-center mt-4">{{ showError('media_active') }}</p>
    <div class="pb-8 container lg:py-8">
      <div class="row p-md-3">
        <CarImageAdmin
          v-for="(media, index) in car.medias"
          :key="media.id"
          :index="index + 1"
          :media="media"
          :photo-position="photoPosition"
          @deleteMedia="deleteMedia"
          @updatePosition="updatePosition"
        />
        <CarImageAddAdmin @uploadDone="addMedia" @updateError="updateError"/>
      </div>
      <div class="text-center my-4">
        <button class="btn btn-primary btn-icon px-16" :disabled="loading" @click.prevent="submit">
          <span class="px-5"> 更新</span>
          <i class="fa fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import vmodel from '../../../mixins/vmodel'
import CarImageAdmin from './CarImageAdmin'
import CarImageAddAdmin from './CarImageAddAdmin'
import car_form from '../../../mixins/car_form_admin'

export default {
  name: 'CarFormStep3',
  components: { CarImageAdmin, CarImageAddAdmin },
  mixins: [car_form, vmodel],
  props: ['back', 'mediaActive', 'photoPosition'],
  data() {
    return {}
  },
  methods: {
    addMedia(data) {
      this.car.medias = [].concat.apply(this.car.medias, data)
      this.updateMediaActive(this.car.medias)
    },
    updatePosition(data) {
      this.car.medias = this.car.medias.map(function (item) {
        if (item.id === data.id) {
          item.photo_position = data.position
        }
        return item
      })
      this.updateMediaActive(this.car.medias)
    },
    deleteMedia(id) {
      const index = this.mediaActive.indexOf(id)
      if (index > -1) {
        this.mediaActive.splice(index, 1)
      }
    },
    updateMediaActive(medias) {
      let data = []
      medias.forEach(function (item) {
        data.push({
          id: item.id,
          position: item.photo_position,
        })
      })
      this.$emit('updateMediaActive', data)
    },
    updateError($event) {
      this.$emit('updateError', $event)
    },
  },
}
</script>
