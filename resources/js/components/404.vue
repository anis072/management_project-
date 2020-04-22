<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">



 <body>
  <div class="wrap">
   <div class="logo">
    <h1>404</h1>
    <p>  PAGE NON TROUVÉE!!!!!</p>

   </div>
  </div>

 </body>
     </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style lang="css" scoped>
body{
	font-family: 'Courgette', cursive;
}
body{
	background:#f3f3e1;
}
.wrap{
	margin:0 auto;
	width:100%;
}
.logo{
	margin-top:50px;
}
.logo h1{
	font-size:200px;
	color:#007bff;
	text-align:center;
	margin-bottom:1px;
	text-shadow:1px 1px 6px #fff;
}
.logo p{
	color:#007bff;
	font-size:50px;
	margin-top:1px;
	text-align:center;
}
.logo p span{
	color:lightgreen;
}
.sub a{
	color:white;
	background:#8F8E8C;
	text-decoration:none;
	padding:7px 120px;
	font-size:13px;
	font-family: arial, serif;
	font-weight:bold;
	-webkit-border-radius:3em;
	-moz-border-radius:.1em;
	-border-radius:.1em;
}

/* -- //Responsive code -- */
</style>



</style>
