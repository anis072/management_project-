export default class  Acces {
     constructor(user){
       this.user=user;
     }
     Admin(){
         return this.user.role ==="admin";
     }
     NotUser(){
         return this.user.role === "admin" ||  this.user.role === "chef de projet" || this.user.role === "client" ;
     }
     Chef(){
         return this.user.role === "chef de projet";
     }
     client(){
        return this.user.role === "client";
    }
    adminchef(){
        return this.user.role === "admin" || this.user.role === "chef de projet";
    }
    chefUser(){
        return this.user.role !== "admin" || this.user.role === "chef de projet" || this.user.role !== "client"
    }
};
