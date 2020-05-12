import store from './store'
export default class  Acces {


     Admin(){
         return store.getters.currentUser.role ==="admin";
     }
     NotUser(){
         return store.getters.currentUser.role === "admin" ||  store.getters.currentUser.role === "chef de projet" ||store.getters.currentUser.role === "client" ;
     }
     Chef(){
         return store.getters.currentUser.role === "chef de projet";
     }
     client(){
        return store.getters.currentUser.role === "client";
    }
    adminchef(){
        return store.getters.currentUser.role === "admin" || store.getters.currentUser.role === "chef de projet";
    }
    chefUser(){
        return store.getters.currentUser.role !== "admin" || store.getters.currentUser.role === "chef de projet" || user.role !== "client"
    }
};
