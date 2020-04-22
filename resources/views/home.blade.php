<?php
use App\Projet;
if (auth()->user()->role == 'admin'){
  $projet = Projet::all();
}
else{
  $projet = auth()->user()->projets;
}
?>
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
  <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
  <script>
    window.laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!};
    </script>



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


      <!-- Notifications Dropdown Menu -->
    <Notification  :userid="{{auth()->id()}}" :unreads="{{auth()->user()->unreadNotifications}}"> </Notification>
    <audio id="notify_audio"> <source src="{{ asset('audio/notify.mp3') }}" >
    </audio>
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
        <div class="image" >
          <img src="\img\profile\{{ auth()->user()->photo }}" class="img-circle elevation-2" alt="User Image">

  </div>
        <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if(! Gate::check('Admin'))
               <li class="nav-item">
               <router-link to="/profile/{{auth()->user()->id}}" class="nav-link">
                 <i class="fas fa-user" style="color:#05dfd7" ></i>
                      <p>
        Profile

                      </p>
                    </router-link>
                  </li>
        @endif
 @if(Gate::check('Admin') )
          <li class="nav-item">
            <router-link  to="/project" class="nav-link">
             <i class="fas fa-project-diagram" style="color:#05dfd7"></i>
             <p>
               Projects
              </p>
            </router-link>
          </li>
@endif
@cannot('AdminClient')


       <li class="nav-item">
            <router-link  to="/projectemploye" class="nav-link">
             <i class="fas fa-project-diagram" style="color:#05dfd7"></i>
              <p>
                Your Projects
              </p>
       </router-link>
          </li>
          @endcannot
          @cannot('Client')
       <li class="nav-item has-treeview ">
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-tasks"></i>
          <p>
            Tasks
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        @foreach ($projet   as $project)


        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link :to="`/task/{{$project->id}}`" class="nav-link ">
              <i class="fas fa-circle" style="color:#05dfd7"> </i>
              <p>Tasks :{{ $project->name }} </p>
            </router-link>
          </li>

        </ul>
        @endforeach
           @endcannot

         @cannot('Client')


          <li class="nav-item has-treeview ">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-tasks"></i>
             <p>
               Gantt
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>

           @foreach ($projet   as $project)


           <ul class="nav nav-treeview">
             <li class="nav-item">
               <router-link :to="`/gantt/{{$project->id}}`" class="nav-link ">
                 <i class="far fas fa-circle"  style="color:#05dfd7"></i>
                 <p>Gantt :{{ $project->name }} </p>
               </router-link>
             </li>

           </ul>

           @endforeach
           </li>
           @endcannot
@if(Gate::check('Admin') )
          <li class="nav-item">
            <router-link  to="/Chefprojet" class="nav-link" >
                <i class="fas fa-user-shield" style="color:#05dfd7"></i>
              <p>
                Team leader
              </p>
               </router-link>
          </li>
@endif
@if(Gate::check('Admin') || Gate::check('Chef'))
          <li class="nav-item">
            <router-link to="/membre" class="nav-link">
           <i class="fas fa-users" style="color:#05dfd7" ></i>
              <p>
                Members

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
                Calendar

              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/reclamation" class="nav-link">
         <i class="fas fa-exclamation" style="color:#05dfd7" ></i>
              <p>
                Complaints

              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
             <i class="fas fa-poll" style="color:#05dfd7" ></i>
              <p>
                Statistics

              </p>
            </a>
          </li>

@can('Admin')
          <li class="nav-item">
            <router-link to="/setting" class="nav-link">
           <i class="fas fa-cogs" style="color:#05dfd7" ></i>
              <p>
               Setting

              </p>
            </router-link>
          </li>
          @endcan
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
<script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
<script src="/js/app.js"></script>


</body>
</html>
