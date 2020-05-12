<template>
  <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4" v-if="currentUser.role ==='admin'" >
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Project team leaders:</h3>

                <div class="card-tools">

                  <button class="btn btn-success ml-6 mb-3"  data-toggle="modal" data-target="#AjouterMembre" @click="newer"><i class="fas fa-user-shield"></i> Add </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Created_at</th>
                      <th>Operation</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="user in users.Chef.data" :key="user.id">
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.phone }}</td>
                      <td>{{ user.created_at | date }}</td>
                      <td >
           <span class="btn" style="background-color: #00a8cc" @click="editMembre(user)">  <i style="color: #fff" class="fas fa-user-edit"  ></i></span>
                  <span class="btn btn-danger" @click="supprimerMembre(user.id)">  <i  class="fas fa-trash-alt"  ></i></span>



                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
             <pagination  :data="users.Chef" @pagination-change-page="getResults" ></pagination>
            </div>
        </div>

        <!-- Modal -->
 <div v-if="!$acces.Admin()">
     <not-found></not-found>
     </div>
    <form @submit.prevent="x ? misajour(): ajouterMembre()">
<div class="modal fade" id="AjouterMembre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

         <h5 class="modal-title" v-show="!x" id="exampleModalLabel">Add team leader:</h5>
         <h5 class="modal-title" v-show="x" id="exampleModalLabel">Edit team leader:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
      <label>Name</label>
      <input v-model="form.name" type="text" name="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
     <div class="form-group">
      <label>Email</label>
      <input v-model="form.email" type="text" name="email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
    </div>
     <div class="form-group">
      <label>Password</label>
      <input v-model="form.password" type="password" name="password"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
    </div>

    <div class="form-group">
      <label>Phone</label>
      <input v-model="form.phone" type="text" name="phone"
        class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
      <has-error :form="form" field="phone"></has-error>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="submit" v-show="!x" class="btn btn-primary" >Add</button>
        <button type="submit"  v-show="x" class="btn btn-primary" >Edit</button>
      </div>
    </div>
  </div>
</div>
    </form>
</div>
</template>



<script>
    export default {
        data(){
            return{
                 user:JSON.parse(localStorage.getItem('user')),
                 x:false,
                users:{
                  Chef:{}
                },
                form : new Form({
                id:'',
                name:'',
                email:'',
                password:'',
                phone:'',
                role:'',

                })
            }
        },

               methods:{
             getResults(page = 1) {
      			axios.get('api/chefwP?page=' + page)
				.then(response => {
				this.users = response.data;
                });
           },
               afficherMembre(){
                     let axiosConfig = {

                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                };
                   axios.get('api/chefwP',axiosConfig).then(({ data }) =>(this.users = data));
                   },
               ajouterMembre(){
                this.form.post('api/ajouterChefDeProjet').then(()=>{
                fire.$emit('ajoutmembre');
                $("#AjouterMembre").modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Team leader added'
                        })
                }).catch(()=>{
                });
                },
                misajour(){

               this.form.put('api/membre/'+ this.form.id).then(function(){
                $('#AjouterMembre').modal('hide')
                    seww.fire(
                    'Edit!',
                    'Your User has been Updated.',
                    'success'
                    )
                    fire.$emit('ajoutmembre');

             }).catch(function(){

             })
            },
              editMembre(user){
                  this.x=true;
               $("#AjouterMembre").modal('show');
               this.form.fill(user)
              },
              newer(){
                  this.x=false
                  this.form.reset();
           $("#AjouterMembre").modal('show')
              },
                supprimerMembre(id){
                     seww.fire({
            title: 'Are you sure?',
            text: "You will not be able to go back!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Supprimer!'
            }).then((result) => {
           if(result.value){
                    this.form.delete('api/membre/'+id).then(function(){
                    seww.fire(
                    'Delete!',
                    'member deleted.',
                    'success'
                    )
             fire.$emit('ajoutmembre');
                }).catch(()=>{
                    seww.fire(
                    'Failure !!!!'
                    );
                });
           }
                })
            }
             },
             created(){
                 this.afficherMembre();
                  fire.$on('ajoutmembre',()=>{
                     this.afficherMembre();
                 });
             },
              computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        },

    }
</script>
<style scope="">
.card-title{
 font-size: 25px;
}
</style>
