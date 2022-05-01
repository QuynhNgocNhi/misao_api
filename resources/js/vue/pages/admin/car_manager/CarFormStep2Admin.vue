<template>
  <div>
    <div class="bg-slate-700 lg:bg-slate-200 lg:py-4">
      <div class="container">
        <h2 class="p-4 font-weight-bold crud-label text-center">ボディー情報の更新</h2>
      </div>
    </div>
    <div class="container px-lg-4">
      <div :class="wrapClass">
        <div :class="wrapLabelClass" class="">外寸</div>
        <div class="row col-md-9 border m-0 py-3">
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.outside_size_length"
              name="outside_size_length"
              wrap-input-class="col-12"
              input-local-class="col-8"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-2">長さ</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.outside_size_width"
              name="outside_size_width"
              wrap-class="ml-lg-5 my-3 my-lg-0 pl-1"
              wrap-input-class="col-12 p-0"
              input-local-class="col-8"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-2">幅</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.outside_size_height"
              name="outside_size_height"
              wrap-class=""
              wrap-input-class="col-12 p-0 mt-lg-3"
              input-local-class="col-8"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-2">高さ</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
        </div>
      </div>
      <div :class="wrapClass">
        <div :class="wrapLabelClass" class="">内寸</div>
        <div class="row col-md-9 border m-0 py-3">
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.inside_size_length"
              name="inside_size_length"
              wrap-input-class="col-12"
              input-local-class="col-8"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-2">長さ</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.inside_size_width"
              name="inside_size_width"
              wrap-class="ml-lg-5 my-3 my-lg-0 pl-1"
              wrap-input-class="col-12 p-0"
              input-local-class="col-8"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-2">幅</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.inside_size_height"
              name="inside_size_height"
              wrap-class=""
              wrap-input-class="col-12 p-0 mt-lg-3"
              input-local-class="col-8"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-2">高さ</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
        </div>
      </div>
      <base-radio-admin v-model="car.floor_material_id" :items="floorMaterial" name="floor_material_id" label="床素材" />
      <base-radio-admin v-model="car.joist_material_id" :items="joistMaterial" name="joist_material_id" label="根太素材" />
      <base-radio-admin v-model="car.has_built_in_body" :items="check" name="has_built_in_body" label="造りボディ" />
      <base-radio-admin v-model="car.lashing_rail_id" :items="lashingRail" name="lashing_rail_id" label="ラッシングレール" />
      <div :class="wrapClass">
        <div :class="wrapLabelClass" class="">門口サイズ</div>
        <div class="row col-md-9 py-3 border m-0">
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.gate_width"
              name="gate_width"
              wrap-input-class="col-12"
              input-local-class="col-8 ml-n3"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-3">幅</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
          <div class="col-12 col-md-6">
            <base-input-admin
              v-model="car.gate_height"
              name="gate_height"
              wrap-class="ml-lg-5 mt-3 mt-lg-0"
              wrap-input-class="col-12 p-0"
              input-local-class="col-8 ml-n3"
              is-only-number
            >
              <template #beforeInput><span class="mr-2 mt-2 col-3">高さ</span></template>
              <template #afterInput><span class="ml-2 mt-2">cm</span></template>
            </base-input-admin>
          </div>
        </div>
      </div>
      <base-input-admin
        v-model="car.inner_hook"
        name="inner_hook"
        label="内フック"
        input-local-class="col-10 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">対</span></template>
      </base-input-admin>
      <base-input-admin
        v-model="car.joroder_groove"
        name="joroder_groove"
        label="ジョロダー溝"
        input-local-class="col-10 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">対</span></template>
      </base-input-admin>
      <base-input-admin
        v-model="car.pallet_roller"
        name="pallet_roller"
        label="パレットローラー"
        input-local-class="col-10 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">対</span></template>
      </base-input-admin>
      <base-radio-admin v-model="car.has_side_door" :items="check" name="has_side_door" label="サイド扉" />
      <base-radio-admin
        v-model="car.side_door_type_id"
        :items="sideDoorType"
        name="side_door_type_id"
        label="サイド扉タイプ"
        wrap-class="row"
        wrap-label-class="col-12 col-md-3 px-3 pb-2 p-lg-3 label-input pb-md-2 d-flex align-items-center justify-content-between py-3 border bg-light"
        wrap-input-class="py-1 px-3 col-12 col-md-9 py-3 border"
      />
<!--      <div class="row border-right">-->
<!--        <div class="col-12 col-md-3 px-3 pb-2 p-lg-3 label-input pb-md-2 d-flex align-items-center justify-content-between py-3 border-left border-right bg-light border-sm-bottom">-->
<!--          サイド扉サイズ-->
<!--        </div>-->
<!--        <div class="row col-md-9 px-3 pt-3">-->
<!--          <div class="col-12 col-md-6">-->
<!--            <base-input-admin-->
<!--              v-model="sideDoorSize[0].width"-->
<!--              name="side_door_size[0][width]"-->
<!--              wrap-class="row mb-3"-->
<!--              wrap-input-class="col-12"-->
<!--              input-local-class="col-8 ml-n3"-->
<!--              is-only-number-->
<!--            >-->
<!--              <template #beforeInput><span class="mr-2 mt-2 col-3">高さ</span></template>-->
<!--              <template #afterInput><span class="ml-2 mt-2">cm</span></template>-->
<!--            </base-input-admin>-->
<!--          </div>-->
<!--          <div class="col-12 col-md-6">-->
<!--            <base-input-admin-->
<!--              v-model="sideDoorSize[0].height"-->
<!--              name="side_door_size[0][height]"-->
<!--              wrap-class="ml-lg-5 mb-3 mb-md-0"-->
<!--              wrap-input-class="col-12 p-0"-->
<!--              input-local-class="col-8 ml-n3"-->
<!--              wrap-label-class="col-12 col-md-3 px-3 p-lg-3 py-lg-2 pb-md-2 border-left border-right bg-light"-->
<!--              is-only-number-->
<!--            >-->
<!--              <template #beforeInput><span class="mr-2 mt-2 col-3">幅</span></template>-->
<!--              <template #afterInput><span class="ml-2 mt-2">cm</span></template>-->
<!--            </base-input-admin>-->
<!--          </div>-->
<!--          <div class="col-12 col-md-6">-->
<!--            <base-radio-admin-->
<!--              v-model="sideDoorSize[1].position"-->
<!--              :items="sideDoorPosition"-->
<!--              wrap-class="row mb-1"-->
<!--              name="side_door_size[1][position]"-->
<!--              wrap-input-class="col-12"-->
<!--            />-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="row border-right">-->
<!--        <div class="col-12 col-md-3 px-3 p-lg-3 py-lg-2 pb-md-2 border-left border-right bg-light"></div>-->
<!--        <div class="row col-md-9 px-3 pb-3 pb-md-0">-->
<!--          <div class="col-12 col-md-6">-->
<!--            <base-input-admin-->
<!--              v-model="sideDoorSize[1].width"-->
<!--              name="side_door_size[1][width]"-->
<!--              wrap-class="row mb-3"-->
<!--              wrap-input-class="col-12"-->
<!--              input-local-class="col-8 ml-n3"-->
<!--              is-only-number-->
<!--            >-->
<!--              <template #beforeInput><span class="mr-2 mt-2 col-3">幅</span></template>-->
<!--              <template #afterInput><span class="ml-2 mt-2">cm</span></template>-->
<!--            </base-input-admin>-->
<!--          </div>-->
<!--          <div class="col-12 col-md-6">-->
<!--            <base-input-admin-->
<!--              v-model="sideDoorSize[1].height"-->
<!--              name="tank_capacity_sub"-->
<!--              wrap-class="ml-lg-5"-->
<!--              wrap-input-class="col-12 p-0"-->
<!--              input-local-class="col-8 ml-n3"-->
<!--              is-only-number-->
<!--            >-->
<!--              <template #beforeInput><span class="mr-2 mt-2 col-3">高さ</span></template>-->
<!--              <template #afterInput><span class="ml-2 mt-2">cm</span></template>-->
<!--            </base-input-admin>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
      <base-input-admin
        v-model="car.stance"
        name="stance"
        label="スタンション"
        input-local-class="col-10 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">対</span></template>
      </base-input-admin>
      <base-input-admin
        v-model="car.aori_material"
        name="aori_material"
        label="アオリ素材"
        input-local-class="col-12 col-md-7"
        is-only-number
      >
      </base-input-admin>
      <base-input-admin
        v-model="car.aori_height"
        name="aori_height"
        label="アオリ高さ"
        input-local-class="col-10 col-md-4"
        is-only-number
      >
        <template #afterInput><span class="ml-2 mt-2">cm</span></template>
      </base-input-admin>
      <div :class="wrapClass">
        <div :class="wrapLabelClass" class="">床面地上高</div>
        <div class="row col-md-9 py-3 border m-0">
          <base-input-admin
            v-model="car.floor_clearance_previous"
            name="floor_clearance_previous"
            wrap-input-class="col-12"
            input-local-class="col-9 ml-n3"
            is-only-number
          >
            <template #beforeInput><span class="mr-2 mt-2 col-2">前</span></template>
            <template #afterInput><span class="ml-2 mt-2">cm</span></template>
          </base-input-admin>
          <base-input-admin
            v-model="car.floor_clearance_rear"
            name="floor_clearance_rear"
            wrap-class="ml-lg-5 mt-3 mt-lg-0"
            wrap-input-class="col-12 p-0"
            input-local-class="col-9 ml-n3"
            is-only-number
          >
            <template #beforeInput><span class="mr-2 mt-2 col-2">後</span></template>
            <template #afterInput><span class="ml-2 mt-2">cm</span></template>
          </base-input-admin>
        </div>
      </div>
      <base-textarea-admin v-model="car.floor_clearance_description" name="floor_clearance_description" label="備考" />
      <div v-show="car.has_tail_lift == true">
        <base-input-admin
          v-model="car.manufacture_tail_lift"
          name="manufacture_tail_lift"
          label="パワーゲートメーカー"
          input-local-class="col-12 col-md-7"
        />
        <base-radio-admin v-model="car.tail_lift_id" :items="tailLift" name="tail_lift_id" label="パワーゲート仕様" />
        <div :class="wrapClass">
          <div :class="wrapLabelClass" class="">パワーゲートサイズ</div>
          <div class="row col-md-9 py-3 border m-0">
            <div class="col-12 col-md-6">
              <base-input-admin
                v-model="car.tail_lift_width"
                name="tail_lift_width"
                wrap-input-class="col-12"
                input-local-class="col-8 ml-n3"
                is-only-number
              >
                <template #beforeInput><span class="mr-2 mt-2 col-3">幅</span></template>
                <template #afterInput><span class="ml-2 mt-2">cm</span></template>
              </base-input-admin>
            </div>
            <div class="col-12 col-md-6">
              <base-input-admin
                v-model="car.tail_lift_height"
                name="tail_lift_height"
                wrap-class="ml-lg-5 mt-3 mt-lg-0"
                wrap-input-class="col-12 p-0"
                input-local-class="col-8 ml-n3"
                is-only-number
              >
                <template #beforeInput><span class="mr-2 mt-2 col-3">長さ</span></template>
                <template #afterInput><span class="ml-2 mt-2">cm</span></template>
              </base-input-admin>
            </div>
          </div>
        </div>
        <base-textarea-admin v-model="car.tail_lift_description" name="tail_lift_description" label="パワーゲート備考" />
      </div>
      <div v-show="bodyType[car.body_type_id].includes('冷凍')">
        <base-input-admin v-model="car.manufacturer_freezer" name="manufacturer_freezer" label="冷凍機メーカー" />
        <div :class="wrapClass">
          <div :class="wrapLabelClass">冷凍機ボデー年式</div>
          <div :class="wrapInputClass" class="px-3">
            <div class="row pl-2">
              <base-select-admin
                v-model="car.body_year"
                :items="year"
                wrap-class="col-4 col-lg-2 mr-lg-3"
                wrap-select-class="row"
                input-local-class="col-9 col-md-10"
                name="body_year"
              >
                <template #afterInput><span class="col-2 mt-2">年</span></template>
              </base-select-admin>
            </div>
          </div>
        </div>
        <base-radio-admin v-model="car.freezing_type" :items="freezingType" name="freezing_type" label="冷凍機タイプ" />
<!--        <div :class="wrapClass">-->
<!--          <div :class="wrapLabelClass">冷凍機温度</div>-->
<!--          <div :class="wrapInputClass">-->
<!--            <div class="row">-->
<!--              <base-input-admin-->
<!--                v-model="freezerTemperature.one"-->
<!--                name="freezer_temperature_1"-->
<!--                wrap-class="col-12 col-md-8"-->
<!--                wrap-input-class="w-auto"-->
<!--                input-local-class="w-auto"-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-2 mt-2">冷凍機計測</span></template>-->
<!--                <template #afterInput><span class="ml-2 mt-2">時間実稼働で庫内</span></template>-->
<!--              </base-input-admin>-->
<!--              <base-input-admin-->
<!--                v-model="freezerTemperature.two"-->
<!--                name="freezer_temperaturE_2"-->
<!--                wrap-class="col-4"-->
<!--                wrap-input-class="col-12 col-md-9 px-3"-->
<!--                input-local-class="col-8"-->
<!--              >-->
<!--                <template #afterInput><span class="ml-2 mt-2">度</span></template>-->
<!--              </base-input-admin>-->
<!--              <base-input-admin-->
<!--                v-model="freezerTemperature.three"-->
<!--                name="freezer_temperature_3"-->
<!--                wrap-class="col-12 col-md-8 mt-3"-->
<!--                wrap-input-class="w-auto"-->
<!--                input-local-class="w-auto"-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-2 mt-2">→</span></template>-->
<!--                <template #afterInput><span class="ml-2 mt-2">度確認</span></template>-->
<!--              </base-input-admin>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
        <base-radio-admin
          v-model="car.freezing_type"
          :items="freezingType"
          name="freezing_type"
          label="冷凍機タイプ"
        />
        <base-radio-admin
          v-model="car.has_freezer_standby"
          :items="check"
          name="has_freezer_standby"
          label="冷凍機スタンバイ"
        />
        <base-radio-admin
          v-model="car.freezer_sub_engine_id"
          :items="freezerSubEngine"
          name="freezer_sub_engine_id"
          label="冷凍機サブエンジン"
        />
        <base-radio-admin v-model="car.has_evaporator" :items="check" name="has_evaporator" label="2工バ" />
        <div :class="wrapClass">
          <div :class="wrapLabelClass" class="">水抜き穴</div>
          <div class="row col-md-9 py-3 border m-0">
            <base-input-admin
              v-model="car.drain_hole_versus"
              name="drain_hole_versus"
              wrap-input-class="col-12"
              input-local-class="col-8 ml-lg-2"
              is-only-number
            >
              <template #afterInput><span class="ml-2 mt-2">対</span></template>
            </base-input-admin>
            <base-input-admin
              v-model="car.drain_hole_individual"
              name="drain_hole_individual"
              wrap-class="ml-lg-5 pl-lg-5 mt-3 mt-lg-0"
              wrap-input-class="col-12 p-0"
              input-local-class="col-8"
              is-only-number
            >
              <template #afterInput><span class="ml-2 mt-2">対</span></template>
            </base-input-admin>
          </div>
        </div>
        <base-textarea-admin v-model="car.freezer_description" name="freezer_description" label="冷凍機備考" />
      </div>
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
import car_form from '../../../mixins/car_form_admin'

export default {
  name: 'CarFormStep2Admin',
  mixins: [car_form],
  props: [
    'back',
    'floorMaterial',
    'joistMaterial',
    'lashingRail',
    'sideDoorType',
    'sideDoorPosition',
    'sideDoorSize',
    'freezerTemperature',
    'tailLift',
    'freezerSubEngine',
    'freezingType',
    'bodyType',
  ],
}
</script>
