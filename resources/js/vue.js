/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./vue_bootstrap')
import Vue from 'vue'
import Api from './vue/services/api'
import FormMixin from './vue/mixins/form'
import { extendedRules } from './vue/rules'
import { extend, localize, ValidationObserver, ValidationProvider } from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'
import ja from 'vee-validate/dist/locale/ja.json'
import VueSanitize from 'vue-sanitize'
import Config from './vue/config'
import * as directives from './vue/directives'

// vee-validate config
Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)
Object.keys(rules).forEach(rule => {
  extend(rule, rules[rule])
})
Object.keys(extendedRules).forEach(rule => {
  extend(rule, extendedRules[rule])
})
localize({
  ja,
})
localize('ja')

Vue.use(require('vue-moment'))

const VueSanitizeDefaultOptions = {
  allowedTags: VueSanitize.defaults.allowedTags.concat(['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'img', 'span', 'font']),
  allowedAttributes: {
    '*': [
      'href',
      'align',
      'alt',
      'center',
      'bgcolor',
      'name',
      'target',
      'src',
      'style',
      'class',
      'id',
      'size',
      'color',
      'face',
      'font-size',
    ],
  },
}
Vue.use(VueSanitize, VueSanitizeDefaultOptions)

// load directive
Object.keys(directives).forEach(key => {
  Vue.directive(key, directives[key])
})

//import component
Vue.component('VInput', require('./vue/components/VInput').default)
Vue.component('VInputFullName', require('./vue/components/VInputFullName').default)
Vue.component('VSelect', require('./vue/components/VSelect').default)
Vue.component('VCheckBox', require('./vue/components/VCheckBox').default)
Vue.component('VTextarea', require('./vue/components/VTextarea').default)
Vue.component('OneFieldEdit', require('./vue/components/OneFieldEdit').default)

Vue.component('Step', require('./vue/components/Step').default)
Vue.component('VInputTwo', require('./vue/components/VInputTwo').default)

Vue.component('BaseRadio', require('./vue/components/BaseRadio').default)
Vue.component('BaseInput', require('./vue/components/BaseInput').default)
Vue.component('BaseCheckbox', require('./vue/components/BaseCheckbox').default)
Vue.component('BaseSelect', require('./vue/components/BaseSelect').default)
Vue.component('BaseTextarea', require('./vue/components/BaseTextarea').default)

Vue.component('BaseRadioAdmin', require('./vue/components/admin/BaseRadioAdmin').default)
Vue.component('BaseInputAdmin', require('./vue/components/admin/BaseInputAdmin').default)
Vue.component('BaseCheckboxAdmin', require('./vue/components/admin/BaseCheckboxAdmin').default)
Vue.component('BaseSelectAdmin', require('./vue/components/admin/BaseSelectAdmin').default)
Vue.component('BaseTextareaAdmin', require('./vue/components/admin/BaseTextareaAdmin').default)

//import pages
Vue.component('LoginForm', require('./vue/pages/auth/LoginForm').default)
Vue.component('PasswordEmailForm', require('./vue/pages/auth/PasswordEmailForm').default)
Vue.component('PasswordResetForm', require('./vue/pages/auth/PasswordResetForm').default)
Vue.component('RegisterForm', require('./vue/pages/auth/RegisterForm').default)
Vue.component('OrderRequestForm', require('./vue/pages/order/RequestForm').default)
Vue.component('OrderEditStatusForm', require('./vue/pages/order/EditStatusForm').default)
Vue.component('CarForm', require('./vue/pages/car_manager/CarForm').default)
Vue.component('CarFormAdmin', require('./vue/pages/admin/car_manager/CarFormAdmin').default)
Vue.component('ContactForm', require('./vue/pages/contact/ContactForm').default)
Vue.component('OrderEditStatusForm', require('./vue/pages/order/EditStatusForm').default)
Vue.component('ChatPage', require('./vue/pages/chat/ChatPage').default)
Vue.component('EditPasswordForm', require('./vue/pages/account/EditPasswordForm').default)

// admin component
Vue.component('AdminChatDetail', require('./vue/components/chat/AdminChatDetail').default)
Vue.component('ApproveForm', require('./vue/pages/admin/car_approve/ApproveForm').default)

// prototype
Vue.prototype.$log = {
  log: process.env.DEBUG === 'true' ? console.log : () => {},
  error: process.env.DEBUG === 'true' ? console.error : () => {},
}
Vue.prototype.$api = new Api(window.axios, Vue.prototype.$log)

const metaUserId = document.getElementById('meta-user-id')
if (metaUserId) {
  Vue.prototype.$userId = metaUserId.getAttribute('content')
} else {
  Vue.prototype.$userId = null
}
Vue.prototype.$config = Object.seal(Config)
Vue.prototype.$getQueryString = (name, url = window.location.href) => {
  name = name.replace(/[\[\]]/g, '\\$&')
  let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url)
  if (!results) return null
  if (!results[2]) return ''
  return decodeURIComponent(results[2].replace(/\+/g, ' '))
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.mixin(FormMixin)

const app = new Vue({
  el: '#vue',
  components: {},
})
