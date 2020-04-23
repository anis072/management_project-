<template>
<div class="container">
        <div class="row justify-content-center">
      <div class="col-md-9 mt-4">
               <div class="card card-default">
          <div class="card-header" >
            <h3 class="card-title">Client :</h3>


            <div class="card-tools">
              <button type="button" class="btn btn-tool"  id="reduit" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <div class="row">
               <div v-for="client in clients.client"  v-if=" client.id == key"  :key="client.id" >
                  <div class=" ml-2">
                  <label>Name :</label>
                 <p>{{ client.name }}</p>
                  <label>Email:</label>
                 <p>{{ client.email }}</p>
                  <label>Phone:</label>
                 <p>{{ client.phone }}</p>
                 <label >Projects:</label>
                  <ul v-for="projet in projets.project"  v-if=" projet.client_id == key"  :key="projet.id">


                         <li>{{ projet.name }} </li>
                     </ul>

                     </div>

                          <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->


            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         </div>
               </div>



          <!-- /.card-body -->

            </div>
               </div>

</template>

<script>
export default {
  data(){
         return{
         key: this.$route.params.id,

    projets:[],
    projet:{
     id:'',
     name:'',
     durre:'',

     budget:''

   },
    clients:[],
    client:{
        id :'',
        name:'',
        tel:'',
        email:''

    }
         }

},

 methods:{
 afficherClients(){
  axios.get('/api/clientp')
     .then(({data}) => {this.clients=data});
 },
 afficherProjets(){
  axios.get('/api/getProjects')
     .then(({data}) => {this.projets=data});
 },

 },
mounted() {
  console.log('Component mounted.')
  this.afficherClients();
  this.afficherProjets();

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
</style>
