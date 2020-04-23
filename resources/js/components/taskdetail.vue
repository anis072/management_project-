<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
         <div class="card">
        <div class="card-header">
          <h3 class="card-title">Task Detail</h3>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-body">
               <form @submit="formSubmit" enctype="multipart/form-data">
                 <label for="name">Name</label>
                   <input id="name" class="form-control" type="text" name="name"></input>
                 <div class="input-group mt-2"><div class="custom-file"><input type="file" name="file" v-on:change="onFileChange" class="custom-file-input"> <label for="exampleInputFile" class="custom-file-label">
                     Choose file:</label></div></div>
                      <button  class="btn btn-success mt-2">Submit</button>
               </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        </div>
          <div class="card-body" style="display: block;">
           <div class="row"  v-for="task in tasks"  v-if=" task.id == key"  :key="task.id">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="row">
               <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" style="color: blue;">Name</span>
                      <span class="info-box-number text-center  mb-0">{{ task.text }}</span>
                    </div>
                  </div>
                </div>
                 <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" style="color: blue;">Progression:</span>
                      <span class="info-box-number text-center  mb-0">{{ parseInt(100 * task.progress) }}%</span>
                    </div>
                  </div>
                </div>
                     <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" style="color: blue;">Created_at</span>
                      <span class="info-box-number text-center  mb-0">{{ task.duration  }} {{ task.created_at | date }}</span>
                    </div>
                  </div>
                </div>
                  <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" style="color: blue;">Estimated Task duration: </span>
                      <span class="info-box-number text-center  mb-0">{{ task.duration  }} day(s)</span>
                    </div>
                  </div>
                </div>
                   <div class="col-12 col-sm-4"  v-for="(membre,index) in membres" :key="index" v-if="membre.id == task.user_id ">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center" style="color: blue;"
                      >
                      Assign to</span>
                      <span class="info-box-number text-center  mb-0"
                      >
                      <img class=" img-circle float-left ml-0" :src="`/img/profile/${ membre.photo }`"
                      alt="User profile picture" style="width:30px;"> &nbsp;
                   {{membre.name}}</span>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="col-12">
                  <h4>Comments:</h4>
                    <div class="post">
                       <div class="form-group" style="display: inline;" >
                            <form @submit.prevent="ajouterCommentaire()">
                            <div class="input-group input-group-sm mb-0">
                            <input class="form-control form-control-sm" v-model="form.body" type="text" name="body"
                            :class="{ 'is-invalid': form.errors.has('body') }"  placeholder="commenter.." style="width:450px;" required>
                            <has-error :form="form" field="body"></has-error>
                                    <div class="input-group-append">
                                            <button type="submit" class="btn btn-success " >Comment</button>
                                    </div>
                                    </div>
                            </form>
                      </div>
                       <div v-for="comment in comments"  :key="comment.id"   v-if=" key == comment.commentable_id  "  class=" align-items mt-3">
                            <span class="badge badge-primary"> {{ comment.comment_user_name }}</span >&nbsp;&nbsp; <span style="color:black;">{{ comment.body }}</span>
                            &nbsp;&nbsp;&nbsp; <b> <small class="badge badge-success" style="float:right; color:#2d132c " >Posted at {{ comment.created_at || date }} </small></b>
                                   <div v-for="commentreply in commentsreply"  :key="commentreply.id"   v-if=" comment.id == commentreply.commentable_id "  class=" align-items mt-3">
                                   <i class="fas fa-reply"></i><span class="badge badge-primary ml-4"> {{ commentreply.comment_user_name }}</span >&nbsp;&nbsp;<span style="color:black;"> {{ commentreply.body }}
                     </span> &nbsp;&nbsp;&nbsp; <b> <small class="badge badge-success" style="float:right; color:#2d132c " >Posted at {{ commentreply.created_at || date }} </small></b>
                            </div>
                        <button @click="showbtn(comment.id)"   class="btn btn-default"  >Reply</button>
                        <hr>
                            <form    type="post"  @submit.prevent="ajouterCommentaireReponse(comment.id)"  v-bind:id="comment.id "  class="d-none">
                         <div class="input-group input-group-sm mt-2 ml-2">
                            <input class="form-control form-control-sm" name="replycomment"  v-model="form1.body" type="text"
                                                   :class="{ 'is-invalid': form1.errors.has('body') }"  placeholder="commenter.." style="width:450px;">
                            <has-error :form="form1" field="replycomment"></has-error>
                                    <div class="input-group-append">
                                            <button type="submit" class="btn btn-success "  >Comment</button>
                                    </div>
                          </div>
                            </form>
                            </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2" >
               <h5 class="mt-5 "><strong> &nbsp; &nbsp; Project files : </strong></h5>
              <div  v-for="file in files" :key="file.id">
              <ul class="list-unstyled">
                <li>
                  <a href="" class="btn-link text-secondary"><a style="text-decoration:none; color:black;"  :href="`//127.0.0.1:8000/upload/${file.file}`" target="_blank">
                   <i class="fas fa-file-alt"></i>{{ file.file }}</a></a>
                </li>
              </ul>
              </div>
              <div class="text-center mt-5 mb-3">
                <a href="#"  data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-primary">Add files</a>
              </div>
           </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data(){
         return{
         key: this.$route.params.id,
    tasks:[],
   task:{
     id:'',
     type:'',
   },
    form : new Form({id:'',body:'',user:'',}),
    form1 : new Form({id:'',body:'',user:'',}),
   comments:[],
   comment:
   {id:'',body:'',created_at:''},
    commentsreply:[],
     commentreply:{
      id:'',
     body:'',
      created_at:''},
      files:[],
      name: '',
     file:{
     name:'',
     id:''
     },
      membres:[],
                membre:{
                name:''
                },
}},
 methods:{       afficherMembre(){
                   axios.get('/api/membretask/').then(({ data }) =>(this.membres = data));
                  },
                afficherTask(){
                  axios.get('/api/tasks')
                   .then(({data}) => {this.tasks=data.data});
                       },
      ajouterCommentaire(){
                this.form.post('/api/commentst/'+this.key).then(()=>{
                                    fire.$emit('ajoutcommentaire');
                this.form.reset()})},
            ajouterCommentaireReponse(commentId){
            this.form1.post('/api/commentsreponset/'+ commentId)
            .then(()=>{
                fire.$emit('ajoutcommentaire');
               this.form1.reset();
            })
            },
            afficherComments(){
            axios.get('/api/commentst').then(({data})=> {this.comments =data.data});},
            // afficherComments(){
            //axios.get('/api/commentsreply').then(({data})=> {this.commentsreply =data.data});},
            showbtn(id){
                let element= document.getElementById(id);
                element.classList.toggle('d-none');},
            have(){
                let key = document.getElementById("pm").innerHTML;
                return key;
                },
            showreply(){
             axios.get('/api/commentreply').then(({data})=> {this.commentsreply =data.data});
             },
                   onFileChange(e){
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('/api/formSubmitt/'+this.key, formData, config)
                .then(function (response) {
                    fire.$emit('ajoutdetail');
                    $("#exampleModal").modal('hide');
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            },
        },
created(){
   fire.$on('ajoutdetail',()=>{
    axios.get('/api/filet/'+this.key).then(({data}) => {this.files =data.data});
    }),
   axios.get('/api/filet/'+this.key).then(({data}) => {this.files =data.data});
fire.$on('ajoutcommentaire',()=>{
  this.afficherComments();}),
  fire.$on('ajoutcommentaire',()=>{
  this.showreply();
  }),
this.afficherTask();
this.afficherComments();
this.showreply();
this.afficherMembre();
},
mounted() {
  console.log('Component mounted.')
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
.inputfile{
    border-radius: 3px;
}
</style>
