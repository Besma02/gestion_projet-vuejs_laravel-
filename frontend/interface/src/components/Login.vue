<template>
   
 
  <div class="form">
  <h1 class="title">Login</h1>
  <input type="email" placeholder="email" v-model="email"/>
  <input type="password" placeholder="password" v-model="password"/>
   <button @click="login" class="btn-btnAuth">Login</button>
   <router-link to="register" class="link">Not subscribe !Register</router-link>
   <p v-if="errorMessage">{{ errorMessage }}</p>
  
</div>

</template>

<script>
import axios from 'axios';

export default {
   data(){
    return{
       
        email:'',
        password:'',
        errorMessage: ''
       
    }
   },
   methods:{
    async login() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
          email: this.email,
          password: this.password
        });
        
       
        
        localStorage.setItem('user',JSON.stringify(response.data))
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
        this.$router.push({name:'home'})
         
        // Handle successful login (e.g., save token, redirect to dashboard)
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.message;
        } else {
          this.errorMessage = 'An error occurred during login.';
        }
      }
     
    }
   },
   mounted(){
    let user=localStorage.getItem('user')
    if(user){
        this.$router.push({name:'home'})
    }
}
   
  
}
</script>

<style>

.btn-btnAuth{
  display :block;
    margin: 20px auto;
   background: skyblue;
   width:310px;
   border:none;
   color:white;
   cursor: pointer;
   padding:10px;

}

</style>