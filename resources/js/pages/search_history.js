import {axiosClient} from "../commons/axiosClient";
import Toast from "../commons/notyf";

var SearchHistory = {
  init() {
    this.delete();
  },
  delete() {
    $('.js-history-delete').on('click', function (e) {
      e.preventDefault();
      let $this = $(this),
          id    = $this.data('id'),
          html  = $this.html(),
          $wrap = $this.closest('.wrap-history');
      if (!confirm('消去してもよろしいですか')) {
        return false;
      }
      $this.html(`<i class="fa fa-spinner fa-pulse fa-fw mr-2"></i> 読み込み中`);
      axiosClient.post('/search-history/delete/' + id)
        .then(res => {
          Toast.success(res.msg);
          $this.closest('.history-item').fadeOut(function () {
            $this.closest('.history-item').remove();
            if ($wrap.find('.history-item').length === 0) {
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
};
export default SearchHistory;
