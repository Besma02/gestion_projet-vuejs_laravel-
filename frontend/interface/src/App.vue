

<template>
<div>
<Header title="Co-work"/>

  <RouterView />
</div>
</template>
<script >
import { RouterLink, RouterView } from 'vue-router'
import Header from'./components/Header.vue'
export default{
  components:{
    Header
  }
}
</script>

<style >
.form input,.add input{
   display :block;
   margin: 20px auto;
   width:300px;
   height: 30px;
   border: 1px solid skyblue;
   padding: 5px;
}
.btn,.add button {
    display :block;
    margin: 20px auto;
   background: skyblue;
   width:310px;
   border:none;
   color:white;
   cursor: pointer;
   padding:10px;
}
.title{
    text-align: center;
}
.link{
   text-decoration: none;
   display: block;
   text-align: center;
   
}
body{
   padding: 0;
   margin: 0;
}

table{
    margin: 0 auto;
    background:  white;
   width: 680px;
   border-collapse: collapse;
   font-size: 16px;

 
}


.headtab{
    background: #5d8dc0;
    padding: 20px;
    color: white;
    font-size: 16px;
}
 th,
td {
  padding: 12px 15px;
  
}
.editUser{
    text-decoration: none;
   
}

 tbody tr {
  border-bottom: 1px solid #dddddd;
}
.back{
    text-decoration: none;
    margin-left: 25%;
   
   
}


</style>
