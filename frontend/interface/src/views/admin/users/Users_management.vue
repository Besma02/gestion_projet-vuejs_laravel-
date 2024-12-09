<template>
    <div class="">
       
    <h1 class="title">Users List</h1>
  
    
    <table >
        <thead class="headtab">
            <tr>
                <th scope="col" class="">
                    Name
                </th>
                <th scope="col" class="">
                    Email
                </th>
                <th scope="col" class="">
                    Roles
                </th>
                <th scope="col" class="">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody v-for="user in users" :key="user.id">
            
                <tr class="">
                    <td scope="row" >
                       {{user.name}}
                    </td>
                    <td class="">
                        <router-link to="#" class=""> {{user.email}}</router-link>
                    </td>
                    <td class="" >
                        <div v-for="role in user.roles" :key="role.name">
                            {{role.name}} 
                        </div>
                
                    </td>
                    <td class="">
                    
                        <router-link :to="{name:'editUser',params:{id:user.id}}" class="editUser">Edit</router-link>
                    </td>
                </tr>
           
        </tbody>
       
    </table>
   
    <router-link to="/" class="back"><i class="fa fa-long-arrow-left" ></i> Back</router-link>
   
</div>

  
</template>

<script>
import axios from 'axios';
import Dashboard from '../../Dashboard.vue';
export default {
   components:{Dashboard},
    data(){
        return{
           users:[]

        }
    },
    created(){
        this.getUsers()

    },
     methods:{
       
        async getUsers(){
            const token = localStorage.getItem('token')
            //console.log(token)
            let url='http://127.0.0.1:8000/api/users'
            await axios.get(url, {
    headers: {
        'Authorization': `Bearer ${token}` 
    }
})
            .then(response=>{
                this.users=response.data.users
                

            })
               
                .catch(error=>console.log(error))
        }
       

    },
    mounted(){
        console.log('all users')
    }


}
</script>

<style>



</style>