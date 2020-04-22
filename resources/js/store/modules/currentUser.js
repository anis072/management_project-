import axios from "axios";

const state ={
     user:{

     }

};
const getters= {};
const actions = {
    getUser({commit}){
        axios.post("api/userauth")
        .then(response=>{
      commit('setUser',response.data);
        });
    },
    loginUser({},user){
       axios.post("/api/login",{
           email: user.email,

           password: user.password
       })
       .then(response=>{
           console.log(response.data);
          if( response.data.acces_token){
               //save token mte3na fi locoal storage
               localStorage.setItem(
                   "membre_token",
                   response.data.acces_token
               )

               window.location.replace("/home");
           }

       })
    }
};
const mutations={
    setUser(state,data){
        state.user=data;
    }
};

export default{
    namespaced:true,
   state,
   getters,
   actions,
   mutations
}
