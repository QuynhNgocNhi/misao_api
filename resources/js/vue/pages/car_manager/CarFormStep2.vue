<template>
  <div>
    <div class="bg-slate-700 lg:bg-slate-200 lg:py-4">
      <div class="container">
        <h2 class="p-2 lg:mb-3 text-white lg:text-slate-700 lg:text-2xl font-medium text-center">ボディー情報の更新</h2>
        <a :href="back" class="btn btn-md btn-outline-primary btn-icon px-16 hidden lg:inline-flex">
          戻る<i class="fa fa-arrow-left left-2.5 !right-auto"></i>
        </a>
      </div>
    </div>
    <div class="pb-8 lg:container lg:py-8">
      <div :class="wrapClass">
        <div :class="wrapLabelClass">外寸</div>
        <div :class="wrapInputClass">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <base-input
              v-model="car.outside_size_length"
              name="outside_size_length"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">長さ</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
            <base-input
              v-model="car.outside_size_width"
              name="outside_size_width"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-6">幅</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
            <base-input
              v-model="car.outside_size_height"
              name="outside_size_height"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">高さ</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
          </div>
        </div>
      </div>
      <div :class="wrapClass">
        <div :class="wrapLabelClass">内寸</div>
        <div :class="wrapInputClass">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <base-input
              v-model="car.inside_size_length"
              name="inside_size_length"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">長さ</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
            <base-input
              v-model="car.inside_size_width"
              name="inside_size_width"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-6">幅</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
            <base-input
              v-model="car.inside_size_height"
              name="inside_size_height"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">高さ</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
          </div>
        </div>
      </div>
      <base-radio
        v-model="car.floor_material_id"
        car-form
        :items="floorMaterial"
        name="floor_material_id"
        label="床素材"
      />
      <base-radio
        v-model="car.joist_material_id"
        car-form
        :items="joistMaterial"
        name="joist_material_id"
        label="根太素材"
      />
      <base-radio v-model="car.has_built_in_body" car-form :items="check" name="has_built_in_body" label="造りボディ" />
      <base-radio
        v-model="car.lashing_rail_id"
        car-form
        :items="lashingRail"
        name="lashing_rail_id"
        label="ラッシングレール"
      />
      <div :class="wrapClass">
        <div :class="wrapLabelClass">門口サイズ</div>
        <div :class="wrapInputClass">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <base-input
              v-model="car.gate_width"
              name="gate_width"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-6">幅</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
            <base-input
              v-model="car.gate_height"
              name="gate_height"
              wrap-class="w-full whitespace-nowrap"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">高さ</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
          </div>
        </div>
      </div>
      <base-input
        v-model="car.inner_hook"
        car-form
        name="inner_hook"
        label="内フック"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">対</span></template>
      </base-input>
      <base-input
        v-model="car.joroder_groove"
        car-form
        name="joroder_groove"
        label="ジョロダー溝"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">列</span></template>
      </base-input>
      <base-input
        v-model="car.pallet_roller"
        car-form
        name="pallet_roller"
        label="パレットローラー"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">列</span></template>
      </base-input>
      <base-radio v-model="car.has_side_door" car-form :items="check" name="has_side_door" label="サイド扉" />
      <base-radio
        v-model="car.side_door_type_id"
        car-form
        :items="sideDoorType"
        name="side_door_type_id"
        label="サイド扉タイプ"
      />
<!--      <div :class="wrapClass">-->
<!--        <div :class="wrapLabelClass">サイド扉サイズ</div>-->
<!--        <div :class="wrapInputClass">-->
<!--          <div class="mb-3">-->
<!--            <base-radio-->
<!--              v-model="sideDoorSize[0].position"-->
<!--              :items="sideDoorPosition"-->
<!--              name="side_door_size.0.position"-->
<!--              wrap-class="w-full mb-3"-->
<!--            />-->
<!--            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">-->
<!--              <base-input-->
<!--                v-model="sideDoorSize[0].width"-->
<!--                name="side_door_size.0.width"-->
<!--                wrap-class="w-full whitespace-nowrap"-->
<!--                input-local-class="w-6/12"-->
<!--                is-only-number-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-6">幅</span></template>-->
<!--                <template #afterInput><span class="ml-2">cm</span></template>-->
<!--              </base-input>-->
<!--              <base-input-->
<!--                v-model="sideDoorSize[0].height"-->
<!--                name="side_door_size.0.height"-->
<!--                wrap-class="w-full whitespace-nowrap"-->
<!--                input-local-class="w-6/12"-->
<!--                is-only-number-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-2">高さ</span></template>-->
<!--                <template #afterInput><span class="ml-2">cm</span></template>-->
<!--              </base-input>-->
<!--            </div>-->
<!--          </div>-->
<!--          <div>-->
<!--            <base-radio-->
<!--              v-model="sideDoorSize[1].position"-->
<!--              :items="sideDoorPosition"-->
<!--              name="side_door_size.1.position"-->
<!--              wrap-class="w-full mb-3"-->
<!--            />-->
<!--            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">-->
<!--              <base-input-->
<!--                v-model="sideDoorSize[1].width"-->
<!--                name="side_door_size.1.width"-->
<!--                wrap-class="w-full whitespace-nowrap"-->
<!--                input-local-class="w-6/12"-->
<!--                is-only-number-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-6">幅</span></template>-->
<!--                <template #afterInput><span class="ml-2">cm</span></template>-->
<!--              </base-input>-->
<!--              <base-input-->
<!--                v-model="sideDoorSize[1].height"-->
<!--                name="side_door_size.1.height"-->
<!--                wrap-class="w-full whitespace-nowrap"-->
<!--                input-local-class="w-6/12"-->
<!--                is-only-number-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-2">高さ</span></template>-->
<!--                <template #afterInput><span class="ml-2">cm</span></template>-->
<!--              </base-input>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
      <base-input v-model="car.stance" car-form name="stance" label="スタンション" input-local-class="w-6/12">
        <template #afterInput><span class="ml-2">対</span></template>
      </base-input>
      <base-input
        v-model="car.aori_material"
        car-form
        name="aori_material"
        label="アオリ素材"
        input-local-class="w-6/12"
      />
      <base-input
        v-model="car.aori_height"
        car-form
        name="aori_height"
        label="アオリ高さ"
        input-local-class="w-6/12"
        is-only-number
      >
        <template #afterInput><span class="ml-2">cm</span></template>
      </base-input>
      <div :class="wrapClass">
        <div :class="wrapLabelClass">床面地上高</div>
        <div :class="wrapInputClass">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <base-input
              v-model="car.floor_clearance_previous"
              name="floor_clearance_previous"
              wrap-class="w-full"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">前</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
            <base-input
              v-model="car.floor_clearance_rear"
              name="floor_clearance_rear"
              wrap-class="w-full"
              input-local-class="w-6/12"
              is-only-number
            >
              <template #beforeInput><span class="mr-2">後</span></template>
              <template #afterInput><span class="ml-2">cm</span></template>
            </base-input>
          </div>
        </div>
      </div>
      <base-textarea
        v-model="car.floor_clearance_description"
        car-form
        name="floor_clearance_description"
        label="備考"
      />
      <div v-show="car.has_tail_lift == true">
        <base-input
          v-model="car.manufacture_tail_lift"
          car-form
          name="manufacture_tail_lift"
          label="パワーゲートメーカー"
          input-local-class="w-6/12"
        />
        <base-radio v-model="car.tail_lift_id" car-form :items="tailLift" name="tail_lift_id" label="パワーゲート仕様" />
        <div :class="wrapClass">
          <div :class="wrapLabelClass">パワーゲートサイズ</div>
          <div :class="wrapInputClass">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
              <base-input
                v-model="car.tail_lift_width"
                name="tail_lift_width"
                wrap-class="w-full"
                input-local-class="w-6/12"
                is-only-number
              >
                <template #beforeInput><span class="mr-6">幅</span></template>
                <template #afterInput><span class="ml-2">cm</span></template>
              </base-input>
              <base-input
                v-model="car.tail_lift_height"
                name="tail_lift_height"
                wrap-class="w-full"
                input-local-class="w-6/12"
                is-only-number
              >
                <template #beforeInput><span class="mr-2 whitespace-nowrap">長さ</span></template>
                <template #afterInput><span class="ml-2">cm</span></template>
              </base-input>
            </div>
          </div>
        </div>
        <base-textarea
          v-model="car.tail_lift_description"
          car-form
          name="tail_lift_description"
          label="パワーゲート備考"
        />
      </div>
      <div v-show="bodyType[car.body_type_id].includes('冷凍')">
        <base-input
          v-model="car.manufacturer_freezer"
          car-form
          name="manufacturer_freezer"
          label="冷凍機メーカー"
          input-local-class="w-6/12"
        />
        <base-select v-model="car.body_year" car-form :items="year" name="body_year" label="冷凍機ボデー年式">
          <template #afterInput><span class="ml-2">年</span></template>
        </base-select>
        <base-radio
          v-model="car.freezing_type"
          car-form
          :items="freezingType"
          name="freezing_type"
          label="冷凍機タイプ"
        />
<!--        <div :class="wrapClass">-->
<!--          <div :class="wrapLabelClass">冷凍機温度</div>-->
<!--          <div :class="wrapInputClass">-->
<!--            <div class="inline-flex flex-wrap gap-4">-->
<!--              <base-input-->
<!--                v-model="freezerTemperature.one"-->
<!--                name="freezer_temperature.0"-->
<!--                wrap-class="whitespace-nowrap mr-3"-->
<!--                wrap-input-class="w-auto"-->
<!--                input-local-class="w-auto"-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-2">冷凍機計測</span></template>-->
<!--                <template #afterInput><span class="ml-2">時間実稼働で庫内</span></template>-->
<!--              </base-input>-->
<!--              <base-input-->
<!--                v-model="freezerTemperature.two"-->
<!--                name="freezer_temperature.1"-->
<!--                wrap-class="whitespace-nowrap mr-3"-->
<!--                wrap-input-class="w-auto"-->
<!--                input-local-class="w-auto"-->
<!--              >-->
<!--                <template #afterInput><span class="ml-2">度</span></template>-->
<!--              </base-input>-->
<!--              <base-input-->
<!--                v-model="freezerTemperature.three"-->
<!--                name="freezer_temperature.2"-->
<!--                wrap-class="whitespace-nowrap"-->
<!--                wrap-input-class="w-auto"-->
<!--                input-local-class="w-auto"-->
<!--              >-->
<!--                <template #beforeInput><span class="mr-2">→</span></template>-->
<!--                <template #afterInput><span class="ml-2">度確認</span></template>-->
<!--              </base-input>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
        <base-radio
          v-model="car.has_freezer_standby"
          car-form
          :items="check"
          name="has_freezer_standby"
          label="冷凍機スタンバイ"
        />
        <base-radio
          v-model="car.freezer_sub_engine_id"
          car-form
          :items="freezerSubEngine"
          name="freezer_sub_engine_id"
          label="冷凍機サブエンジン"
        />
        <base-radio v-model="car.has_evaporator" car-form :items="check" name="has_evaporator" label="2工バ" />
        <div :class="wrapClass">
          <div :class="wrapLabelClass">水抜き穴</div>
          <div :class="wrapInputClass">
            <div class="grid grid-cols-2 gap-4">
              <base-input
                v-model="car.drain_hole_versus"
                name="drain_hole_versus"
                wrap-class="w-full"
                wrap-input-class="w-auto"
                is-only-number
              >
                <template #afterInput><span class="ml-2">対</span></template>
              </base-input>
              <base-input
                v-model="car.drain_hole_individual"
                name="drain_hole_individual"
                wrap-class="w-full"
                wrap-input-class="w-auto"
                is-only-number
              >
                <template #afterInput><span class="ml-2">個</span></template>
              </base-input>
            </div>
          </div>
        </div>
<!--        <base-input-->
<!--          v-model="car.insulation_thickness"-->
<!--          car-form-->
<!--          name="insulation_thickness"-->
<!--          label="断熱材厚"-->
<!--          is-only-number-->
<!--          input-local-class="w-6/12"-->
<!--        />-->
        <base-textarea v-model="car.freezer_description" car-form name="freezer_description" label="冷凍機備考" />
      </div>
      <div class="text-center mt-4 lg:mt-8">
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
  </div>
</template>

<script>
import car_form from '../../mixins/car_form'

export default {
  name: 'CarFormStep2',
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
