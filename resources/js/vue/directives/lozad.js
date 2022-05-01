export default {
  bind(el, binding) {
    el.setAttribute('data-src', binding.value)
    if (window.lozad) {
      let observer = lozad(el)
      observer.observe()
    }
  },
  update(el, binding) {
    if (binding.oldValue !== binding.value) {
      el.setAttribute('data-src', binding.value)
      if (el.getAttribute('data-loaded') === 'true') {
        el.setAttribute('src', binding.value)
      }
    }
  },
}
