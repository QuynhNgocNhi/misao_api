import { axiosClient } from '../commons/axiosClient'
import 'jquery-ui/ui/widgets/slider'
import './../../plugins/range/jquery-ui-slider-pips'
import 'jquery-ui-touch-punch'
import SliderRange from '../commons/sliderRange'

var CarList = {
  init() {
    SliderRange.init()
    this.storeFavorite()
    this.filter()
    this.initFilter()
    this.clearFilter()
    this.showSearchValue()
  },
  storeFavorite() {
    $('.js-store-favorite').on('click', function (e) {
      e.preventDefault()
      let $this = $(this),
        id = $this.data('id'),
        html = $this.html()
      $this.html(`<i class="fa fa-spinner fa-pulse fa-fw mr-2"></i> 追加中`)
      $this.css('pointer-events', 'none')
      axiosClient
        .post('/car-favorite/store', { car_id: id })
        .then(res => {
          Toast.successWhite(res.msg)
          $this.html(html)
          if ($this.find('span').text().includes('お気に入り登録する')) {
            $this.find('i').removeClass('text-gray-200').addClass('text-blue-500')
            $this.find('span').text('追加済み')
          } else {
            $this.find('i').removeClass('text-blue-500').addClass('text-gray-200')
            $this.find('span').text('お気に入り登録する')
          }
        })
        .catch(error => {
          Toast.error(error?.data?.msg[0] ?? '')
          $this.html(html)
        })
      setTimeout(() => {
        $this.css('pointer-events', '')
      }, 2000)
    })
  },
  filter() {
    let self = this
    if ($('.js-sort-desktop').is(':visible')) {
      $('.js-box-filter [name]').on('change', function () {
        self.submit()
      })
      $('.js-car-sort .js-select-change').on('change', function () {
        let url = new URL(window.location.href)
        url.searchParams.set('sort', $(this).val())
        location.href = url.href.split('#')[0] + '#result'
      })
      $('.js-box-filter [name=q]').keypress(function (event) {
        var keycode = event.keyCode ? event.keyCode : event.which
        if (keycode == '13') {
          self.submit()
        }
      })
    }
  },
  submit() {
    let self = this,
      url = new URL(window.location.href)
    $('.js-box-filter .box-filter').each(function (index) {
      let $this = $(this),
        name = '',
        value = ''
      if ($this.find('[name]').length === 1) {
        name = $this.find('[name]').attr('name')
        value = $this.find('[name]').val()
      } else {
        name = $this.find('[name]').first().attr('name')
        value = self.getParamCheckedToString($this)
      }
      if (value === '') {
        url.searchParams.delete(name)
      } else {
        url.searchParams.set(name, value)
      }
    })
    location.href = url.href.split('#')[0] + '#result'
  },
  getParamCheckedToString($this) {
    let checkeds = []
    $this.find('input:checked').each(function () {
      checkeds.push($(this).val())
    })
    return checkeds.join(',')
  },

  initFilter() {
    let self = this
    $('.js-open-filter').on('click', function (e) {
      e.preventDefault()
      $('body').addClass('overflow-hidden')
      $('.h-filter').closest('.js-wrap-filter').removeClass('hidden')
    })
    $('.js-submit-filter').on('click', function (e) {
      e.preventDefault()
      $('.js-wrap-filter').addClass('hidden')
      $('body').removeClass('overflow-hidden')
      self.submit()
    })
    $('.js-open-sort').on('click', function (e) {
      e.preventDefault()
      $(this).siblings('div').toggleClass('hidden')
    })
  },
  clearFilter() {
    $('.js-clear-filter').on('click', function (e) {
      e.preventDefault()
      $('.js-box-filter .box-filter').each(function (index) {
        if ($(this).find('[name]').length === 1) {
          $(this).find('[name]').prop('checked', false)
        } else {
          $(this)
            .find('input:checked')
            .each(function () {
              $(this).prop('checked', false)
            })
        }
      })
    })
  },
  getParamCheckedLabel($this) {
    let checkeds = []
    $this.find('input:checked').each(function () {
      checkeds.push($(this).next().text())
    })
    if (checkeds.includes('有り') || checkeds.includes('無し')) {
      checkeds[checkeds.indexOf('有り')] = $this.prev().text() + '有り'
      checkeds[checkeds.indexOf('無し')] = $this.prev().text() + '無し'
    }
    return checkeds.join('、')
  },
  showSearchValue() {
    let self = this
    let params = ''
    $('.js-box-filter .box-filter').each(function () {
      let $this = $(this),
        value = ''
      if ($this.find('[name]').length === 1) {
        value = $this.find('[name]').val().replace(',', '~')
        value = value !== '' ? $this.prev().text() + value : ''
      } else {
        value = self.getParamCheckedLabel($this)
      }
      if (value !== '') {
        params += value
        params += '、'
      }
    })
    params = params.substring(0, params.length - 1)
    $('#params').text(params)
  },
}
export default CarList
