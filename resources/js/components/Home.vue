<template>
    <div class="container">
 <section class="content mt-4" v-if="$acces.Admin()">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ projects.projects }}</h3>
                <p>Projects</p>
              </div>
              <div class="icon">
                <i class="fas fa-project-diagram"></i>
              </div>
              <router-link to="/project" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ clients.clients }}</h3>
                <p>Clients</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
             <router-link to="/client" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ leaders.leaders }}</h3>
                <p>Leaders</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
                <router-link to="/Chefprojet" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ users.users }}</h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <router-link to="/membre" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable ui-sortable">
            <!-- Custom tabs (Charts with tabs)-->
            <!-- /.card -->
            <!-- DIRECT CHAT -->
            <!--/.direct-chat -->
            <!-- TO DO List -->
            <div class="card">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  Projects
                </h3>
                <div class="card-tools">
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Projects</th>
                      <th>Progress</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(stat, ind) in stats.projectstat.data" :key="ind" >
                      <td>{{ ind+1 }}</td>
                      <td>{{ stat.name }}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" :style="{'width':`${parseInt(stat.progress)}%`}"></div>
                        </div>
                      </td>
                      <td><span v-if="`${parseInt(stat.progress)}`==100" class="badge bg-success" >{{ parseInt(stat.progress) }}%</span>
                      <span v-if="`${parseInt(stat.progress)}!=100`" class="badge bg-danger" >{{ parseInt(stat.progress) }}%</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
             </div>
            </div>
               <pagination :data="stats.projectstat" @pagination-change-page="getResults"></pagination>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
     <section class="content mt-4" v-if="!$acces.Admin()">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row" v-if="$acces.Chef()">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ projects.projects }}</h3>
                <p>Projects</p>
              </div>
              <div class="icon">
                <i class="fas fa-project-diagram"></i>
              </div>
             <router-link to="/projectemploye" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ clients.clients }}</h3>
                <p>Clients</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
             <router-link to="/client" v-if="$acces.Chef()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
              </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ leaders.leaders }}</h3>
                <p>Leaders</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
                <router-link to="/Chefprojet" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ users.users }}</h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <router-link to="/membre" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
        </div>
            <div class="row" v-if="!$acces.NotUser()">
          <div class="col-lg-4 col-9">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ projectusers.projects }}</h3>
                <p>Projects</p>
              </div>
              <div class="icon">
                <i class="fas fa-project-diagram"></i>
              </div>
             <router-link to="/projectemploye" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-4 col-9">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ leaders.leaders }}</h3>
                <p>Leaders</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
                <span  class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-9">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ users.users }}</h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <span  class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable ui-sortable">
            <!-- Custom tabs (Charts with tabs)-->
            <!-- /.card -->
            <!-- DIRECT CHAT -->
            <!--/.direct-chat -->
            <!-- TO DO List -->
            <div class="card" v-if="$acces.Admin()">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1" ></i>
                  Projects
                </h3>
                <div class="card-tools">
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Projects</th>
                      <th>Progress</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(stat, ind) in stats.projectstat.data" :key="ind" >
                      <td>{{ ind+1 }}</td>
                      <td>{{ stat.name }}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" :style="{'width':`${parseInt(stat.progress)}%`}"></div>
                        </div>
                      </td>
                      <td><span v-if="`${parseInt(stat.progress)}`==100" class="badge bg-success" >{{ parseInt(stat.progress) }}%</span>
                      <span v-if="`${parseInt(stat.progress)}!=100`" class="badge bg-danger" >{{ parseInt(stat.progress) }}%</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <pagination :data="stats.projectstat" @pagination-change-page="getResults"></pagination>
             </div>
            </div>
             <div class="card">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1" v-if="$acces.Admin()"></i>
                  Projects
                </h3>
                <div class="card-tools">
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" v-if="!$acces.Admin()">
                 <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Projects </th>
                      <th>Progress</th>
                    </tr>
                  </thead>
                  <tbody v-if="!$acces.client()">
                    <tr v-for="(stat, ind) in Ustats.projectstat" :key="ind" >
                      <td>{{ ind+1 }}</td>
                      <td>{{ stat.name }}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" :style="{'width':`${parseInt(stat.progress)}%`}"></div>
                        </div>
                      </td>
                      <td><span v-if="`${parseInt(stat.progress)}`==100" class="badge bg-success" >{{ parseInt(stat.progress) }}%</span>
                      <span v-if="`${parseInt(stat.progress)}`!=100" class="badge bg-danger" >{{ parseInt(stat.progress) }}%</span></td>
                    </tr>
                  </tbody>
                    <tbody v-if="$acces.client()">
                    <tr v-for="(stat, ind) in Cprojets.projects.data" :key="ind" >
                      <td>{{ ind+1 }}</td>
                      <td>{{ stat.name }}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" :style="{'width':`${parseInt(stat.progress)}%`}"></div>
                        </div>
                      </td>
                      <td><span v-if="`${parseInt(stat.progress)}`==100" class="badge bg-success" >{{ parseInt(stat.progress) }}%</span>
                      <span v-if="`${parseInt(stat.progress)}`!=100" class="badge bg-danger" >{{ parseInt(stat.progress) }}%</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" v-if="!$acces.client">
                <pagination :data="Ustats.projectstat" @pagination-change-page="getResults1"></pagination>
             </div>
              <div class="card-footer clearfix" v-if="$acces.client()">
                <pagination :data="Cprojets.projects" @pagination-change-page="getResults2"></pagination>
             </div>

            </div>
            <!-- /.card -->
          </section>
          <section class="col-lg-6">
        <div class="card" v-if="!$acces.NotUser()">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1" ></i>
                  Tasks
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" v-if="!$acces.Admin()">
                 <table class="table table-bordered">
                  <thead>
                    <tr style="width:20px;">
                      <th style="width: 10px">#</th>
                      <th>Tasks </th>
                      <th>Progress</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(stat, ind) in Utasks.tasks.data" :key="ind" >
                      <td>{{ ind+1 }}</td>
                      <td >{{ stat.text}}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" :style=" {'width':`${parseInt(100 * stat.progress)}%`}"></div>
                        </div>
                      </td>
                      <td><span v-if="`${parseInt(stat.progress*100)}`==100" class="badge bg-success" >{{ parseInt(100*stat.progress) }}%</span>
                      <span v-if="`${parseInt(100 * stat.progress)}!=100`" class="badge bg-danger" >{{parseInt(100 * stat.progress)}}%</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <pagination :data="Utasks.tasks" @pagination-change-page="getResults1"></pagination>
             </div>
             </div>
            <!-- solid sales graph -->
            <!-- /.card -->
            <!-- Calendar -->
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    </div>
</template>
<script>
    export default {
  data(){
   return{
    id: this.$route.params.id,
    projects:[],
    leaders:[],
    clients:[],
    users:[],
    stats:{
        projectstat:{}
    },
    Ustats:{
        projectstat:{}
    },
    Utasks:{
        tasks:{}
    },
    projectusers:[],
  Cprojets:{
      projects:{}
  },

  }

},
 created(){
   axios.get('api/Nprojects').then(({data}) => {this.projects=data});
   axios.get('api/Nclients').then(({data}) => {this.clients=data});
   axios.get('api/Nleaders').then(({data}) => {this.leaders=data});
   axios.get('api/Nusers').then(({data}) => {this.users=data});
   axios.get('api/stats').then(({data}) => {this.stats=data});
   axios.get('api/stats').then(({data}) => {this.stats=data});
   axios.get('api/Uprojects').then(({data}) => {this.projectusers=data});
   axios.get('api/Ustats').then(({data}) => {this.Ustats=data});
   axios.get('api/Utasks').then(({data}) => {this.Utasks=data});
   axios.get('api/Cprojets').then(({data}) => {this.Cprojets=data});
 },
 methods:{
      getResults(page = 1) {
      			axios.get('api/stats?page=' + page)
				.then(response => {
				this.stats = response.data;
                });},
                getResults1(page = 1) {
      			axios.get('api/Utasks?page=' + page)
				.then(response => {
				this.Utasks = response.data;
                });},
                 getResults2(page = 1) {
      			axios.get('api/Cprojets?page=' + page)
				.then(response => {
				this.Utasks = response.data;
                });}
 },
mounted() {
  console.log('Component mounted.')
}
}
</script>
