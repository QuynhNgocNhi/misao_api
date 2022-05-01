<template>
  <div>
    <div class="bg-slate-700 lg:bg-slate-200 lg:py-4">
      <div class="container">
        <h2 class="p-2 lg:mb-3 text-white lg:text-slate-700 lg:text-2xl font-medium text-center">
          {{ formIsEdit ? '基本情報の編集' : '基本情報の登録' }}
        </h2>
        <a :href="back" class="btn btn-md btn-outline-primary btn-icon px-16 hidden lg:inline-flex">
          戻る<i class="fa fa-arrow-left left-2.5 !right-auto"></i>
        </a>
      </div>
    </div>
    <div class="pb-8 lg:container lg:py-8">
      <base-input v-model="car.name" name="name" label="車両名" car-form required />
      <base-radio v-model="car.body_type_id" :items="bodyType" name="body_type_id" label="形状" car-form required />
      <div :class="wrapClass">
        <div :class="wrapLabelClass">サイズ</div>
        <div :class="wrapInputClass" class="py-1 px-3 lg:p-0">※トン数から自動設定されます</div>
      </div>
      <base-radio
        v-model="car.car_weight_id"
        car-form
        :items="carWeight"
        name="car_weight_id"
        label="トン数"
        required
      />
      <base-radio
        v-model="car.manufacture_id"
        car-form
        :items="manufacture"
        name="manufacture_id"
        label="メーカー"
        required
      />
      <div :class="wrapClass">
        <div :class="wrapLabelClass">
          年式<span class="bg-red-500 py-1 px-3 text-white text-xs mx-4 rounded lg:float-right">必須</span>
        </div>
        <div :class="wrapInputClass">
          <div class="inline-flex items-center">
            <base-select v-model="car.model_year_y" :items="year" name="model_year_y" wrap-class="w-full mr-3">
              <template #afterInput><span class="ml-2">年</span></template>
            </base-select>
            <base-select v-model="car.model_year_m" :items="month" name="model_year_m" wrap-class="w-full">
              <template #afterInput><span class="ml-2">月</span></template>
            </base-select>
          </div>
        </div>
      </div>
      <base-input
        v-model="car.km_used"
        car-form
        name="km_used"
        label="走行距離"
        input-local-class="w-6/12"
        required
        is-only-number
      >
        <template #afterInput>
          <div class="ml-2 inline-flex items-center whitespace-nowrap">
            <span class="mr-2">千km</span>
          </div>
        </template>
      </base-input>
<!--      <div :class="wrapClass">-->
<!--        <div :class="wrapLabelClass">走行距離帯</div>-->
<!--        <div :class="wrapInputClass" class="py-1 px-3 lg:p-0">※走行距離から自動設定されます</div>-->
<!--      </div>-->
      <base-radio v-model="car.gear_id" car-form :items="gear" name="gear_id" label="ミッション" required />
      <base-select
        v-model="car.stock_location_id"
        car-form
        :items="provinces"
        name="stock_location_id"
        label="在庫場所"
        input-local-class="w-6/12"
        required
      />
      <base-input
        v-model="car.price"
        required
        car-form
        name="price"
        label="価格"
        input-local-class="lg:w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2 whitespace-nowrap">円</span></template>
      </base-input>
      <base-input
        v-model="car.loan_payment"
        car-form
        name="loan_payment"
        label="ローン支払い額"
        input-local-class="lg:w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2 whitespace-nowrap">円 / 月</span></template>
      </base-input>
      <base-input
        v-model="car.max_weight"
        car-form
        name="max_weight"
        label="最大積載量"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput>
          <div class="ml-2 inline-flex items-center whitespace-nowrap">
            <span class="mr-2">kg</span>
            <div class="cursor-pointer label">
              <input
                id="max_weight"
                v-model="car.has_scale_measured"
                class="checkbox checkbox-sm mr-1"
                type="checkbox"
              />
              <label class="label-text" for="max_weight">台貫計測済</label>
            </div>
          </div>
        </template>
      </base-input>
      <base-input
        v-model="car.total_weight"
        car-form
        name="total_weight"
        label="車両総重量"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">kg</span></template>
      </base-input>

      <div :class="wrapClass">
        <div :class="wrapLabelClass">車検日</div>
        <div :class="wrapInputClass">
          <base-radio
            v-model="car.registration_id"
            :items="registration"
            name="registration_id"
            wrap-class="w-full mb-3"
          />
          <div class="inline-flex items-center">
            <base-select
              :key="registrationDate.year + '年'"
              v-model="registrationDate.year"
              :items="year"
              wrap-class="w-full mr-3"
            >
              <template #afterInput><span class="ml-2">年</span></template>
            </base-select>
            <base-select
              :key="registrationDate.month + '月'"
              v-model="registrationDate.month"
              :items="month"
              wrap-class="w-full mr-3"
            >
              <template #afterInput><span class="ml-2">月</span></template>
            </base-select>
            <base-select
              :key="registrationDate.day + '日'"
              v-model="registrationDate.day"
              :items="day"
              wrap-class="w-full"
            >
              <template #afterInput><span class="ml-2">日</span></template>
            </base-select>
          </div>
          <div @click.prevent="clearRegistrationDate()" class="btn btn-sm btn-outline-primary md:ml-6 ml-3 my-3 md:my-0">クリア</div>
          <p v-if="hasError('registration_date')" class="invalid text-sm text-gray-400 text-red-600">
            {{ showError('registration_date') }}
          </p>
        </div>
      </div>
      <base-input v-model="car.model_car" car-form name="model_car" label="型式" input-local-class="w-6/12" />
      <base-input
        v-model="car.chassis_number"
        car-form
        name="chassis_number"
        label="車台番号"
        input-local-class="w-6/12"
      />
      <base-radio v-model="car.has_tail_lift" car-form :items="check" name="has_tail_lift" label="パワーゲート" />
      <base-radio v-model="car.has_high_roof" car-form :items="check" name="has_high_roof" label="ハイルーフ" />
      <base-radio v-model="car.has_bed" car-form :items="check" name="has_bed" label="ベッド" />
      <base-input
        v-model="car.capacity"
        car-form
        name="capacity"
        label="定員"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">人</span></template>
      </base-input>
      <base-input
        v-model="car.model_engine"
        car-form
        name="model_engine"
        label="エンジン型式"
        input-local-class="w-6/12"
      />
      <base-input
        v-model="car.horsepower"
        car-form
        name="horsepower"
        label="馬力"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">PS</span></template>
      </base-input>
      <base-radio v-model="car.has_turbo" car-form :items="check" name="has_turbo" label="ターボ" />
      <base-radio v-model="car.has_4wd" car-form :items="check" name="has_4wd" label="4WD" />
      <base-checkbox v-model="car.mirror" car-form :items="mirror" name="mirror" label="ミラー" />
      <div :class="wrapClass">
        <div :class="wrapLabelClass">タンク容量</div>
        <div :class="wrapInputClass">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <base-input
              v-model="car.tank_capacity_main"
              name="tank_capacity_main"
              wrap-class="w-auto"
              input-local-class="w-auto"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 whitespace-nowrap">メイン</span></template>
              <template #afterInput><span class="ml-2">L</span></template>
            </base-input>
            <base-input
              v-model="car.tank_capacity_sub"
              name="tank_capacity_sub"
              wrap-class="w-auto"
              input-local-class="w-auto"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 whitespace-nowrap">サブ</span></template>
              <template #afterInput><span class="ml-2">L</span></template>
            </base-input>
          </div>
        </div>
      </div>
      <base-radio
        v-model="car.has_shock_absorber"
        car-form
        :items="shockAbsorber"
        name="has_shock_absorber"
        label="サスペンション"
      />
      <base-radio v-model="car.has_tachograph" car-form :items="check" name="has_tachograph" label="タコグラフ" />
      <base-radio v-model="car.has_etc" car-form :items="check" name="has_etc" label="ETC" />
      <base-radio
        v-model="car.has_back_monitor"
        car-form
        :items="check"
        name="has_back_monitor"
        label="バックモニター"
      />
      <base-radio v-model="car.has_adblue" car-form :items="check" name="has_adblue" label="アドブルー" />
      <base-radio v-model="car.fuel_id" car-form :items="fuel" name="fuel_id" label="燃料" />
      <base-checkbox
        v-model="car.tag"
        car-form
        :items="tag"
        name="tag"
        label="タグ"
        help="最大で3個まで選択できます。"
      />
      <base-textarea v-model="car.fuel_description" car-form name="fuel_description" label="備考" />
      <base-textarea v-model="car.management_note" car-form name="management_note" label="管理用備考" />
      <div class="text-center mt-4 lg:mt-8">
        <button class="btn btn-primary btn-icon px-16" :disabled="loading" @click.prevent="submit">
          {{ formIsEdit ? '更新' : '追加' }}
          <i class="fa fa-arrow-right"></i>
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
import car_form from '../../mixins/car_form'

export default {
  name: 'CarFormStep1',
  mixins: [car_form, vmodel],
  props: [
    'back',
    'bodyType',
    'carWeight',
    'manufacture',
    'registration',
    'registrationDate',
    'gear',
    'mirror',
    'provinces',
    'fuel',
    'tag',
    'shockAbsorber',
  ],
  computed: {
    month() {
      var months = {}
      for (var i = 1; i <= 12; i++) {
        months[i] = i.toString().padStart(2, '0')
      }
      return months
    },
    day() {
      var day = {}
      for (var i = 1; i <= 31; i++) {
        day[i] = i.toString().padStart(2, '0')
      }
      return day
    },
    formIsEdit() {
      return window.location.href.includes('edit')
    },
  },
  methods: {
    clearRegistrationDate() {
      this.registrationDate.year = ''
      this.registrationDate.month = ''
      this.registrationDate.day = ''
    },
  },
}
</script>
