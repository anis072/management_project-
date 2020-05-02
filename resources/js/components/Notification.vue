<template>
<ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                   <a class="nav-link" data-toggle="dropdown"  href="#" @click="MarkNotificationAsRead()">
                     <i class="fa fa-bell" style='font-size:30px;' v-if="`${unreadNotifications.length}`!=0"></i>
                    <i class='fas fa-bell-slash' style='font-size:30px' v-if="`${unreadNotifications.length}`==0"></i>
                    <span class="badge badge-danger navbar-badge" v-if="`${unreadNotifications.length}`!=0">{{unreadNotifications.length}}</span>
                   </a>
                 <div class="dropdown-menu dropdown-menu-right">
                        <a v-if="`${unreadNotifications.length}`==0" class="dropdown-item"><strong>No notifications</strong></a>
                    <div v-for="unread in unreadNotifications" :key="unread.id">
                            <li v-if=" unread.data.typeNotification === 'App\\Notifications\\NewProject'" >
                            <router-link :to="`/detail/${unread.data.idprojet}  `" class="dropdown-item" >
                            <i class="fas fa-user-shield"></i>
                                <span class=""> New Project {{unread.data.projet}}</span>
                            </router-link>
                            </li>

                           <li v-if="unread.data.typeNotification == 'App\\Notifications\\reclamationNotification'">
                            <router-link to="/reclamation" class="dropdown-item" >
                            <i class="fas fa-exclamation"></i>
                                <span class=""> New  {{unread.data.projet}} Reclamation</span>
                            </router-link>
                                </li>

                        <li v-if="unread.data.typeNotification == 'App\\Notifications\\reclamationAssigned'">
                        <router-link :to="`/detailleReclamation/${unread.data.idrec}  `" class="dropdown-item" >
                        <i class="fas fa-exclamation"></i>
                         <span class=""></span> New {{unread.data.projet}} Reclamation
                        </router-link>
                            </li>

                         <li v-if="unread.data.typeNotification == 'App\\Notifications\\NewProjectCommentaire'">
                        <router-link :to="`/detail/${unread.data.idprojet}  `" class="dropdown-item" >
                        <i class="fas fa-comments"></i>
                            <span class=""></span> New commentaire of {{unread.data.projet}}
                        </router-link>
                            </li>

                            <li v-if="unread.data.typeNotification == 'App\\Notifications\\ResponseProjectCommentaire'">
                            <router-link :to="`/detail/${unread.data.idprojet}  `" class="dropdown-item" >
                            <i class="fas fa-comments"></i>
                                <span class=""></span> Response of your  {{unread.data.projet}} project Comment
                            </router-link>
                          </li>

                        <li v-if="unread.data.typeNotification == 'App\\Notifications\\NewTask'" class="notification-box">
                         <router-link :to="`/taskdetail/${unread.data.idTask}  `" class="dropdown-item" >
                         <i class="fas fa-tasks"></i>
                         <span class="col-md-3 col-sm-3">  New Task on  {{unread.data.projet}} project</span>
                         </router-link>
                         </li>


                    <li v-if="unread.data.typeNotification == 'App\\Notifications\\NewTaskComment'">
                        <router-link :to="`/taskdetail/${unread.data.idTask} `" class="dropdown-item" >
                        <i class="fas fa-comments"></i>
                            <span class="">  New {{unread.data.task}} task Comment</span>
                        </router-link>
                      </li>

                             <li v-if="unread.data.typeNotification == 'App\\Notifications\\TaskReplyComment'">
                        <router-link :to="`/taskdetail/${unread.data.idTask}  `" class="dropdown-item" >
                        <i class="fas fa-comments"></i>
                            <span class=""></span>  Response of your {{unread.data.task}} task Comment
                        </router-link>
                            </li>
                             <li v-if="unread.data.typeNotification == 'App\\Notifications\\ComplaintFinished'">
                        <router-link :to="`/detailleReclamation/${unread.data.idrec}`" class="dropdown-item" >
                        <i class="fas fa-check" style="font-size:28px;color:green"></i> &nbsp;
                            <span class=""></span> Complaint is Full Finished
                        </router-link>
                            </li>

                               <li v-if="unread.data.typeNotification == 'App\\Notifications\\SendComplaintToLeader'">
                            <router-link to="/reclamation" class="dropdown-item" >
                            <i class="fas fa-exclamation"></i> &nbsp;
                                <span class=""></span> Complaint ready to Verify
                            </router-link>
                                </li>
                                  <li v-if="unread.data.typeNotification == 'App\\Notifications\\AlertComplaint'">
                                <router-link :to="`/detailleReclamation/${unread.data.idrec}`" class="dropdown-item" >
                                <i class="fas fa-times-circle" style="font-size:28px;color:red"></i> &nbsp;
                                    <span class=""></span>Complaint not ready to finished
                                </router-link>
                                 </li>
                   </div>
                    </div>
                </li>
            </ul>

</template>
<script>
    export default {
      props :['unreads','userid'],
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
document.getElementById("notify_audio").play();
    });
        }
    }
</script>
