/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 import Vue from 'vue'
import VueRouter from 'vue-router'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import seww from "sweetalert2"
window.seww =seww;
import store from "./store"
 import { Form, HasError, AlertError } from 'vform'
 Vue.component(HasError.name, HasError)
 Vue.component(AlertError.name, AlertError)
require('./bootstrap');
window.Vue = require('vue');
Vue.component('Notification' ,require('./components/Notification.vue').default);

window.Form=Form;

import Acces from './Acces'
Vue.prototype.$acces = new Acces(window.user);

import project from './components/Project.vue'
import calendar from './components/Calendar.vue'
import setting from './components/Setting.vue'
import client from './components/Client.vue'
import detail from './components/ProjetDetail.vue'
import membre from './components/Membre.vue'
import test from './components/Test.vue'
import chef from './components/Chefprojet.vue'
import clientdetail from './components/ClientDetail.vue'
import projectemploye from './components/ProjectEmploye.vue'
import 'fullcalendar/dist/fullcalendar.css'
import FullCalendar from 'vue-full-calendar'
import home from './components/Home.vue'
import gantt from './components/Gantt.vue'
import reclamation from './components/Reclamation.vue'
import DetailleReclamation from './components/DetailleReclamation.vue'
import Print from 'vue-print-nb'
import profile from './components/profile.vue'
import task from './components/Task.vue'
import taskdetail  from './components/taskdetail.vue'


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
Vue.use(VueRouter)
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
const routes = [
    {path: '/project', component: project },
    {path: '/calendrier', component: calendar },
    {path: '/setting', component: setting },
    {path: '/client', component: client },
    {path: '/detail/:id', name: detail , component: detail },
    {path: '/membre', component: membre },
    {path: '/test', component: test },
    {path: '/projectemploye' , component: projectemploye },
    {path: '/Chefprojet', component: chef},
    {path: '/client/:id' , component: clientdetail },
    {path: '*' , component:    require('./components/404.vue').default },
    {path: '/home' , component: home },
    {path: '/gantt/:id' , component: gantt},
    {path: '/reclamation' , component: reclamation},
    {path: '/detailleReclamation/:id' , component: DetailleReclamation},
    {path: '/profile/:id' , component: profile },
    {path: '/task/:id' , component: task},
    {path: '/taskdetail/:id' , component: taskdetail }

  ];

  Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component(
    'login-form',
    require('./components/loginForm.vue').default
);
Vue.component(
    'not-found',
    require('./components/404.vue').default
);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.filter('date',function(datee){
return moment(datee).format('MMMM Do YY');
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes // short for `routes: routes`
  })

  const app = new Vue({
    store,
    el: '#app',

    components:{
     project,

    },
    router
})
