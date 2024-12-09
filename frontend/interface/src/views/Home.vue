<template>
    <div class="container">
      <h1 >Home Page</h1>
      <p class="text" >Welcome to the home page</p>
      <router-link to="/dashboard">Go to Dashboard</router-link>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Home',
    mounted(){
      let user=localStorage.getItem('user')
      if(!user){
        this.$router.push({name:'signUp'})
    }
    }
   
}
  </script>
  
  <style scoped>
 .text{
  color: black;
 }
.container{
display: block;
 margin: auto
}

  </style>
  