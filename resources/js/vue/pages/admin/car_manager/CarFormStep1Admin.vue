<template>
  <div>
    <div class="bg-slate-700 lg:bg-slate-200 lg:py-4">
      <div class="container">
        <h2 class="p-4 font-weight-bold crud-label text-center">
          <template v-if="getCurrentRoute().includes('edit')">基本情報の編集</template>
          <template v-else>基本情報の登録</template>
        </h2>
      </div>
    </div>
    <div class="m-4">
      <base-input-admin is-only-number v-model="car.user_id" name="user_id" label="会員ID" required />
      <base-input-admin v-model="car.name" name="name" label="車両名" required />
      <base-radio-admin v-model="car.body_type_id" :items="bodyType" name="body_type_id" label="形状" required />
      <div :class="wrapClass">
        <div :class="wrapLabelClass">サイズ</div>
        <div :class="wrapInputClass" class="py-1 px-3 lg:p-0 label-input">※トン数から自動設定されます</div>
      </div>
      <base-radio-admin v-model="car.car_weight_id" :items="carWeight" name="car_weight_id" label="トン数" required />
      <base-radio-admin
        v-model="car.manufacture_id"
        :items="manufacture"
        name="manufacture_id"
        label="メーカー"
        required
      />
      <div :class="wrapClass">
        <div :class="wrapLabelClass">
          年式<span class="bg-danger ml-2 py-1 px-3 text-white text-xs rounded float-lg-right">必須</span>
        </div>
        <div :class="wrapInputClass" class="px-3">
          <div class="row pl-2">
            <base-select-admin
              v-model="car.model_year_y"
              :items="year"
              name="model_year_y"
              wrap-class="col-6 col-lg-2 mr-lg-3"
              wrap-select-class="row"
              wrap-label-class="px-3 pb-2 p-lg-0"
              wrap-input-class=""
              input-local-class="col-9 col-md-10"
            >
              <template #afterInput><span class="col-2 mt-2">年</span></template>
            </base-select-admin>
            <base-select-admin
              v-model="car.model_year_m"
              :items="month"
              name="model_year_m"
              wrap-class="col-6 col-lg-2"
              wrap-select-class="row"
              input-local-class="col-9 col-md-10"
            >
              <template #afterInput><span class="col-2 mt-2">月</span></template>
            </base-select-admin>
          </div>
        </div>
      </div>
      <base-input-admin
        v-model="car.km_used"
        name="km_used"
        label="走行距離"
        input-local-class="col-7 col-md-4"
        required
        is-only-number
      >
        <template #afterInput>
          <div class="ml-lg-2 flex mt-2">
            <div class="align-items-center">
              <span class="ml-2 ml-md-0 mt-2">千km</span>
<!--              <input id="km" v-model="car.is_unknown_distance" class="checkbox d-inline mr-1" type="checkbox" />-->
<!--              <label class="label-text" d-inline for="km">距離不明</label>-->
            </div>
          </div>
        </template>
      </base-input-admin>
<!--      <div :class="wrapClass">-->
<!--        <div :class="wrapLabelClass">走行距離帯</div>-->
<!--        <div :class="wrapInputClass" class="py-1 px-3 lg:p-0">※走行距離から自動設定されます</div>-->
<!--      </div>-->
      <base-radio-admin v-model="car.gear_id" :items="gear" name="gear_id" label="ミッション" required />
      <base-select-admin
        v-model="car.stock_location_id"
        :items="provinces"
        name="stock_location_id"
        label="在庫場所"
        wrap-label-class="col-12 col-md-3 px-3 pb-2 p-lg-3 label-input pb-md-2 d-flex align-items-center justify-content-between py-3 border bg-light"
        wrap-input-class="col-12 col-md-9 px-3 py-3 border"
        input-local-class="form-control"
        required
      />
      <base-input-admin
        v-model="car.price"
        name="price"
        label="価格"
        input-local-class="col-10 col-md-4"
        is-only-number
        required
      >
        <template #afterInput><span class="ml-2 mt-2">円</span></template>
      </base-input-admin>
      <base-input-admin
        v-model="car.loan_payment"
        name="loan_payment"
        label="ローン支払い額"
        input-local-class="col-10 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">円 / 月</span></template>
      </base-input-admin>
      <base-input-admin
        v-model="car.max_weight"
        name="max_weight"
        label="最大積載量"
        input-local-class="col-7 col-md-4"
        is-only-number
      >
        <template #afterInput>
          <div class="ml-lg-2 flex mt-2">
            <div class="align-items-center">
              <span class="mr-2">kg</span>
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
      </base-input-admin>
      <base-input-admin
        v-model="car.total_weight"
        name="total_weight"
        label="車両総重量"
        input-local-class="col-11 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">kg</span></template>
      </base-input-admin>
      <base-radio-admin
        v-model="car.registration_id"
        :items="registration"
        name="registration_id"
        label="車検日"
        wrap-class="row"
        wrap-label-class="py-1 border-left border-right col-12 col-md-3 px-3 pb-2 p-lg-3 label-input pb-md-2 d-flex align-items-center justify-content-between py-3 bg-light"
        wrap-input-class="py-1 px-3 col-12 col-md-9 py-3 border-left border-right"
      />
      <div :class="wrapClass">
        <div class="col-12 col-md-3 px-3 p-lg-3 py-lg-2 pb-md-2 bg-light border-left border-right"></div>
        <div class="px-3 col-12 col-md-9 pb-3 border-left border-right">
          <div class="row pl-2">
            <base-select-admin
              :key="registrationDate.year + '年'"
              v-model="registrationDate.year"
              :items="year"
              wrap-class="col-4 col-lg-2 mr-lg-3"
              wrap-select-class="row"
              input-local-class="col-9 col-md-10"
            >
              <template #afterInput><span class="col-2 mt-2">年</span></template>
            </base-select-admin>
            <base-select-admin
              :key="registrationDate.month + '月'"
              v-model="registrationDate.month"
              :items="month"
              wrap-class="col-4 col-lg-2 mr-lg-3"
              wrap-select-class="row"
              input-local-class="col-9 col-md-10"
            >
              <template #afterInput><span class="col-2 mt-2">月</span></template>
            </base-select-admin>
            <base-select-admin
              :key="registrationDate.day + '日'"
              v-model="registrationDate.day"
              :items="day"
              wrap-class="col-4 col-lg-2"
              wrap-select-class="row"
              input-local-class="col-9 col-md-10"
            >
              <template #afterInput><span class="col-2 mt-2">日</span></template>
            </base-select-admin>
            <div @click.prevent="clearRegistrationDate()" class="ml-md-2 ml-0 mt-2 mt-md-0 btn btn-sm btn-primary pt-2">
              クリア
            </div>
            <p v-if="hasError('registration_date')" class="text-danger col-12 mt-2">
              {{ showError('registration_date') }}
            </p>
          </div>
        </div>
      </div>

      <base-input-admin v-model="car.model_car" name="model_car" label="型式" />
      <base-input-admin v-model="car.chassis_number" name="chassis_number" label="車台番号" />
      <base-radio-admin v-model="car.has_tail_lift" :items="check" name="has_tail_lift" label="パワーゲート" />
      <base-radio-admin v-model="car.has_high_roof" :items="check" name="has_high_roof" label="ハイルーフ" />
      <base-radio-admin v-model="car.has_bed" :items="check" name="has_bed" label="ベッド" />
      <base-input-admin v-model="car.capacity" name="capacity" label="定員" input-local-class="col-11 col-md-4">
        <template #afterInput><span class="ml-2 mt-2">人</span></template>
      </base-input-admin>
      <base-input-admin v-model="car.model_engine" name="model_engine" label="エンジン型式" />
      <base-input-admin
        v-model="car.horsepower"
        name="horsepower"
        label="馬力"
        input-local-class="col-11 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">PS</span></template>
      </base-input-admin>
      <base-radio-admin v-model="car.has_turbo" :items="check" name="has_turbo" label="ターボ" />
      <base-radio-admin v-model="car.has_4wd" :items="check" name="has_4wd" label="4WD" />
      <base-checkbox-admin v-model="car.mirror" :items="mirror" name="mirror" label="ミラー" />
      <div :class="wrapClass">
        <div :class="wrapLabelClass" class="">タンク容量</div>
        <div class="row col-md-9 px-3 py-3 border m-0">
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.tank_capacity_main"
              name="tank_capacity_main"
              wrap-input-class="col-12"
              input-local-class="col-8 ml-n3"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-3 mb-3 mb-lg-0">メイン</span></template>
              <template #afterInput><span class="ml-2 mt-2 col-1">L</span></template>
            </base-input-admin>
          </div>
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.tank_capacity_sub"
              name="tank_capacity_sub"
              wrap-class="ml-lg-5"
              wrap-input-class="p-0"
              input-local-class="col-8 ml-n3"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-3">サブ</span></template>
              <template #afterInput><span class="ml-2 mt-2 col-1">L</span></template>
            </base-input-admin>
          </div>
        </div>
      </div>
      <base-radio-admin
        v-model="car.has_shock_absorber"
        :items="shockAbsorber"
        name="has_shock_absorber"
        label="サスペンション"
      />
      <base-radio-admin v-model="car.has_tachograph" :items="check" name="has_tachograph" label="タコグラフ" />
      <base-radio-admin v-model="car.has_etc" :items="check" name="has_etc" label="ETC" />
      <base-radio-admin v-model="car.has_back_monitor" :items="check" name="has_back_monitor" label="バックモニター" />
      <base-radio-admin v-model="car.has_adblue" :items="check" name="has_adblue" label="アドブルー" />
      <base-radio-admin v-model="car.fuel_id" :items="fuel" name="fuel_id" label="燃料" />
      <base-checkbox-admin v-model="car.tag" :items="tag" name="tag" label="タグ" help="最大で3個まで選択できます。"/>
      <base-textarea-admin v-model="car.fuel_description" name="fuel_description" label="備考" />
      <base-textarea-admin v-model="car.management_note" name="management_note" label="管理用備考" />
      <div class="text-center my-4">
        <button class="btn btn-primary btn-icon" :disabled="loading" @click.prevent="submit">
          <span class="px-5"> 更新</span>
          <i class="fa fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import vmodel from '../../../mixins/vmodel'
import car_form from '../../../mixins/car_form_admin'

export default {
  name: 'CarFormStep1Admin',
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
  methods: {
    getCurrentRoute() {
      return window.location.href
    },
    clearRegistrationDate() {
      this.registrationDate.year = ''
      this.registrationDate.month = ''
      this.registrationDate.day = ''
    },
  },
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
  },
}
</script>
