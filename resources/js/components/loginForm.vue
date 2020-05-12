<template>
   <div class="login row justify-content-center mt-50">
        <div class="col-md-6 ">
            <div class="card ">
              <div class="card-header" style="background-color: #1567d8;"><span class="align-middle" style="font-size:19px;color:seashell; ">
                  <i class="fas fa-user" ></i>   <b>Join The Team</b></span></div>
                <div class="card-body">
                    <form @submit.prevent="authenticate">
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input type="email" v-model="form.email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group row">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        <div class="form-group row" v-if="authError">
                            <p class="error">
                                {{ authError }}
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  </div>
</template>
<script>

 import {login} from '../helpers/auth';
export default {
        name: "login",
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: null
            };
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login');

                login(this.$data.form)
                    .then((res) => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: '/home'});
                    })
                    .catch((error) => {
                        this.$store.commit("loginFailed", {error});
                    });
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError;
            }
        }
}
</script>
<style scoped>
.error {
    text-align: center;
    color: red;

}
.login{
    margin-top: 75px !important;
}
</style>
