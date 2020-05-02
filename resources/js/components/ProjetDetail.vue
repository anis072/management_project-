<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
         <div class="card">
        <div class="card-header">
          <h3 class="card-title">Project Detail</h3>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Project Files:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
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
        <div class="card-body" >
          <div class="row"  v-for="projet in projets.project"  v-if=" projet.id == key"  :key="projet.id">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center ">Name</span>
                      <span class="info-box-number text-center  mb-0">{{ projet.name }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center">Budget</span>
                      <span class="info-box-number text-center  mb-0">{{ projet.budget }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center "> Duration</span>
                      <span class="info-box-number text-center  mb-0">{{ projet.duration }} <span>
                    </span></span></div>
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
                       <div v-for="comment in comments.comment"  :key="comment.id"   v-if=" key == comment.commentable_id  "  class=" align-items mt-3">
                            <span class="badge badge-primary"> {{ comment.comment_user_name }}</span >&nbsp;&nbsp; <span style="color:black;">{{ comment.body }}</span>
                            &nbsp;&nbsp;&nbsp; <b> <small class="badge badge-success" style="float:right; color:#2d132c " >Posted at {{ comment.created_at || date }} </small></b>
                                   <div v-for="commentreply in commentsreply.commentreply"  :key="commentreply.id"   v-if=" comment.id == commentreply.commentable_id "  class=" align-items mt-3">
                                   <i class="fas fa-reply"></i><span class="badge badge-primary ml-4"> {{ commentreply.comment_user_name }}</span >&nbsp;&nbsp;<span style="color:black;"> {{ commentreply.body }}
                     </span> &nbsp;&nbsp;&nbsp; <b> <small class="badge badge-success" style="float:right; color:#2d132c " >Posted at {{ commentreply.created_at || date }} </small></b>
                            </div>
                    <div>   <button @click="showbtn(comment.id)"   class="btn btn-default"  >Reply</button></div>
                        <hr>
                            <form    type="post"  @submit.prevent="ajouterCommentaireReponse(comment.id)"  v-bind:id="comment.id "  class="d-none">
                         <div class="input-group input-group-sm mt-2 ml-2">
                            <input class="form-control form-control-sm" name="replycomment"  v-model="form1.body" type="text"
                                                   :class="{ 'is-invalid': form1.errors.has('body') }"  placeholder="commenter.." style="width:450px;" required>
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
                <div  v-for="projet in projets.project"  v-if=" projet.id == key"  :key="projet.id">
              <h3 class="text-primary" style="font-weight:bolder;"> {{ projet.name }}</h3>
              <p class="">{{ projet.description }}</p>
              <h4 class="text-primary">Client</h4>
              <p><u><strong>{{ projet.owner }}</strong></u></p>
              </div>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Role/position</th>
                    </tr>
                  </thead>
                   <tbody>
                   <tr v-for="membre in membres.membres"   :key="membre.id"  >
                     <td> <img class=" img-circle float-left ml-0" :src="`/img/profile/${ membre.photo }`"
                      alt="User profile picture" style="width:35px;"></td>
                     <td> {{ membre.name }}  </td>
                     <td>{{ membre.role }}</td>
                   </tr>
                 </tbody>
                </table>
                <form @submit="formSubmit" enctype="multipart/form-data">
              <h5 class="mt-5 "><strong> Project files </strong><button type="submit"  class="btn btn-sm btn-primary">Add files</button></h5>
              <div  v-for="file in files.files" :key="file.id">
              <ul class="list-unstyled">
                <li>
                  <a href="" class="btn-link text-secondary"><a style="text-decoration:none; color:black;"  :href="`//127.0.0.1:8000/upload/${file.file}`" target="_blank">
                   <i class="fas fa-file-alt"></i>{{ file.file }}</a></a>
                </li>
              </ul>
              </div>

                <div class="inline-block" id="upload">
                <button class="btn" id="btn" >Upload a file</button>
                <input type="file" name="file" v-on:change="onFileChange"/>
                </div>
            <div v-if="errors && errors.file" class="text-danger">{{ errors.file[0] }}</div>
                 </form>
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
                projets:[],
                projet:{
                id:'',
                name:'',
                duration:'',
                description:'',
                budget:'',
                owner:'',},
                membres:[],  membre:{   id :'',name:'',role:'', },
                form : new Form({id:'',body:'',user:'',}),
                 form1 : new Form({id:'',body:'',user:'',}),
                comments:{comment:{}},comment:{id:'',body:'',created_at:''},
                commentsreply:{
                    commentreply:{}
                    },
                commentreply:{
                  id:'',
                  body:'',
                  created_at:''
                },
                   files:{
                       files:{}
                   },
                   errors:{},
               name: '',
              file:{
                name:'',
                id:''
              },
              success: ''
                 }},
                 methods:{
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

                axios.post('/api/formSubmit/'+this.key, formData, config)
                .then(function (response) {
                    fire.$emit('ajoutdetail');
                    currentObj.success = response.data.success;
                })
                .catch((error)=> {
                     if (error.response.status === 422 || error.response.status === 413) {
                   this.errors = error.response.data.errors || {};
        }
                });
            },
            afficherProjets(){
            axios.get('/api/getProjects')
                .then(({data}) => {this.projets=data});},
            afficherMembre(){
            axios.get('/api/membreid/'+this.key).then(({data})=> {this.membres = data});},
            ajouterCommentaire(){
                this.form.post('/api/comments/'+this.key).then(()=>{
                                    fire.$emit('ajoutcommentaire');
                this.form.reset()})},
            ajouterCommentaireReponse(commentId){
            this.form1.post('/api/commentsreponse/'+ commentId)
            .then(()=>{
                fire.$emit('ajoutcommentaire');
               this.form1.reset();
            })
            },

            afficherComments(){
            axios.get('/api/comments').then(({data})=> {this.comments =data});},
            // afficherComments(){
            //axios.get('/api/commentsreply').then(({data})=> {this.commentsreply =data.data});},
            showbtn(id){
                let element= document.getElementById(id);
                element.classList.toggle('d-none');},
            have(){
                let key = document.getElementById("pm").innerHTML;
                return key;},
            showreply(){
             axios.get('/api/commentreply').then(({data})=> {this.commentsreply =data});},
            },

                created(){
                    fire.$on('ajoutdetail',()=>{
                 axios.get('/api/file/'+this.key).then(({data}) => {this.files =data});
                    }),
                    axios.get('/api/file/'+this.key).then(({data}) => {this.files =data});
                    fire.$on('ajoutcommentaire',()=>{
                this.afficherComments();});
                      fire.$on('ajoutcommentaire',()=>{
                this.showreply();

                 });

                },
            mounted()
            {
            console.log('Component mounted.')
            this.afficherProjets();
            this.afficherMembre();
            this.afficherComments();
            this.showreply();

            }
            }
            </script>
<style lang="css" scoped>
.card-header{
    background-color :#007bff;
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
  font-size: 15px;
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


