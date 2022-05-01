<template>
  <form id="form-data" ref="formData">
    <CarFormStep1
      v-if="step == 1"
      :loading="loading"
      :back="back"
      :car="car"
      :check="check"
      :body-type="bodyType"
      :car-weight="carWeight"
      :manufacture="manufacture"
      :registration="registration"
      :registration-date="registrationDate"
      :gear="gear"
      :mirror="mirror"
      :provinces="provinces"
      :fuel="fuel"
      :tag="tag"
      :shock-absorber="shockAbsorber"
      @submit="submit($event)"
    />
    <CarFormStep2
      v-else-if="step == 2"
      :loading="loading"
      :back="back"
      :car="car"
      :check="check"
      :floor-material="floorMaterial"
      :joist-material="joistMaterial"
      :lashing-rail="lashingRail"
      :side-door-type="sideDoorType"
      :side-door-position="sideDoorPosition"
      :side-door-size="sideDoorSize"
      :freezer-temperature="freezerTemperature"
      :tail-lift="tailLift"
      :freezer-sub-engine="freezerSubEngine"
      :freezing-type="freezingType"
      :body-type="bodyType"
      @submit="submit($event)"
    />
    <CarFormStep3
      v-else-if="step == 3"
      :loading="loading"
      :back="back"
      :car="car"
      :check="check"
      :photo-position="photoPosition"
      @submit="submit($event)"
      @updateMediaActive="mediaActive = $event"
      @updateError="updateError"
    />
  </form>
</template>

<script>
import Toast from '../../../commons/notyf'
import CarFormStep1 from './CarFormStep1'
import CarFormStep2 from './CarFormStep2'
import CarFormStep3 from './CarFormStep3'

export default {
  components: { CarFormStep1, CarFormStep2, CarFormStep3 },
  provide() {
    return {
      getErrors: () => {
        return this.errors
      },
    }
  },
  props: {
    carData: {
      type: Object,
      default: {},
    },
    check: {
      type: [Object, Array],
      required: true,
    },
    bodyType: {
      type: [Object, Array],
      required: true,
    },
    carWeight: {
      type: [Object, Array],
      required: true,
    },
    manufacture: {
      type: [Object, Array],
      required: true,
    },
    gear: {
      type: [Object, Array],
      required: true,
    },
    mirror: {
      type: [Object, Array],
      required: true,
    },
    provinces: {
      type: [Object, Array],
      required: true,
    },
    fuel: {
      type: [Object, Array],
      required: true,
    },
    registration: {
      type: [Object, Array],
      required: true,
    },
    floorMaterial: {
      type: [Object, Array],
      required: true,
    },
    joistMaterial: {
      type: [Object, Array],
      required: true,
    },
    lashingRail: {
      type: [Object, Array],
      required: true,
    },
    sideDoorType: {
      type: [Object, Array],
      required: true,
    },
    sideDoorPosition: {
      type: [Object, Array],
      required: true,
    },
    tailLift: {
      type: [Object, Array],
      required: true,
    },
    freezerSubEngine: {
      type: [Object, Array],
      required: true,
    },
    tag: {
      type: [Object, Array],
      required: true,
    },
    photoPosition: {
      type: [Object, Array],
      required: true,
    },
    shockAbsorber: {
      type: [Object, Array],
      required: true,
    },
    freezingType: {
      type: [Object, Array],
      required: true,
    },
    back: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      step: 1,
      car: {
        medias: [],
      },
      registrationDate: {
        year: '',
        month: '',
        day: '',
      },
      freezerTemperature: {
        one: '',
        two: '',
        three: '',
      },
      sideDoorSize: [
        {
          position: '',
          width: '',
          height: '',
        },
        {
          position: '',
          width: '',
          height: '',
        },
      ],
      typeSubmit: null,
      typeForm: '',
      loading: false,
      errors: {},
      mediaActive: [],
    }
  },
  watch: {
    errors() {
      this.$nextTick(function () {
        const el = document.querySelector('p.invalid').parentNode.parentNode
        if (el) {
          el.scrollIntoView({ behavior: 'smooth' })
        }
      })
    },
  },
  created() {
    if (Object.keys(this.carData).length) {
      this.car = this.carData
      this.step = this.getStep()
      this.step = this.step ? this.step : 1
    }
    this.setMediaActive()
    this.detectFormType()
    this.setRegistrationDate()
    this.setFreezerTemperature()
    this.setSideDoorSize()
  },
  methods: {
    setMediaActive() {
      this.car.medias.forEach(media => {
        this.mediaActive.push({
          id: media.id,
          position: media.photo_position,
        })
      })
    },
    detectFormType() {
      let paths = location.pathname.split('/')
      this.typeForm = paths.pop() === 'create' ? 'create' : 'edit'
    },
    setRegistrationDate() {
      if (this.car.registration_date) {
        let date = this.car.registration_date.split('-')
        this.registrationDate.year = date[0]
        this.registrationDate.month = date[1] !== '' ? parseInt(date[1]) : date[1]
        this.registrationDate.day = date[2] !== '' ? parseInt(date[2]) : date[2]
      }
    },
    setFreezerTemperature() {
      if (!!!this.car.freezer_temperature) return
      this.freezerTemperature.one = this.car.freezer_temperature[0]
      this.freezerTemperature.two = this.car.freezer_temperature[1]
      this.freezerTemperature.three = this.car.freezer_temperature[2]
    },
    setSideDoorSize() {
      if (!!!this.car.side_door_size) return
      this.sideDoorSize[0].position = this.car.side_door_size[0].position
      this.sideDoorSize[0].width = this.car.side_door_size[0].width
      this.sideDoorSize[0].height = this.car.side_door_size[0].height

      this.sideDoorSize[1].position = this.car.side_door_size[1].position
      this.sideDoorSize[1].width = this.car.side_door_size[1].width
      this.sideDoorSize[1].height = this.car.side_door_size[1].height
    },
    submit() {
      let params = {
        ...this.car,
        freezer_temperature: Object.values(this.freezerTemperature),
        side_door_size: this.sideDoorSize,
        media_active: this.mediaActive,
        registration_date: this.formatRegistrationDate(),
        step: this.getStep(),
      }
      this.typeForm === 'create' ? this.store(params) : this.update(params)
    },
    store(params) {
      this.loading = true
      this.$api
        .storeCar(params)
        .then(res => {
          this.$nextTick(() => {
            this.$refs.formData.reset()
          })
          Toast.success(res.msg)
          setTimeout(function () {
            window.location = '/car-manager/detail/' + res.data.id
          }, 500)
        })
        .catch(error => {
          this.errors = error.data.errors
        })
        .finally(() => {
          this.loading = false
        })
    },
    update(params) {
      this.loading = true
      this.$api
        .updateCar(this.car.id, params)
        .then(res => {
          this.scrollToView('form-data')
          Toast.success(res.msg)
          this.errors = {}
        })
        .catch(error => {
          this.errors = error.data.errors
        })
        .finally(() => {
          this.loading = false
        })
    },
    scrollToView(dom) {
      const el = document.getElementById(dom)
      if (el) {
        el.scrollIntoView({ behavior: 'smooth' })
      }
    },
    formatRegistrationDate() {
      if (this.registrationDate.year || this.registrationDate.month || this.registrationDate.day) {
        return this.registrationDate.year + '-' + this.registrationDate.month + '-' + this.registrationDate.day
      }
      return null
    },
    getStep() {
      var url = new URL(window.location.href)
      return url.searchParams.get('step')
    },
    updateError($event) {
      console.log($event)
      this.errors = $event
    },
  },
}
</script>
