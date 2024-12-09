<template>
   
 
  <div class="form">
  <h1 class="title">Register</h1>
  <input type="text" placeholder="name" v-model="name"/>
  <input type="email" placeholder="email" v-model="email"/>
  <input type="password" placeholder="password" v-model="password"/>
  <input type="password" placeholder="password_confirmation" v-model="password_confirmation"/>
  <button @click="signUp" class="btn-btnAuth">Register</button>
  <router-link to="login" class="link">Go to Login</router-link>
  

</div>

</template>

<script>
import axios from 'axios';

export default {
   data(){
    return{
        name:'',
        email:'',
        password:'',
        password_confirmation:''
    }
   },
   methods:{
    async signUp(){
    let response=await axios.post('http://127.0.0.1:8000/api/auth/register',{
        name:this.name,
        email:this.email,
        password:this.password,
        password_confirmation:this.password_confirmation
        })
        console.log(response)
        if(response.status==201){
            localStorage.setItem('user',JSON.stringify(response.data))
            this.$router.push({name:'login'})
        }
    }
   },
   mounted(){
    let user=localStorage.getItem('user')
    if(user){
        this.$router.push({name:'login'})
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