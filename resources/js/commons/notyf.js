import {Notyf} from 'notyf';

var notyf = new Notyf({
  duration: 3000,
  position: {
    x: 'right',
    y: 'top',
  },
});
var Toast = {
  success(msg) {
    return notyf.success(msg);
  },
  error(msg) {
    return notyf.error(msg);
  },
  successWhite(msg) {
    let notyf = new Notyf({
      duration: 3000,
      position: {
        x: 'right',
        y: 'top',
      },
      types: [
        {
          type: 'success',
          background: 'white',
          className: 'border-2 border-primary w-62',
          icon: false,
        },
      ],
    })
    return notyf.success('<span class="text-primary">' + msg + '</span>')
  },
}
export default Toast
