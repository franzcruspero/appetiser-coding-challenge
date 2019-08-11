import Vue from 'vue'
import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'
import BootstrapVue from 'bootstrap-vue'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueMaterial)
Vue.use(Vuelidate)
Vue.use(BootstrapVue)
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('Layout', require('./components/Layout.vue').default);
Vue.component('pagefooter', require('./components/PageFooter.vue').default);

const app = new Vue({
    el: '#app',
})
