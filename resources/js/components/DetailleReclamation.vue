<template>
<div class="container">
        <div class="row justify-content-center">
      <div class="col-md-9 mt-4">
               <div class="card card-default">
          <div class="card-header" >
            <h3 v-if="$acces.client()" class="card-title">Your reclamation :</h3>
             <h3 v-if="!$acces.client()" class="card-title"> Complaint processed:</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool"  id="reduit" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row"  v-for="reclamation in reclamations.complain"  v-if=" reclamation.id == key"  :key="reclamation.id">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
             <div class="row">
              <div class="col-12 col-sm-6">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" >Type:</span>
                      <span class="info-box-number text-center  mb-0">{{ reclamation.type }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" >Project:</span>
                      <span class="info-box-number text-center  mb-0">{{ reclamation.nameProjet }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6" v-if="!$acces.client()">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center">Membre assigned:</span>
                      <span class="info-box-number text-center  mb-0">{{ reclamation.nameEmp}}</span>
                    </div>
                  </div>
                </div>
                 <div class="col-12 col-sm-6" >
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center">creation date:</span>
                      <span class="info-box-number text-center  mb-0">{{ reclamation.created_at | date }}</span>
                    </div>
                  </div>
                </div>
                  <div class="col-12 col-sm-6" v-if="!$acces.client()">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center">Client claimed:</span>
                      <span class="info-box-number text-center  mb-0">{{  reclamation.nameClient}}</span>
                    </div>
                  </div>
                </div>
            </div>
            <!-- /row -->
            </div>
               <!-- col-12 col-md-12 col-lg-8 order-2 order-md-1/ -->

         <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2" >
            <div  v-for="reclamation in reclamations.complain"  v-if=" reclamation.id == key"  :key="reclamation.id">
            <h4 class="info-box-text">Description :</h4>
              <p>{{ reclamation.description }}</p>
             <h5 class="mt-2  info-box-text"><strong> Project files : </strong></h5>
             <div  v-for="file in files.files" :key="file.id">
              <ul class="list-unstyled">
                  <div>
                <li class="row">
               <a href="#" class="btn-link text-secondary"> <a style="text-decoration:none; color:black;"  :href="`//127.0.0.1:8000/upload/${file.file}`" target="_blank">
                   <i class="fas fa-file-alt"></i>&nbsp; {{ file.file }}</a></a>
                </li>
                </div>
              </ul>
           </div>
               <h4 class="info-box-text"> Advancement:</h4>
                 <p v-if="$acces.client() && reclamation.avancement == 'Pending Team leader validation' "> In progress  </p>
                 <p v-if="$acces.client() && reclamation.avancement != 'Pending Team leader validation'"> {{ reclamation.avancement }}  &nbsp; &nbsp;
                   <img :src="`/img/icon/verif.png`" style="width: 30px;" v-if="reclamation.avancement == 'Finished'"> </img> </p>
                 <p v-if="!$acces.client()">{{ reclamation.avancement }} &nbsp; &nbsp;
                   <img :src="`/img/icon/verif.png`" style="width: 30px;" v-if="reclamation.avancement == 'Finished'"> </img> </p>
             <div class="progress">
              <div class="progress-bar progress-bar-striped bg-success" role="progressbar"  :style=" {'width': `${parseInt(reclamation.progress)}%`}" aria-valuenow="`${parseInt(reclamation.progress)}`" aria-valuemin="0" aria-valuemax="100"> {{reclamation.progress}} %</div>
             </div> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; <br>
                 <button v-if="!$acces.NotUser() && reclamation.avancement != 'Finished'" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierReclamation" @click="idReclamation(reclamation.id)"  >Edit Advancement</button>
             </div>
              </div>
             </div>
          </div>
          <!-- /.card-body -->
         </div>
    <div  id="print">
               <div v-for="reclamation in reclamations.complain"  v-if=" reclamation.id == key"  :key="reclamation.id" >
                  <div class=" ml-2">
                    <h2 style="color: blue;"> <u> Complain Details: </u></h2> <br>
                  <label>Type :</label>
                 <p>{{ reclamation.type }}</p>
                  <label>Project:</label>
                 <p>{{ reclamation.nameProjet }}</p>
                  <label> Description:</label>
                 <p>{{ reclamation.description }}</p>
                <label v-if="!$acces.client()"> Membre assigned  </label>
                <p v-if="!$acces.client()">{{ reclamation.nameEmp }}</p>
                 <label> Advancement:</label>
                 <p>{{ reclamation.avancement }} &nbsp;   <img :src="`/img/icon/verif.png`" style="width: 30px;" v-if="reclamation.avancement == 'Finished'"> </img>
                 </p>
                 <label > creation date:</label>
               <p>{{ reclamation.created_at | date }}</p>
                  <label v-if="!$acces.client()" >Client claimed:</label>
                <p v-if="!$acces.client()">{{ reclamation.nameClient}}</p>
                     </div>
                          <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
         <button class="btn btn-primary hidden-print" v-print="'#print'"> <i class="fas fa-print"></i> Print</button>
               </div>

          <!-- /.card-body -->
            </div>

          <form @submit.prevent=" modifier()">
            <div class="modal fade" id="modifierReclamation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  id="exampleModalLabel">Edit Advancement:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>

                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" >
                <label>Advancement:</label>
            <select v-model="form.etat" type="text" name="etat"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('etat') }">
                    <option value="" disabled selected>Select claim advancement</option>
                    <option value="In progress">In progress</option>
                    <option value="Pending Team leader validation">Finished</option>
                </select>
                <has-error :form="form" field="type"></has-error>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                    <button type="submit" class="btn btn-primary" >Edit</button>
                </div>
                </div>
            </div>
            </div>
                </form>

</div>
</div>
</template>
<script>
export default {
  data(){
         return{
         key: this.$route.params.id,
         idRec: '',
          x:false,
          form : new Form({
                id:'',
                etat:'',
          }),
    reclamations:[],
    reclamation:{
     id:'',
     type:'',
     description:'',
     avancement: '',
     chef_id: '',
     nameProjet: '',
     employe_id: '',
     projet_id: '',
     client_id: '',
     nameClient:'',
     nameEmp:'',
   },
    files:[],
      name: '',
     file:{
     name:'',
     id:''
     },
       user:JSON.parse(localStorage.getItem('user')),
         }
},
 methods:{
 afficherReclamation(){
  axios.get('/api/complain')
     .then(({data}) => {this.reclamations=data});
     },
     modifier(){
       this.form.put('/api/reclamation/'+ this.idRec).then(()=>{
                fire.$emit('modifierreclamation');
                $("#modifierReclamation").modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Avancement modifié'
                        })
                }).catch(()=>{
                });
     },
     idReclamation(id){
       this.idRec= id;
     },
 },
 created() {
     let axiosConfig = {
                    headers: {
                    "Authorization": 'Bearer '+this.user['token']
                    }
                    };
   axios.get('/api/filesComplain/'+this.key,axiosConfig).then(({data}) => {this.files =data});

          },
mounted() {
  console.log('Component mounted.')
  this.afficherReclamation();
 fire.$on('modifierreclamation',()=>{
                     this.afficherReclamation();
                 });
}
}
</script>
<style lang="css" scoped>
.card-header{
    background-color:#007bff;
}
.card-title {
    color: aliceblue;
}
#reduit{
    color:blanchedalmond;
}
.info-box-text{
   color :#007bff;
   font-weight: bolder;
}
   #print {display: none;}
            @media print {
                #print {display: block;}
            }
</style>
