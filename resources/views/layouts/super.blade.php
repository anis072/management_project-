
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
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome Icons -->
<link rel="stylesheet" href="/css/app.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
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
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->

            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->

            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">

                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>

        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-bell"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header"></span>
          <div class="dropdown-divider"></div>

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i>
            <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i>
                        <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer"></a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

      <span class="brand-text font-weight-light">######</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">

        </div>
        <div class="info">
          <a href="#" class="d-block"></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
 @if(Gate::check('Admin') )
          <li class="nav-item">
            <router-link  to="/project" class="nav-link">
             <i class="fas fa-project-diagram" style="color:#05dfd7"></i>
             <p>
               Projets
              </p>
            </router-link>
          </li>
@endif
@if(!Gate::check('Admin') || !Gate::check('Chef'))
       <li class="nav-item">
            <router-link  to="/projectemploye" class="nav-link">
             <i class="fas fa-project-diagram" style="color:#05dfd7"></i>
              <p>
              Vos projets
              </p>
       </router-link>
          </li>
@endif-
@if(Gate::check('Admin') )
          <li class="nav-item">
            <router-link  to="/Chefprojet" class="nav-link" >
                <i class="fas fa-user-shield" style="color:#05dfd7"></i>
              <p>
               Chefs de Projets
              </p>
               </router-link>
          </li>
@endif
@if(Gate::check('Admin') || Gate::check('Chef'))
          <li class="nav-item">
            <router-link to="/membre" class="nav-link">
           <i class="fas fa-users" style="color:#05dfd7" ></i>
              <p>
                Membres

              </p>
            </router-link>
          </li>
 @endif
 @can('Admin')
       <li class="nav-item">
            <router-link to="/client" class="nav-link">
         <i class="fas fa-user" style="color:#05dfd7" ></i>
              <p>
               CLient

              </p>
            </router-link>
          </li>
@endcan

          <li class="nav-item">
            <router-link to="/calendrier" class="nav-link">
             <i class="fas fa-calendar-plus" style="color:#05dfd7" ></i>
              <p>
             Calendrier

              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
             <i class="fas fa-poll" style="color:#05dfd7" ></i>
              <p>
               Statistiques

              </p>
            </a>
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
    <a class="nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault();
         document.getElementById('logout-form').submit();">
       <i class="nav-icon fas fa-power-off"style="color:#05dfd7"></i>
       <p>{{ __('Logout') }}
    </p>
       </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
           @csrf
       </form>

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
@auth
<script>
window.user =@json(auth()->user())

</script>
@endauth
<script src="/js/app.js"></script>
</body>
</html>
<script>
    axios.defaults.headers.common["Authorization"] = "Bearer" + localStorage.getItem("member_token");
<script>
