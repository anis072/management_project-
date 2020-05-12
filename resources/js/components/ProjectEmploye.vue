<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-4">
        <div class="card"  v-if="!$acces.Admin()">
          <div class="card-header">
            <h3 class="card-title"> Projects:</h3>

            <div class="card-tools" v-if="$acces.Chef()">
              <button class="btn btn-success ml-6 mb-3"  @click="newer" ><i class="fas fa-project-diagram"></i> Add</button>
              <div class="input-group input-group-sm" style="width: 150px;"></div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Client</th>
                  <th>Duration</th>
                  <th>Avancemant</th>
                  <th>Description</th>
                  <th>Budget</th>
                  <th v-if="$acces.Chef()">Operation</th>


                </tr>
              </thead>
              <tbody>
                <tr v-for="projet in projets" :key="projet.id">
                  <router-link
                    :to="`/detail/${projet.id}`" style="text-decoration:none; color:black;">
                    <td>{{ projet.name }}</td>
                  </router-link>
                  <td>{{ projet.owner }}</td>

                  <td>{{ projet.duration }}</td>

                   <td >{{ parseInt(projet.progress) }}% <img :src="`/img/icon/verif.png`" style="width:15px;" v-if="`${parseInt(projet.progress)}`==100" > </img> <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0"   id="progress" v-model="form.progress"
                             aria-valuemin="`${parseInt(projet.progress)}`" :style=" {'width':`${parseInt(projet.progress)}%`}" aria-valuemax="100"></div>
                             </div>
                        </td>
                     <td ><a  style=""  href="#" class="btn btn-secondary" data-toggle="modal" data-target="#description" @click="chargerid(projet.description)"><i  class="fas fa-sticky-note"></i></a></td>


                  <td >{{projet.budget}}</td>
                           <td v-if="$acces.Chef()"><a href="#" class="btn" @click="editProjet(projet)"  style="background-color: #00a8cc"><i style="color:#fff" class="fas fa-user-edit"></i></a>
                           <a href="#" class="btn btn-danger" @click="deleteProjet(projet.id)" ><i class="fas fa-trash-alt"></i></a></td>

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
      </div>
<div v-if="$acces.Admin()">
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
        <option value="" disabled selected> Select Client </option>
        <option v-for = "(client , index) in clients.client" :key="index" v-bind:value="client.id">{{ client.name }}</option>
      </select>
      <has-error :form="form" field="client"></has-error>
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
    </div>
  </div>


</template>

<script>
export default {
  data() {
    return {
       x:false,
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
        membre: []

       }),

           clients:[],
           client:{
              id:'',
              name:'',
          },
            membres: [],
           membre: {
            id: "",
           name: ""
            },
      projetusers:[],
      projetuser:{
          id: "",
           name: ""

      },
      chefs:[],
      chef:{
          id:'',
          name:''},
      projets:{},
      projet:{
          user_id:'',
          name:'',

      },
        user:JSON.parse(localStorage.getItem('user')),
    }
  },

  created(){


    this.afficherClient();
      this.afficherMembres();
      this.afficherProjet();


   fire.$on('ajoutprojet',()=>{
  this.afficherProjet();
                 });

         },
  methods: {
            afficherProjet(){
                let axiosConfig = {
                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                    };
            axios.get("/api/getProjectsUserConnecte",axiosConfig).then(({ data }) => (this.projets = data));
            },
             ajouterProjet(){
                this.form.post("api/projet")
        .then(()=>axios.post('api/chefdeprojetparchef').then(()=>this.form.post('api/userprojet').then(()=>{
                fire.$emit('ajoutprojet');
                this.form.reset();
                $("#AjouterProjet").modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Projet Ajouter'

                })

                }).catch((response)=>{ console.log(response);


                 })));


                    },
             deleteProjet(id){
           seww.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas revenir en arrière!",
            icon: 'warning',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Supprimer!'
            }).then((result) => {
           if(result.value){
                    this.form.delete('api/projet/' + id).then(function(){

                    seww.fire(
                    'Supprimer!',
                    'Le projet est supprimer.',
                    'success'
                    )

             fire.$emit('ajoutprojet');

                }).catch(()=>{
                    seww.fire(
                    'Échec !!!!'


                    );
                });
           }
                })
            },
            modifier(){

               this.form.put('api/projet/'+ this.form.id).then(function(){

             $('#AjouterProjet').modal('hide')

                    seww.fire(
                    'Modifier!',
                    'Your User has been Updated.',
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
                      let axiosConfig = {
                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                    };
                   axios.get('api/clientp',axiosConfig).then(({data})=>(this.clients =data));

               },

                    afficherMembres() {
                    let axiosConfig = {
                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                    };
                axios.get("api/membrep",axiosConfig).then(({ data }) => (this.membres = data));
                       },
                     chargerid($description){
                     this.desc=$description;
                   },


  },
  computed:{


  },
  name:'projectemploye'

}
</script>
