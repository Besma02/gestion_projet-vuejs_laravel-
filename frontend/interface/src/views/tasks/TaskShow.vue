<template>
  <div>
  <div class="container">
    <div v-if="task">
      <h1 class="text-center text-black-500 mb-3 mt-10" >{{ task.name || 'No Title' }}</h1>
      <p class="text-center text-gray-500 mb-3 mt-10">{{ task.description || 'No Description' }}</p>

      <div class="text-center text-gray-200 mb-3 mt-10">
        <span class="">
          Publié par user_id: 
          {{ task.user_created_by || 'Unknown' }}
        </span>
        
        <span class="time" >
          {{ formatDate(task.created_at) || 'Date non disponible' }}
        </span>
      </div>
      
     
    </div>
   
    <div v-else>
      <p>Loading task details...</p>
    </div>
    
  </div>
  <router-link :to="{ name: 'tasks' }" class="back">
        <i class="fa fa-long-arrow-left" ></i> Back
      </router-link>
    </div>
</template>

<script>
import axios from 'axios';
import { formatDistanceToNow } from 'date-fns';

export default {
  data() {
    return {
      task: null, // Store the selected task details
    };
  },
  async created() {
    await this.fetchTask(); // Fetch task details on component creation
  },
  methods: {
    async fetchTask() {
      try {
        const taskId = this.$route.params.id; // Get task ID from route parameters
        console.log('Fetching task with ID:', taskId); // Log the task ID
        const response = await axios.get(`http://127.0.0.1:8000/api/task/${taskId}`);
        console.log('Task response:', response.data); // Log the full response

        // Assuming the response contains an array of tasks
        const tasks = response.data.task;
        if (Array.isArray(tasks)) {
          // Find the task with the matching ID
          this.task = tasks.find(task => task.id === parseInt(taskId));
          if (!this.task) {
            console.error('Task not found in the response array');
          }
        } else {
          console.error('Unexpected response format: ', response.data);
        }
      } catch (error) {
        console.error('Error fetching task details:', error.response ? error.response.data : error.message);
      }
    },
    formatDate(date) {
      if (!date) return 'Date non disponible';
      
      try {
        const parsedDate = new Date(date);
        if (isNaN(parsedDate.getTime())) return 'Date invalide';
        return formatDistanceToNow(parsedDate, { addSuffix: true });
      } catch (error) {
        console.error('Error formatting date:', error);
        return 'Erreur de formatage de la date';
      }
    },
  },
};
</script>

<style scoped>
.container {
  background-color: white;
  padding: 20px;
  max-width: 700px;
  margin: 20px auto;
}
.time{
  margin-left: 30px;
}
</style>
