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
import home from './components/Home.vue'
import gantt from './components/Gantt.vue'
import reclamation from './components/Reclamation.vue'
import DetailleReclamation from './components/DetailleReclamation.vue'
import profile from './components/profile.vue'
import task from './components/Task.vue'
import taskdetail  from './components/taskdetail.vue'
import Main  from './components/MainApp.vue'
import Login  from './components/loginForm.vue'
export const routes = [
    {path: '/', component: Main ,meta: {requiresAuth: true},children:[
        {path: '/project', component: project , meta: {requiresAuth: true} },
        {path: '/calendrier', component: calendar, meta: {requiresAuth: true} },
        {path: '/setting', component: setting, meta: {requiresAuth: true} },
        {path: '/client', component: client, meta: {requiresAuth: true} },
        {path: '/detail/:id', name: detail , component: detail, meta: {requiresAuth: true} },
        {path: '/membre', component: membre, meta: {requiresAuth: true} },
        {path: '/test', component: test, meta: {requiresAuth: true} },
        {path: '/projectemploye' , component: projectemploye, meta: {requiresAuth: true} },
        {path: '/Chefprojet', component: chef, meta: {requiresAuth: true}},
        {path: '/client/:id' , component: clientdetail, meta: {requiresAuth: true} },

        {path: '/home' , component: home , meta: {requiresAuth: true}},
        {path: '/gantt/:id' , component: gantt, meta: {requiresAuth: true}},
        {path: '/reclamation' , component: reclamation, meta: {requiresAuth: true}},
        {path: '/detailleReclamation/:id' , component: DetailleReclamation, meta: {requiresAuth: true}},
        {path: '/profile/:id' , component: profile , meta: {requiresAuth: true}},
        {path: '/task/:id' , component: task, meta: {requiresAuth: true}},
        {path: '/taskdetail/:id' , component: taskdetail, meta: {requiresAuth: true} }
        ]
},
    {path: '/login', component: Login,meta: {requiresAuth: false}
   
 },
   {path: '*' , component:    require('./components/404.vue').default },


  ];

