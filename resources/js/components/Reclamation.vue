<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Complains:</h3>
                <div class="card-tools" v-if="currentUser.role==='client'">
                <button class="btn btn-success ml-6 mb-3" data-toggle="modal" data-target="#ajouterReclamation" ><i class="fas fa-user"></i> Create </button>
                </div>
              </div>
              <!-- /.card-header -->
                <div class="">
                <table class="table ">
                  <thead>
                    <tr>
                      <th scope="col">Type</th>
                      <th scope="col">Description</th>
                      <th v-if="currentUser.role!=='client'" scope="col"> Advancement </th>
                      <th v-if="currentUser.role==='client'" scope="col"> Advancement </th>
                      <th scope="col">Project</th>
                      <th  scope="col">Created_at</th>
                     <th v-if="currentUser.role !=='client'" scope="col"> client </th>
                     <th v-if="currentUser.role!=='client'" scope="col">Assign to</th>
                     <th v-if="currentUser.role==='admin' || currentUser.role==='chef de projet'" scope="col"> </th>
                     <th v-if="currentUser.role==='admin' || currentUser.role==='chef de projet'" scope="col"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="reclamation in reclamations.complain.data" :key="reclamation.id">
                       <router-link :to="`/detailleReclamation/${reclamation.id}`" style="text-decoration:none; color:black;">  <td scope="row">{{reclamation.type}}</td> </router-link>
                       <td><a  style=""  href="#" @click="chargerid(reclamation.description)" class="btn btn-secondary" data-toggle="modal" data-target="#description"><i class="fas fa-sticky-note"></i></a></td>
                      <td v-if="currentUser.role !=='client'"> {{reclamation.avancement}} </td>
                      <td v-if="currentUser.role ==='client'"><h6 v-if="reclamation.avancement == 'Pending Team leader validation'">In progress</h6>
                      <h6 v-if="reclamation.avancement != 'Pending Team leader validation'">  {{reclamation.avancement}}</h6>
                      </td>
                      <td>{{reclamation.nameProjet}}</td>
                      <td v-if="!$acces.adminchef()">{{ reclamation.Created_at  | date }}</td>
                      <td v-if="currentUser.role !=='client'"> {{reclamation.nameClient}} </td>
                     <td v-if="currentUser.role==='admin' || currentUser.role==='chef de projet'">
                      <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-plus" style="color:#05dfd7;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"  name="membre" >
                          <a class="dropdown-item" href="#" v-for="membre in membres.User" :key="membre.id"  @click="assignTo(reclamation.id,membre.id)"  :value="membre.id"> <img class=" img-circle float-left ml-0" :src="`/img/profile/${ membre.photo }`"
                          alt="User profile picture" style="width:35px;"><span >{{ membre.name }}   </span> </a>
                        </div>
                      </div>
                      </td>
                      <td v-for="membre in membres.User" :key="membre.id" v-if=" reclamation.employe_id == membre.id && currentUser.role !=='client' "><img class=" img-circle" :src="`/img/profile/${ membre.photo }`"
                      alt="User profile picture" style="width:35px;"><span class="ml-1" >{{ membre.name }}   </span>
                      </td>
                      <td v-if="$acces.adminchef()">
                        <a href="#" @click="Valider(reclamation.id)" v-if="reclamation.avancement == 'Pending Team leader validation' ">
                          <i class="fas fa-check" style="font-size:28px;color:green"> </i> </a>
                          <a href="#" @click="Alert(reclamation.id)" v-if="reclamation.avancement == 'Pending Team leader validation'">
                          <i class="fas fa-times-circle" style="font-size:28px;color:red"></i>
                        </a>
                      <img :src="`/img/icon/verif.png`" style="width:40px;" v-if="reclamation.avancement == 'Finished'">
                      <a href="#" class="btn btn-danger" @click=" deleteReclamation(reclamation.id)" v-if="reclamation.avancement == 'Finished'"><i class="fas fa-trash-alt"></i></a>
                        </td>
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
            <pagination :data="reclamations.complain" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        <!-- Modal -->
    <form  @submit.prevent="ajouterReclamtion" enctype="multipart/form-data">
<div class="modal fade" id="ajouterReclamation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title"  id="exampleModalLabel">Add Reclamation:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group" >
      <label>Type</label>
  <select v-model="form.type" type="text" name="type"
        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
        <option value="" disabled selected>Select type</option>
         <option v-for = "(type , index) in types.type" :key="index" v-bind:value="type.type">{{ type.type }}</option>
      </select>
      <has-error :form="form" field="type"></has-error>
    </div>
    <div class="form-group">
      <label>Project</label>
      <select v-model="form.project"   type="text" name="project"
        class="form-control" :class="{ 'is-invalid': form.errors.has('project') } "   >
        <option value="" disabled selected>Select your project</option>
        <option v-for = "(projet , index) in projets.projects" :key="index" v-bind:value="projet.id">{{ projet.name }}</option>
      </select>
      <has-error :form="form" field="project"></has-error>
     </div>
      <div class="form-group" >
      <label>Description</label>
      <textarea v-model="form.description" type="text" name="description"
        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
      <has-error :form="form" field="description"></has-error>
     </div>

      <div class="upload-btn-wrapper" id="upload">
      <button class="btn" id="btn" >Upload a file</button>
      <input type="file" name="file" v-on:change="onFileChange"/>
      <div v-if="errors && errors.file" class="text-danger">{{ errors.file[0] }}</div>
      </div>

       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button  type="submit" class="btn btn-primary" >Add</button>
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
                    x:false,
                    idrec:'',
                reclamations:{
                    complain:{}
                },
                reclamation:{
                    id:''
                },
                errors:{},
                 types:{},
                type:{
                    id:'',
                  type:''
                },
                form : new Form({
                id:'',
                type:'',
                description:'',
                nameProjet:'',
                employe_id:'',
                client_id:'',
                project:'',
                nameClient:'',
                file:'',
                avancement:'',
                }),
                    projets:[],
                     projet:{
              id:'',
              name:'',
          },
          desc:'',
            membres: [],
           membre: {
            id: "",
           name: ""
            },
            }
        },
               methods:{

                   getResults(page = 1) {
			      axios.get('/api/reclamation?page=' + page)
				   .then(response => {
					this.reclamations = response.data;
                });},
                   afficherReclamation(){
                 axios.get('/api/reclamation').then(({ data }) =>(this.reclamations = data));
                },

                   afficherProjet(){
                   axios.get('api/projetRec').then(({ data }) =>(this.projets = data));
                   },
                    afficherMembres(){
                   axios.get('api/membrep').then(({ data }) =>(this.membres = data));
                   },
                     onFileChange(e){
                        console.log(e.target.files[0]);
                        this.file = e.target.files[0];
                    },
               ajouterReclamtion(){
                let currentObj = this;
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append('file', this.file);
                this.form.post('api/reclamation').then(()=>axios.post('api/complainfile',formData, config).catch((error)=> {
                     if (error.response.status === 422 || error.response.status === 413) {
                   this.errors = error.response.data.errors || {};  }
                }).then(()=>{
                fire.$emit('ajoutreclamation');
                $("#ajouterReclamation").modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Complains created'
                        })
                           currentObj.success = response.data.success;



                }).catch(function (error) {
                    currentObj.output = error;
                                    }));
                },
              chargerid($description){
                     this.desc=$description;
                   },
                 assignTo($id,$membre){
             axios.post('/api/reclamationassign/'+$id+'/'+$membre).then(()=>{
                 fire.$emit('addcomplaint');
                Toast.fire({
                        icon: 'success',
                        title: 'Complaint assigned successfully'
                        })
                }).catch(()=>{
                });
                },
                    Valider($id){
             axios.post('/api/reclamationTerm/'+$id).then(()=>{
                 fire.$emit('ComplaintCompleted');
                Toast.fire({
                        icon: 'success',
                        title: 'Complaint full completed'
                        })
                }).catch(()=>{
                });
            },
                 Alert($id){
             axios.post('/api/reclamationAlert/'+$id).then(()=>{
                 fire.$emit('alert');
                Toast.fire({
                        icon: 'success',
                        title: 'send alert successfly'
                        })
                }).catch(()=>{
                });
            },
             getType(){
                      axios.get('/api/type').then(({data})=>{
                this.types = data;
                      });
                  },
                       deleteReclamation(id){
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
                    this.form.delete('api/reclamation/' + id).then(function(){
                    seww.fire(
                    'Delete!',
                    'Complain deleted.',
                    'success'
                    )
             fire.$emit('ComplaintCompleted');
                }).catch(()=>{
                    seww.fire(
                    'Failure !!!!'
                    );
                });
           }
                })
            },
             },
             created(){

                 this.afficherReclamation();
                   fire.$on('ajoutreclamation',()=>{
                     this.afficherReclamation();
                 });
                this.afficherProjet();
                this. afficherMembres();
                   fire.$on('addcomplaint',()=>{
                     this.afficherReclamation();
                 });
                        fire.$on('ComplaintCompleted',()=>{
                     this.afficherReclamation();
                 });
                 this.getType();
             },
      computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }

    }
</script>
<style scoped>
#upload {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

#btn {
  border: 2px solid #007bff;
  color: #007bff;
  background-color: white;
  padding: 8px 8px;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
}

#upload input[type=file] {
  font-size: 40px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>
