import Vue from 'vue'
import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'
import BootstrapVue from 'bootstrap-vue'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

console.log(Vue.config.devtools)
Vue.config.devtools = false
console.log(Vue.config.devtools)
Vue.config.debug = false
console.log(Vue.config.debug)
Vue.config.silent = true
console.log(Vue.config.silent)


Vue.use(VueMaterial)
Vue.use(Vuelidate)
Vue.use(BootstrapVue)
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('Layout', require('./components/Layout.vue').default);
Vue.component('pagefooter', require('./components/PageFooter.vue').default);

const app = new Vue({
    el: '#app',
})
