var SliderRange = {
  init() {
    this.sliderRange()
  },
  sliderRange() {
    $('.slider').each(function (i, slider) {
      let $slider = $(slider)
      $slider
        .slider({
          min: $slider.data('min'),
          max: $slider.data('max'),
          range: true,
          values: [$slider.data('min-current'), $slider.data('max-current')],
        })
        .slider('pips', {
          rest: false,
          first: false,
          last: false,
        })
        .slider('float')
      $slider.on('slidechange', function (e, ui) {
        $('[name=' + $slider.data('name') + ']')
          .val(ui.values.join(','))
          .trigger('change')
      })
    })
  },
}
export default SliderRange
