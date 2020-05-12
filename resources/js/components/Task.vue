<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
            <div class="card" v-if="currentUser.role !== 'client'">
              <div class="card-header">
                <h3 class="card-title">Tasks:</h3>

                <div class="card-tools">


                </div>
              </div>
              <!-- /.card-header -->
             <form >
              <div class="card-body table-responsive p-0">
                <table class="table table-hover" >
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Progression</th>
                      <th>Estimated Task duration</th>
                      <th>Created_at</th>
                      <th v-if=" currentUser.role ==='admin' || currentUser.role ==='chef de projet'">Assign to</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody >


                    <tr  v-for="task in tasks.Tasks.data "  v-if=" task.projet_id == key "   :key="task.id">
                     <router-link :to="`/taskdetail/${task.id}`"   style="text-decoration:none; color:black;">   <td >{{ task.text }}</td></router-link>
                      <td >{{ parseInt(100 * task.progress) }}% <img :src="`/img/icon/verif.png`" style="width:15px;" v-if="`${parseInt(100 * task.progress)}`==100" > </img> <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0"   id="progress" v-model="form.progress"
                             aria-valuemin="`${parseInt(100 * task.progress)}`" :style=" {'width':`${parseInt(100 * task.progress)}%`}" aria-valuemax="100"></div>
                             </div>
                        </td>
                      <td>{{ task.duration  }} day(s)</td>
                      <td>{{ task.created_at  | date }} </td>

                        <td>
    <div class="dropdown"v-if=" currentUser.role ==='admin' || currentUser.role ==='chef de projet'">
   <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-user-plus" style="color:#05dfd7;"></i>
   </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"  name="membre" >
    <a class="dropdown-item" href="#" v-for="membre in membres.users" :key="membre.id"    @click="assignTo(task.id,membre.id)"  :value="membre.id"> <img class=" img-circle float-left ml-0" :src="`/img/profile/${ membre.photo }`"
     alt="User profile picture" style="width:35px;"><span >{{ membre.name }}   </span> </a>
  </div>
</div>

</td>


                      <td v-for="membre in membres.users" :key="membre.id" v-if=" task.user_id == membre.id"   ><img class=" img-circle" :src="`/img/profile/${ membre.photo }`"
                      alt="User profile picture" style="width:35px;"><span class="ml-1" >{{ membre.name }}   </span>
                     </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              </form>
              <!-- /.card-body -->
            </div>
              <pagination :data="tasks.Tasks" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
         <div v-if="$acces.client()">
   <not-found></not-found>
 </div>
               <!-- Modal -->
    </div>
</template>



<script>

    export default {
        data(){
            return{
               key : this.$route.params.id,
                form : new Form({
                id:'',
                name:'',
                email:'',
                password:'',
                tel:'',
                progress:''
                }),
                tasks:{
                    Tasks:{}
                },
                task:{
                    id:'',
                    name:'',
                    progress:'',
                },

                membres:[],
                membre:{
                name:''
                },
                users:[],
                user:{
                name:'',
                photo:''
                },
                hasparent:'',
                warns:[],
                warn:{

                }


            }
        },

               methods:{
                   getResults(page = 1) {
			axios.get('/api/tasks?page=' + page)
				.then(response => {
					this.tasks = response.data;
				});},
                 afficherTasks(){
                   axios.get('/api/tasks').then(({data})=>(this.tasks =data));

               },
               warning(){
                 axios.get('/api/warn').then(({data})=>(this.warns =data));
               },
            afficherMembres(){
                   axios.get('/api/membret/'+this.key).then(({ data }) =>(this.membres = data));
                   },
              //     afficherUser(){
                //   axios.get('/api/userTask').then(({ data }) =>(this.users = data.data));
                  // },
            assignTo($id,$membre){
             axios.post('/api/taskassign/'+$id+'/'+$membre).then(()=>{

                 fire.$emit('addtask');
                Toast.fire({
                        icon: 'success',
                        title: 'Task assigned successfully'
                        })

                }).catch(()=>{

                });
            },
           tree(){
               var toggler = document.getElementsByClassName("caret");
                var i;

            for (i = 0; i < toggler.length; i++) {
              toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
              });
            }
           }

             },
             created(){
                axios.get('/api/hasparent').then(({ data }) =>(this.hasparent = data));
              this.tree();

             //  this.afficherUser();
               this.afficherTasks();

               this.afficherMembres();

                   fire.$on('addtask',()=>{
                     this.afficherTasks();
                 });


             },
             computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
             }


    }
</script>
<style scoped>
</style>
