import Toast from "../commons/notyf";
import {axiosClient} from "../commons/axiosClient";

var CarManager = {
  init() {
    this.releaseCar();
    this.deleteCar();
  },
  releaseCar() {
    $('.js-car-release').on('click', function (e) {
      e.preventDefault();
      let $this = $(this),
          id    = $this.data('id'),
          html  = $this.html();
      $this.html(`<i class="fa fa-spinner fa-pulse fa-fw mr-2"></i> 読み込み中`);
      axiosClient.post('/car-manager/release/' + id)
        .then(res => {
          Toast.success(res.msg);
          $this.closest('.product-item').find('.js-text-private').text('公開');
          $(`.js-car-release[data-id=${id}]`).remove();
        })
        .catch(error => {
          Toast.error(error?.data?.msg[0] ?? '');
        })
        .finally(() => {
          $this.html(html);
        });
    });
  },
  deleteCar() {
    $('.js-car-delete').on('click', function (e) {
      e.preventDefault();
      let $this = $(this),
          id    = $this.data('id'),
          html  = $this.html(),
          $wrap = $this.closest('.wrap-product');
      if (!confirm('消去してもよろしいですか')) {
        return false;
      }
      $this.html(`<i class="fa fa-spinner fa-pulse fa-fw mr-2"></i> 読み込み中`);
      axiosClient.post('/car-manager/delete/' + id)
        .then(res => {
          Toast.success(res.msg);
          $this.closest('.product-item').fadeOut(function () {
            $this.closest('.product-item').remove();
            if ($wrap.find('.product-item').length === 0) {
              location.reload();
            }
          });
        })
        .catch(error => {
          Toast.error(error.msg);
        })
        .finally(() => {
          $this.html(html);
        });
    });
  }
}
export default CarManager
