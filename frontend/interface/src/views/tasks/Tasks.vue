<template>
    
    <div>
       
    <div v-if="successMessage" class="bg-green-100 border mt-2 text-green-700 px-4 py-3 rounded relative" role="alert">
      <span class="block sm:inline">{{ successMessage }}</span>
      <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="clearSuccessMessage">
        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <title>Close</title>
          <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
      </span>
    </div>
     
      <h1 class="title">All tasks</h1>
          <table >
          <thead class="headtab">
            <tr>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Content</th>
              <th scope="col" class="px-6 py-3">Statut</th>
              <th scope="col" class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="task in tasks" :key="task.id" class="">
              <th scope="row" class="">{{ task.name }}</th>
              <td class="">
                {{ task.description }}
              </td>
              <td class="">
                <router-link to="#" class="statusColor">{{ task.status }}</router-link>
              </td>
              <td class="apiLink">
                <router-link :to="{name:'assignView',params:{id:task.id}}" class="">Attribuer</router-link>
                <router-link :to="{name:'show',params:{id:task.id}}" class="">View</router-link>
                <router-link :to="{name:'editTask',params:{id:task.id}}" class="">Edit</router-link>
                <button @click="deleteTask(task.id)"  class="btn-delete">Remove</button>
              </td>
            </tr>
          </tbody>
        </table>
     
      <br>
      <router-link to="/" class="back"><i class="fa fa-long-arrow-left" ></i> Back</router-link>
    </div>
  </template>
  
  <script>
import axios from 'axios';

  export default {
    props: {
    id: ''
  },
    data() {
      return {
        successMessage: '', 
        token:'',
        tasks: [] 
      };
    },
    methods: {
      clearSuccessMessage() {
        this.successMessage = '';
      },
      fetchTasks() {
      
      const token = localStorage.getItem('token');
      //console.log(token)
   
      
      if (token) {
        axios.get('http://127.0.0.1:8000/api/tasks', {
    headers: {
        'Authorization': `Bearer ${token}` // replace 'token' with your actual token
    }
}).then(response => {
          this.tasks = response.data.tasks;
        })
        .catch(error => {
          console.error('Error tasks fetching :', error);
        });
      }else{
       
  console.log('Token not found or expired');
  // Handle scenario where token is missing or expired, e.g., redirect to login

      }
    },
      
    async deleteTask(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
    try {
      const response = await axios.delete(`http://127.0.0.1:8000/api/task/delete/${id}`);
      console.log(response.data.message);
      
      // Suppression locale de la tâche dans la liste
      this.tasks = this.tasks.filter(task => task.id !== id);

      // Pas besoin de recharger la page
    } catch (error) {
      console.error(error);
    }
  }
},

        },
      
    mounted() {
      this.fetchTasks(); // Charger les tâches à l'initialisation du composant
    }
  };
  </script>
  
  <style scoped>
.apiLink{
  display: flex;
  justify-content: space-between;
 cursor: pointer;
}
.statusColor {
  text-decoration: none;
}
.btn-delete{
  background: rgb(249, 111, 111);
  color: white;
  border: none;
  border-radius: 20px;
}

  </style>
  