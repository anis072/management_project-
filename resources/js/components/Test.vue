<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

  data(){
   return{
    id: this.$route.params.id,
    projets:[],
    projet:{
     id:'',
     name:'',
     durre:'',
     description:'',
     budget:'',
     owner:'',
   }
  }
},

 methods:{
 afficherProjets(){
  axios.get('api/getProjects')
     .then(({data}) => {this.projets=data.data});
     console.log('anis');
}
 },
mounted() {
  console.log('Component mounted.')
  this.afficherProjets();

}
}


</script>
