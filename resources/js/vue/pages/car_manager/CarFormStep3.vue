<template>
  <div>
    <div class="bg-slate-700 lg:bg-slate-200 lg:py-4">
      <div class="container">
        <h2 class="p-2 lg:mb-3 text-white lg:text-slate-700 lg:text-2xl font-medium text-center">画像の更新</h2>
        <a :href="back" class="btn btn-md btn-outline-primary btn-icon px-16 hidden lg:inline-flex">
          戻る<i class="fa fa-arrow-left left-2.5 !right-auto"></i>
        </a>
      </div>
      <div class="text-center text-sm -mt-5">
        登録する画像（現在の枚数：{{ car.medias.length }}枚） 上限登録数：32枚
      </div>
    </div>
    <p v-if="hasError('media_active')" class="invalid text-sm text-gray-400 text-red-600 text-center mt-4">
      {{ showError('media_active') }}
    </p>
    <div class="pb-8 lg:container lg:py-8">
      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 p-4 lg:p-0">
        <CarImage
          v-for="(media, index) in car.medias"
          :key="media.id"
          :index="index + 1"
          :media="media"
          :photo-position="photoPosition"
          @deleteMedia="deleteMedia"
          @updatePosition="updatePosition"
        />
        <CarImageAdd @uploadDone="addMedia" @updateError="updateError" />
      </div>
      <div class="text-center mt-8">
        <button class="btn btn-primary btn-icon px-16" :disabled="loading" @click.prevent="submit">
          更新<i class="fa fa-arrow-right"></i>
        </button>
      </div>
    </div>
    <div class="bg-slate-200 py-4">
      <div class="container">
        <a :href="back" class="btn btn-md btn-outline-primary btn-icon px-16">
          戻る<i class="fa fa-arrow-left left-2.5 !right-auto"></i>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import vmodel from '../../mixins/vmodel'
import CarImage from './CarImage'
import CarImageAdd from './CarImageAdd'
import car_form from '../../mixins/car_form'

export default {
  name: 'CarFormStep3',
  components: { CarImageAdd, CarImage },
  mixins: [car_form, vmodel],
  props: ['back', 'photoPosition'],
  data() {
    return {}
  },
  methods: {
    addMedia(data) {
      this.car.medias = [].concat.apply(this.car.medias, data)
      this.updateMediaActive(this.car.medias)
    },
    deleteMedia(id) {
      this.car.medias = this.car.medias.filter(function (item) {
        return item.id !== id
      })
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
