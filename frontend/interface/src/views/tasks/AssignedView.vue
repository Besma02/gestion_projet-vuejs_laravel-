<template>
  <div class="container">

    <h1 class="title">Task attributed</h1>

    <div class="">
      <form @submit.prevent="assignTask">
        <div class="mb-6">
          <h1 class="text-xl font-bold" >{{ task.name }}</h1>
        </div>
        <div class="mb-6">
          <label for="user_assigned_to" class="">Users</label>
          <br>
          <select v-model="selectedUser" id="user_assigned_to" class="mt-6" name="user_assigned_to">
            <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
          </select>
        </div>

        <button type="submit" class="">Assigne Task</button>
      </form>
    </div>
    <br>
    <router-link to="/dashboard/tasks" class="back"><i class="fa fa-long-arrow-left" ></i>Back</router-link>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      error: '',
      task: {},
      users: [],
      selectedUser:null
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    clearError() {
      this.error = '';
    },
    async fetchData() {
      try {
        const token = localStorage.getItem('token')
            //console.log(token)
        const taskId = this.$route.params.id; 
        const response = await axios.get("http://127.0.0.1:8000/api/task/assign/"+taskId);
        const usersResponse = await axios.get('http://127.0.0.1:8000/api/users',{
          headers: {
        'Authorization': `Bearer ${token}` 
    }
        });
     
       
       
        this.task = response.data.task;
       
        this.users = usersResponse.data.users
        // console.log(this.task)
        console.log(this.users)
      } catch (error) {
        this.error = 'Une erreur s\'est produite lors de la récupération des données.';
      }
    },
    async assignTask() {
  try {
    const taskId = this.task.id;
    const token = localStorage.getItem('token'); // Récupérer le token depuis le stockage local
    const response = await axios.post(`http://127.0.0.1:8000/api/task/assign/${taskId}`, {
      user_assigned_to: this.selectedUser
    }, {
      headers: {
        Authorization: `Bearer ${token}` // Ajouter le token aux en-têtes
      }
    });

    alert('User assigned successfully'); // Affiche le message de succès de l'API
    this.$router.push({ name: 'tasks' });

  } catch (error) {
    console.error('Erreur lors de l\'attribution de la tâche:', error);
    alert("L'utilisateur est occupé"); // Gestion d'erreur basique pour l'utilisateur
  }
}

  }
};
</script>

<style scoped>
.container{
    
    width:700px;
  
  }
 form{
  background: white;
  padding: 20px;
  margin: 5px auto;
 }
 form select
 {
  width: 100%;
  padding: 10px;
  margin-bottom: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* Ensures padding is included in the element's width and height */
}

form textarea {
  resize: vertical; /* Allows resizing vertically */
  min-height: 100px;
}
form button {
  background-color: #5d8dc0;
  color: #fff;
  border: none;
  padding: 5px 5px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

form button:hover {
  background-color: #0056b3;
}
</style>
