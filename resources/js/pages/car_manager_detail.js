import { axiosClient } from '../commons/axiosClient'
var CarManagerDetail = {
  init() {
    this.requestPublic()
    this.updateStatus()
  },
  requestPublic() {
    $('.js-request-public').on('click', function (e) {
      e.preventDefault()
      let $this = $(this),
        carId = $this.data('id')
      $this.prop('disabled', true)
      $this.html(`<i class="fa fa-spinner fa-pulse fa-fw mr-2"></i> 申請中`)
      axiosClient
        .post('/car-manager/request-public/' + carId)
        .then(res => {
          Toast.success(res.msg)
          $this.html(`<span class="text-white">掲載申請済み</span>`)
          setTimeout(function () {
            window.location = '/car-manager/detail/' + carId
          }, 500)
        })
        .catch(error => {
          Toast.error(error.msg)
        })
    })
  },
  updateStatus() {
    $('.js-update-status').on('click', function (e) {
      e.preventDefault()
      let $this = $(this),
        carId = $this.data('id'),
        status = $this.data('status')
      $this.prop('disabled', true)
      $this.html(`<i class="fa fa-spinner fa-pulse fa-fw mr-2"></i> 変更中`)
      axiosClient
        .post('/car-manager/update-status/' + carId, { status: status })
        .then(res => {
          Toast.success(res.msg)
          $this.html(`<span class="text-white">変更済み</span>`)
          setTimeout(function () {
            window.location = '/car-manager/detail/' + carId
          }, 500)
        })
        .catch(error => {
          Toast.error(error.msg)
        })
    })
  },
}
export default CarManagerDetail
