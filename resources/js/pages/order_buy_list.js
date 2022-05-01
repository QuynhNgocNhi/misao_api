var OrderBuyList = {
  init() {
    this.filter()
    this.initFilter()
    this.clearFilter()
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
        // location.href = url.href.split('#')[0] + '#result'
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
    // location.href = url.href.split('#')[0] + '#result'
    console.log(url.href.split('#')[0] + '#result')
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
    $('.js-submit-filter').on('click', function (e) {
      e.preventDefault()
      // $('.js-wrap-filter').addClass('hidden')
      // $('body').removeClass('overflow-hidden')
      self.submit()
    })
    $('.js-open-sort-order').on('click', function (e) {
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
}
export default OrderBuyList
