import Vue from 'vue'
import VueRouter from 'vue-router'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import StoreData from './store';
import Vuex from 'vuex';
import seww from "sweetalert2"
import boss from './components/Boss.vue'
window.seww =seww;
import {routes} from './routes';
import {initialize} from './helpers/general';
 import { Form, HasError, AlertError } from 'vform'
 Vue.component(HasError.name, HasError)
 Vue.component(AlertError.name, AlertError)
require('./bootstrap');
window.Vue = require('vue');
window.Form=Form;
Vue.use(VueRouter)
Vue.component('Notification' ,require('./components/Notification.vue').default);
const store = new Vuex.Store(StoreData);
import Acces from './Acces'
Vue.prototype.$acces = new Acces(window.user);
import 'fullcalendar/dist/fullcalendar.css'
import FullCalendar from 'vue-full-calendar'
import Print from 'vue-print-nb'


Vue.use(Print);
/**npm instal
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(FullCalendar)
const Toast = seww.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', seww.stopTimer)
        toast.addEventListener('mouseleave', seww.resumeTimer)
      }
  })
  const options = {
    color: '#007bff',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.1s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
  }

  Vue.use(VueProgressBar, options)
  window.Toast=Toast;
window.fire =new Vue();
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.filter('date',function(datee){
return moment(datee).format('MMMM Droutes o YY');
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
   routes,
    mode: "history",
    base: process.env.BASE_URL
    // short for `routes: routes`
  })
  initialize(store, router);
  const app = new Vue({
    el: '#app',
    store,
    router,
    components:{
            boss
    },

})
