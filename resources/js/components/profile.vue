<template>
    <div class="container" v-if="!$acces.Admin()">
        <div class="row justify-content-center">

            <div class="col-md-12"  >
             <div class="content-wrapper"  style="min-height: 1416.81px; margin-left:50px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6" >
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->


        <div class="row">
          <div class="col-md-3"  v-for="user in users"  v-if=" user.id == key "  :key="user.id">


            <!-- Profile Image -->
            <div class="card card-primary card-outline"  >
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="`/img/profile/${ user.photo }`"   alt="User profile picture" >
                </div>
                  <h3 class="profile-username text-center">{{ user.name }}</h3>

                <p class="text-muted text-center">{{ user.role }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Projects</b> <a class="float-right">---</a>
                  </li>

                </ul>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary" >
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               <strong><i class="fas fa-phone mr-1"></i>phone</strong>

                <p class="text-muted">
                <strong>   {{ user.tel  }}</strong>
                </p>

                <hr>
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  <strong>   {{ user.education }}</strong>

                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">
                 <strong>   {{ user.location  }} </strong>
                </p>
                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                     <strong>   {{ user.skills  }}</strong>

                  <span class="tag tag-danger"></span>

                </p>

                <hr>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    <!-- Post -->

                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->

                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal"  >
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                         <div class="col-sm-10">
                            <input v-model="form.email" id="email" type="email" name="email"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                  <has-error :form="form" field="email"></has-error>
                         </div>
                        </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                         <div class="col-sm-10">
                            <input v-model="form.password" id="password" type="password" name="password"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                  <has-error :form="form" field="location"></has-error>
                         </div>
                        </div>

                      <div class="form-group row">
                        <label for="location" class="col-sm-3 col-form-label">Location</label>
                         <div class="col-sm-10">
                            <input v-model="form.location" id="location" type="text" name="location"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                  <has-error :form="form" field="location"></has-error>
                         </div>
                        </div>
                      <div class="form-group row">
                        <label for="education" class="col-sm-3 col-form-label">Education</label>
                        <div class="col-sm-10">
                            <input v-model="form.education" id="education" type="text" name="education"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('education') }">
                                  <has-error :form="form" field="education"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="skills" class="col-sm-3 col-form-label">Skills</label>
                        <div class="col-sm-10">
                             <input v-model="form.skills" id="skills" type="text" name="skills"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('skills') }">
                                  <has-error :form="form" field="skills"></has-error>
                        </div>
                      </div>
                     <div class="form-group row">
                                    <label for="photo" class="col-sm-3 col-form-label">Profile Picture</label>
                              <div class="col-sm-10">
                                        <input type="file"  name="photo"  @change="updateProfile" class="form-input" :class="{ 'is-invalid': form.errors.has('photo') }">
                                   <has-error :form="form" field="photo"></has-error>
                                    </div>


                                </div>

                      <div class="form-group row">
                        <div class="col-sm-10">
                          <button   @click.prevent="updateInfo"  type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                    </div>

                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      <!-- /.container-fluid -->
       <!-- /.content -->
  </div>

            </div>
        </div>

</div>

</template>

<script>
    export default {
        data(){
         return{
        form : new Form({
        location:'',
        eucation:'',
        photo:'',
        skills:'',
        email:'',
        password:''

       }),

             key : this.$route.params.id,
              users:[],
                roles:{},
                role:{
                    id:'',
                  role:''
                },
                user:{

                },

         }
        },
        methods:{
              afficherMembre(){
                   axios.get('/api/membrechef').then(({ data }) =>(this.users = data.data));
              },
             getProfilePhoto(){

                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },

            updateInfo(){
            this.form.put('/api/profile')
                .then(()=>{
                    fire.$emit('ajoutprofile');
                    this.form.reset();

                  Toast.fire({
                         icon: 'success',
                        title: 'Profile Updated'

                });
                location.reload();
                 })
                .catch(() => {
                                   });
            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swett({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large photo',
                    })
                    return false;
                }

                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },

        },


    created(){
                         fire.$on('ajoutprofile',()=>{
   this.afficherMembre();});
   this.afficherMembre();

    },
        mounted() {
            console.log('Component mounted.')
        }


}


</script>
