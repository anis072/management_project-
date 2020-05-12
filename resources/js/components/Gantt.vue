<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="currentUser.role!=='client'">
                <div class="card mr-9">

             <form @submit.prevent="Setid()">
           <input type="hidden" :value="`${ key }`" >
             </form>

              <div ref="gantt" class="gantt ml-0 "></div>


             </div>
            </div>
        </div>
             <div v-if="$acces.client()">
   <not-found></not-found>
 </div>
    </div>

</template>

<script>
import {gantt} from 'dhtmlx-gantt';
export default {
  name: 'gantt',
  props: {
    tasks: {
      type: Object,
      default () {
        return {data: [], links: []}
      }
    }
  },
data(){
    return{
           key: this.$route.params.id,
      user:JSON.parse(localStorage.getItem('user')),

    }
},
  mounted: function () {
    gantt.config.xml_date = "%Y-%m-%d";
    gantt.init(this.$refs.gantt);
    //gantt.parse(this.$props.tasks);
  },
  created(){
    gantt.load("/api/data/"+this.key);
    var dp = new gantt.dataProcessor("/api");/*!*/
    dp.init(gantt);/*!*/
   // dp.setTransactionMode("REST");
    dp.setTransactionMode({
    mode:"REST",
    payload:{
      "key":this.key
    }
}, true);
  },
   computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }
}
</script>

<style>
    @import "~dhtmlx-gantt/codebase/dhtmlxgantt.css";
    .gantt{
      position: relative;
       height: 650px;
       margin-left: 200px ;
    }
</style>
