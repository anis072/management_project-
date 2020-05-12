<template>
    <div class="container">
        <div class="row justify-content-center">
           <div class="col-sm-12 mt-4" >
            <div class="card" >
              <div class="card-header">
                <h3 class="card-title"> Projects:</h3>
                <div class="card-tools">
                      <button class="btn btn-success ml-6 mb-3"  @click="newer" ><i class="fas fa-project-diagram"></i> Add</button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Client</th>
                      <th scope="col">Description</th>
                      <th scope="col">Duration</th>
                      <th scope="col">Budget </th>
                      <th scope="col">advancement</th>
                      <th scope="col">Operation</th>
                    </tr>
                  </thead>
                  <tbody>
                   <tr v-for="projet in projets.projets.data" :key="projet.id" >
                 <td scope="row"> <router-link :to="`/detail/${projet.id}`" style="text-decoration:none; color:black;">{{ projet.name }}</router-link></td>
                      <td>
                       {{ projet.owner }}
                       </td>
                      <td><a  style=""  href="#" @click="chargerid(projet.description)" class="btn btn-secondary" data-toggle="modal" data-target="#description"><i class="fas fa-sticky-note"></i></a></td>
                      <td>{{ projet.duration }}</td>
                      <td>{{projet.budget}}</td>
                       <td >{{ parseInt(projet.progress) }}% <img :src="`/img/icon/verif.png`" style="width:15px;" v-if="`${parseInt(projet.progress)}`==100" > </img> <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0"   id="progress" v-model="form.progress"
                             aria-valuemin="`${parseInt(projet.progress)}`" :style=" {'width':`${parseInt(projet.progress)}%`}" aria-valuemax="100"></div>
                             </div>
                        </td>
                      <td><a href="#" class="btn" style="background-color: #00a8cc" @click="editProjet(projet)" ><i style="color:#fff" class="fas fa-user-edit"></i></a>
                       <a href="#" class="btn btn-danger" @click="deleteProjet(projet.id)" ><i class="fas fa-trash-alt"></i></a>
                     </td>
<!-- Modal -->
<div class="modal fade" id="description" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {{ desc }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
               </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <pagination :data="projets.projets" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
 <div >
   <not-found></not-found>
 </div>
        <div class="modal fade" id="AjouterProjet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
        <h5 class="modal-title" v-show="!x" id="exampleModalLabel">Add Project:</h5>
         <h5 class="modal-title" v-show="x" id="exampleModalLabel">Edit Project:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form @submit.prevent=" x ? modifier():ajouterProjet()">
          <div class="modal-body">
          <div class="form-group">
      <label>Name</label>
      <input v-model="form.name" type="text" name="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
     <div class="form-group">
      <label>Client</label>

      <select v-model="form.client"   type="text" name="client"
        class="form-control" :class="{ 'is-invalid': form.errors.has('client') } "   >
        <option value="" disabled selected>Select Client</option>
        <option v-for ="(client , index) in clients.client" :key="index" v-bind:value="client.id">{{ client.name }}</option>
      </select>
      <has-error :form="form" field="client"></has-error>
    </div>

        <div class="form-group" v-show="!x">
      <label >Team leader</label>
      <select v-model="form.leader" type="text" name="leader"
        class="form-control" :class="{ 'is-invalid': form.errors.has('leader') }">
        <option value="" disabled selected>Select Team leader</option>
         <option v-for ="(chef , index) in chefs.Chef" :key="index" v-bind:value="chef.id">{{ chef.name }}</option>

      </select>
      <has-error :form="form" field="leader"></has-error>

    </div>
    <div v-show="!x">
                <label>Membres</label>
                <select   v-model="form.membre" type="text" name="membre[]" class="form-control" :class="{ 'is-invalid': form.errors.has('membre') } " multiple="multiple">
                  <option value="" disabled selected>Select membres</option>
                  <option v-for="(membre , index) in membres.User" :key="index" v-bind:value="membre.id">
                        {{ membre.name }}
                  </option>
                </select>
                <has-error :form="form" field="membre"></has-error>
     </div>

     <div class="form-group" >
      <label>Duration</label>
      <input v-model="form.duration" type="text" name="duration"
        class="form-control" :class="{ 'is-invalid': form.errors.has('duration') } ">
      <has-error :form="form" field="duration"></has-error>
    </div>

     <div class="form-group">
      <label>Description</label>
      <textarea v-model="form.description" type="text" name="description"
        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
      <has-error :form="form" field="description"></has-error>
    </div>
     <div class="form-group">
      <label>Budget</label>
      <input v-model="form.budget" type="text" name="budget"
        class="form-control" :class="{ 'is-invalid': form.errors.has('budget') }">
        <has-error :form="form" field="budget"></has-error>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" v-show="!x" class="btn btn-primary" >Add</button>
        <button type="submit" v-show="x" class="btn btn-primary" >Edit</button>
      </div>
      </form>
    </div>

  </div>

</div>
<!-- chef de projet-->

    </div>
</template>

<script>
import { setAuthorization } from "../helpers/general";
    export default {
             data(){
                 return{
                     x:false,
              AuthStr : localStorage.getItem('membre_token'),
              projets:{
                  projets:{},
              },
              projet:{
                  id:''
              },

            desc:'',
       form : new Form({
           id:'',
           name:'',
           duration:'',
           description:'',
           budget:'',
           owner:'',
           membres: "",
        client:"",
        membre: [],
        leader:'',
        chefs:""


       }),

           clients:{
               clients:{}
           },

           client:{
              id:'',
              name:'',
          },
            membres: {
                User:{},
            },
           membre: {
            id: "",
           name: ""
            },
      projetusers:[],
      projetuser:{
          id: "",
           name: ""

      },
      chefs:{
          Chef:{}
      },
      chef:{
          id:'',
          name:''
      },
        user:JSON.parse(localStorage.getItem('user')),
                 }
             },


         created(){
           
          //   axios.get('api/getc');
    axios.get('api/progress').then(({ data }) =>(this.progress = data.data));
      this.afficherClient();
      this.afficherMembres();
      this.afficherProjet();
      this.afficherChef();

   fire.$on('ajoutprojet',()=>{
       this.afficherProjet();
                 });

                       },
           methods:{
                getResults(page = 1) {
      			axios.get('api/projet?page=' + page)
				.then(response => {
				this.projets = response.data;
                });},
                afficherProjet(){
                let axiosConfig = {

                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                };
                  axios.get('/api/projet',axiosConfig).then(({ data }) =>(this.projets = data));
                },
               ajouterProjet(){
                     this.$Progress.start()
                this.form.post("api/projet").then(()=>this.form.post('api/chefdeprojet').then(()=>this.form.post('api/userprojet').then(()=>{
                fire.$emit('ajoutprojet');
                this.$Progress.finish()
                this.form.reset();
                $("#AjouterProjet").modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Project Added'

                })

                }).catch((response)=>{ console.log(response);


                 })));
                    },

             deleteProjet(id){
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
                this.form.delete('api/projet/' + id).then(function(){
                seww.fire(
                    'Delete!',
                    'Project deleted.',
                    'success'
                    )

             fire.$emit('ajoutprojet');

                }).catch(()=>{
                    seww.fire(
                    'Failure !!!!'
                    );
                });
           }
            })
            },
              modifier(){
               this.form.put('api/projet/'+ this.form.id).then(function(){
               $('#AjouterProjet').modal('hide')
                    seww.fire(
                    'Edit!',
                    'Your Project has been Updated.',
                    'success'
                    )
                    fire.$emit('ajoutprojet');
             }).catch(function(){
             })
            },
              editProjet(projet){
                  this.x=true;
               $("#AjouterProjet").modal('show');
               this.form.fill(projet)
              },
              newer(){
                  this.x=false
                  this.form.reset();

           $("#AjouterProjet").modal('show')
              },
               afficherClient(){
                   axios.get('api/clientp').then(({data})=>(this.clients =data));

               },
               chargerid($description){
                     this.desc=$description;
                   },

                    afficherMembres() {
                axios.get("api/membrep").then(({ data }) => (this.membres = data));
                       },
                   afficherChef(){
                axios.get("api/chef").then(({ data }) => (this.chefs = data));

                   },



                      },
            name:'project'
           }


</script>
