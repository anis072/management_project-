<template>
     <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" @click="MarkNotificationAsRead()">
         <i class="fa fa-bell" style='font-size:30px;' v-if="`${unreadNotifications.length}`!=0"></i>
          <i class='fas fa-bell-slash' style='font-size:30px' v-if="`${unreadNotifications.length}`==0">
         </i>
          <span class="badge badge-danger navbar-badge" v-if="`${unreadNotifications.length}`!=0">{{unreadNotifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

      <span v-if="`${unreadNotifications.length}`==0" class="text-center ml-3"><strong>No notifications </strong></span>



       <ul v-for="unread in unreadNotifications" :key="unread.id" >
          <li v-if=" unread.data.typeNotification === 'App\\Notifications\\NewProject'" >
       <router-link :to="`/detail/${unread.data.idprojet}  `" class="dropdown-item" >
       <i class="fas fa-user-shield"></i>
        <span class="float-right text-muted text-sm"></span> New Project {{unread.data.projet}}

       </router-link>
          </li>
          <hr></hr>
           <li v-if="unread.data.typeNotification == 'App\\Notifications\\reclamationNotification'">
       <router-link :to="`/detailleReclamation/${unread.data.idrec}  `" class="dropdown-item" >
       <i class="fal fa-lightbulb-exclamation"></i>
        <span class="float-right text-muted text-sm"></span> New  {{unread.data.projet}} Reclamation

       </router-link>
          </li>
           <li v-if="unread.data.typeNotification == 'App\\Notifications\\reclamationAssigned'">
       <router-link :to="`/detailleReclamation/${unread.data.idrec}  `" class="dropdown-item" >
       <i class="fal fa-lightbulb-exclamation"></i>
        <span class="float-right text-muted text-sm"></span> New {{unread.data.projet}} Reclamation

       </router-link>
          </li>
           <li v-if="unread.data.typeNotification == 'App\\Notifications\\NewProjectCommentaire'">
       <router-link :to="`/detail/${unread.data.idprojet}  `" class="dropdown-item" >
       <i class="fas fa-comments-alt"></i>
        <span class="float-right text-muted text-sm"></span> New commentaire of {{unread.data.projet}}

       </router-link>
          </li>
             <li v-if="unread.data.typeNotification == 'App\\Notifications\\ResponseProjectCommentaire'">
       <router-link :to="`/detail/${unread.data.idprojet}  `" class="dropdown-item" >
       <i class="fas fa-comments-alt"></i>
        <span class="float-right text-muted text-sm"></span> Response of your  {{unread.data.projet}} project Comment

       </router-link>
          </li>
               <li v-if="unread.data.typeNotification == 'App\\Notifications\\NewTask'">
       <router-link :to="`/taskdetail/${unread.data.idTask}  `" class="dropdown-item" >
       <i class="fas fa-comments-alt"></i>
        <span class="float-right text-muted text-sm"></span>  New Task on  {{unread.data.projet}} project

       </router-link>
          </li>
                <li v-if="unread.data.typeNotification == 'App\\Notifications\\NewTaskComment'">
       <router-link :to="`/taskdetail/${unread.data.idTask}  `" class="dropdown-item" >
       <i class="fas fa-comments-alt"></i>
        <span class="float-right text-muted text-sm"></span>  New {{unread.data.task}} task Comment
       </router-link>
          </li>
                   <li v-if="unread.data.typeNotification == 'App\\Notifications\\TaskReplyComment'">
       <router-link :to="`/taskdetail/${unread.data.idTask}  `" class="dropdown-item" >
       <i class="fas fa-comments-alt"></i>
        <span class="float-right text-muted text-sm"></span>  Response of your {{unread.data.task}} task Comment

       </router-link>

          </li>
          <li v-if="unread.data.typeNotification == 'App\\Notifications\\ComplaintFinished'">
       <router-link :to="`/detailleReclamation/${unread.data.idrec}`" class="dropdown-item" >
       <i class="fas fa-check" style="font-size:28px;color:green"></i> &nbsp;
        <span class="float-right text-muted text-sm"></span> Complaint is Full Finished
       </router-link>
          </li>
                 <li v-if="unread.data.typeNotification == 'App\\Notifications\\SendComplaintToLeader'">
       <router-link :to="`/detailleReclamation/${unread.data.idrec}`" class="dropdown-item" >
       <i class="fas fa-exclamation"></i> &nbsp;
        <span class="float-right text-muted text-sm"></span> Complaint ready to Verify
       </router-link>
          </li>
          </ul>
        </div>
      </li>

</template>

<script>
//import NotificationItem from './NotificationItem.vue';
    export default {
      props :['unreads','userid'],
     // components:{NotificationItem},
      data (){
       return {
           unreadNotifications: this.unreads,      }
      },
      methods:{
 MarkNotificationAsRead() {
  if(this.unreadNotifications.length){
    axios.post('/markAsRead')
  }
}
      },
        mounted() {
           Echo.private('App.User.'+ this.userid)
    .notification((notification) => {
        console.log(notification);
let newUnreadNotifications={data:{idprojet:notification.idprojet,user:notification.user,projet:notification.projet,idrec:notification.idrec,type:notification.type,typeNotification:notification.typeNotification,idTask:notification.idTask,task:notification.task}};
this.unreadNotifications.push(newUnreadNotifications);
    });
         }
    }
</script>

