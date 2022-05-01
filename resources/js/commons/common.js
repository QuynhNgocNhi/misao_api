import lozad from 'lozad'
import { Fancybox } from '@fancyapps/ui/src/Fancybox/Fancybox'

var Common = {
  init() {
    this.lazyload()
    this.removeGraySelect()
  },
  lazyload() {
    const observer = lozad('.lazy', {
      threshold: 0.1,
      enableAutoReload: true,
    })
    observer.observe()
  },
  removeGraySelect() {
    $('.js-select-change').on('change', function () {
      let $this = $(this)
      if ($this.val().length > 0) {
        $this.removeClass('text-gray-400')
      } else {
        $this.addClass('text-gray-400')
      }
    })
  },
}
export default Common
