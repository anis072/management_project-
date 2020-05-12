<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Configuration:</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form   @submit.prevent="modifierdonnées()">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1"> Email:</label>
                    <input type="email" class="form-control"  placeholder="Votre Email" name="email" v-model="form.email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"   placeholder="Mot De passe" name="password" v-model="form.password">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit</button>
                </div>
              </form>
              <form @submit.prevent="ajoutrole()" v-if="currentUser.role==='admin'" >
                <div class="card-body">
                   <div class="form-group">
                    <label > Add Position Or Role:</label>
                    <input  v-model="form.role" type="text" :class="{ 'is-invalid': form.errors.has('budget') }" class="form-control"  name="role" placeholder="Poste or Role">
                 <has-error :form="form" field="role"></has-error>
                  </div>
                 </div>
                 <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Record</button>
                </div>
              </form>
              <form   @submit.prevent="AddType()">
                <div class="card-body">
                 <div class="form-group">
                    <label > Add Claim Type:</label>
                    <input  v-model="form.type" type="text" :class="{ 'is-invalid': form.errors.has('budget') }" class="form-control"  name="type" placeholder="Claim Type">
                 <has-error :form="form" field="type"></has-error>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
   data(){
        return{
   form : new Form({
           id:'',
           role:'',
           password:'',
           email:'',
           type:''
       }),
           }
   },
        name:'setting',
        methods: {
            ajoutrole(){
                this.form.post('api/role').then(()=>{
                this.form.reset();
                Toast.fire({
                        icon: 'success',
                        title: 'Role Added'
                        })
                }).catch(()=>{
                });;
            },
            modifierdonnées(){
this.form.post('api/updateuserconnecte/').then(()=>{
                this.form.reset();
                Toast.fire({
                        icon: 'success',
                        title: 'Data updated'
                        })
                }).catch(()=>{
                });;;
            },
                  AddType(){
                this.form.post('api/type').then(()=>{
                this.form.reset();
                Toast.fire({
                        icon: 'success',
                        title: 'Type Added'
                        })
                }).catch(()=>{
                });;
            },
        },
        
             computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
   
    }
    }

</script>
