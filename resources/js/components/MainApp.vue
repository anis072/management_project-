<template>
    <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>#######</title>

 <!-- Font Awesome Icons -->
<link rel="stylesheet" href="/css/app.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
 <vue-progress-bar></vue-progress-bar>
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav mt">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>


    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
         
    </ul>
</nav>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/home" class="brand-link">

      <span class="brand-text font-weight-light">######</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="`/img/profile/${ currentUser.photo}`" class="img-circle elevation-2" alt="User Image">

  </div>
        <div class="info">
        <a href="#" class="d-block">{{ currentUser.name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              some or any other icon font library -->

               <li class="nav-item">
               <router-link :to="`/profile/${currentUser.id}`" class="nav-link">
                 <i class="fas fa-user" style="color:#05dfd7" ></i>
                      <p>
                   Profile
                      </p>
                    </router-link>
                  </li>

          <li class="nav-item" v-show="currentUser.role==='admin'  ">
            <router-link  to="/project" class="nav-link">
             <i class="fas fa-project-diagram" style="color:#05dfd7"></i>
             <p>
               Projects
              </p>
            </router-link>
          </li>
       <li class="nav-item" v-if=" currentUser.role!=='client' && currentUser.role!=='admin' " >
            <router-link  to="/projectemploye" class="nav-link" >
             <i class="fas fa-project-diagram" style="color:#05dfd7"></i>
              <p>
                Your Projects
              </p>
       </router-link>
          </li>
       <li class="nav-item has-treeview " v-if=" currentUser.role!=='client' " >
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-tasks"></i>
          <p>
            Tasks
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview"   >
          <li class="nav-item" v-for="(projet,index) in projets" :key="index" v-if="currentUser.role!=='admin' ">
            <router-link :to="`/task/${projet.id}`" class="nav-link ">
              <i class="fas fa-circle" style="color:#05dfd7"> </i>
              <p>Tasks :{{ projet.name }}  </p>
            </router-link>
          </li>
           <li class="nav-item" v-for="projet in projects.projets" :key="projet.id" v-show="currentUser.role==='admin'">
            <router-link :to="`/task/${projet.id}`" class="nav-link ">
              <i class="fas fa-circle" style=":#05dfd7"> </i>
              <p>Tasks :{{ projet.name }}  </p>
            </router-link>
          </li>


        </ul>
       </li>
          <li class="nav-item has-treeview "   v-if=" currentUser.role!=='client'" >
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-tasks"></i>
             <p>
               Gantt
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>

        <ul class="nav nav-treeview">
             <li class="nav-item"  v-for="(projet,index) in projets" :key="index" v-if="currentUser.role!=='admin' ">
               <router-link :to="`/gantt/${projet.id}`" class="nav-link ">
                 <i class="far fas fa-circle"  style="color:#05dfd7"></i>
                 <p>Gantt : {{ projet.name }}  </p>
               </router-link>
             </li>
                <li class="nav-item" v-for="projet in projects.projets" :key="projet.id" v-show="currentUser.role==='admin'">
            <router-link :to="`/gantt/${projet.id}`" class="nav-link ">
              <i class="fas fa-circle" style="color:#05dfd7"> </i>
              <p>Gantt:{{ projet.name }}  </p>
            </router-link>
          </li>

           </ul>


           </li>
          <li class="nav-item"   v-show="currentUser.role==='admin'">
            <router-link  to="/Chefprojet" class="nav-link" >
                <i class="fas fa-user-shield" style="color:#05dfd7"></i>
              <p>
                Team leader
              </p>
               </router-link>
          </li>

          <li class="nav-item" v-if="currentUser.role ==='admin' || currentUser.role==='chef de projet' ">
            <router-link to="/membre" class="nav-link">
           <i class="fas fa-users" style="color:#05dfd7" ></i>
              <p>
                Members

              </p>
            </router-link>
          </li>
       <li class="nav-item"  v-show="currentUser.role==='admin' || currentUser.role==='chef de projet' ">
            <router-link to="/client" class="nav-link">
         <i class="fas fa-user" style="color:#05dfd7" ></i>
              <p>
               CLient

              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/calendrier" class="nav-link">
             <i class="fas fa-calendar-plus" style="color:#05dfd7" ></i>
              <p>
                Calendar

              </p>
            </router-link>
          </li>
          <li class="nav-item" >
            <router-link to="/reclamation" class="nav-link">
         <i class="fas fa-exclamation" style="color:#05dfd7" ></i>
              <p>
                Complaints

              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/setting" class="nav-link">
           <i class="fas fa-cogs" style="color:#05dfd7" ></i>
              <p>
               Setting

              </p>
            </router-link>
          </li>
            <li class="nav-item">
           <a href="#!" @click.prevent="logout" class="nav-link">
           <i class="fas fa-lock-open" style="color:#05dfd7" ></i>
              <p>
               Logout
              </p>
         </a>
         </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->

    <div class="content">
    
      <div class="container-fluid">
      
        <router-view ></router-view>
           
           

                <!-- /.row -->
      </div><!-- /.container-fluid -->
    
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      ########
    </div>
    <!-- Default to the left -->
    <strong><a href="#"></a></strong> .
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

</body>
</html>
</template>
<script>


    export default {
        name: 'main-app',
        data(){
            return{

            aut:[],
              projets:{},
                user:JSON.parse(localStorage.getItem('user')),
              projet:{

              },
              projects:[],
              pro:{}
            }
        },
            methods: {

            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            },
             afficherProjet(){
                let axiosConfig = {
                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                    };
            axios.get("/api/getProjectsUserConnecte",axiosConfig).then(({ data }) => (this.projets = data));
            },
               afficherProjeta(){
                let axiosConfig = {

                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                };
                  axios.get('/api/projetadmin',axiosConfig).then(({ data }) =>(this.projects = data));
                },
        },
      computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        },
        created(){
            this.afficherProjet();
            this.afficherProjeta();
           axios.get('/api/notif').then(({ data }) =>(this.aut = data));
        }
    }
</script>
