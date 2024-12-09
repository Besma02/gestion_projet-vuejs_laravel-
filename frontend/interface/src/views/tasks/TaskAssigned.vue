<template>
  <div class="container">
    <h1 class="title">Mes tâches</h1>
    <div v-for="task in tasks" :key="task.id" class="info">
      <h3>{{ task.name }}</h3>
      <p class="text">{{ task.description }}</p>

      <h5>Start Date: <span class="blue">{{ formatDate(task.start_date) }}</span></h5>
      <h5>Due Date: <span class="blue">{{ formatDate(task.due_date) }}</span></h5>

      <span :class="statusClass(task.status)" class="px-2 py-2 rounded-md inline-block mt-2 text-black">{{ task.status }}</span>

      <div class="flex-column">
        <!-- Afficher "End Task" uniquement si la tâche est en cours -->
        <div v-if="task.status === 'en cours'">
          <button @click="markAsTerminated(task.id)" class="btn-finish">End Task</button>
        </div>

        <!-- Afficher "Start Task" uniquement si la tâche n'a pas encore commencé -->
        <div v-else-if="isTaskActive(task) && task.status !== 'en cours' && task.status !== 'terminer'">
          <button @click="startTask(task.id)" class="btn-start">Start Task</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';
import moment from 'moment';

export default {
  data() {
    return {
      tasks: [],
      token: localStorage.getItem('token'), // Assurez-vous que le token est correctement stocké
    };
  },
  created() {
    this.fetchTasks();
  },
  methods: {
    // Fetch the tasks assigned to the user
    fetchTasks() {
      if (this.token) {
        axios
          .get('http://127.0.0.1:8000/api/tasks/assigned', {
            headers: {
              Authorization: `Bearer ${this.token}`,
            },
          })
          .then((response) => {
            this.tasks = response.data.tasks;
          })
          .catch((error) => {
            console.error('Error fetching tasks:', error);
          });
      } else {
        console.log('Token not found or expired');
        this.$router.push({ name: 'login' });
      }
    },

    // Mark a task as terminated
    markAsTerminated(id) {
      axios
        .post(`http://127.0.0.1:8000/api/task/markAsTerminated/${id}`, {}, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        })
        .then((response) => {
          alert(response.data.message);
          this.fetchTasks();
        })
        .catch((error) => {
          console.error('Error marking task as terminated:', error);
          alert('An error occurred while marking the task as terminated');
        });
    },

    // Check if a task is active
    isTaskActive(task) {
      const now = moment();
      const start_date = moment(task.start_date);
      const due_date = moment(task.due_date);
      return now.isAfter(start_date) && now.isBefore(due_date) && 
             !['en cours', 'terminer'].includes(task.status);
    },

    // Start a task
    async startTask(id) {
      try {
        const response = await axios.post(
          `http://127.0.0.1:8000/api/task/startTask/${id}`,
          {},
          {
            headers: {
              Authorization: `Bearer ${this.token}`,
              'Content-Type': 'application/json',
            },
          }
        );

        if (response.status === 200) {
          alert('Task started successfully');
          this.fetchTasks(); // Refresh task list
        } else {
          alert(response.data.message || 'An error occurred');
        }
      } catch (error) {
        console.error('Error starting task:', error);
        alert('An error occurred');
      }
    },

    // Helper method to format dates
    formatDate(date) {
      return moment(date).format('DD/MM/YYYY');
    },

    // Return appropriate CSS class based on task status
    statusClass(status) {
      return {
        'bg-yellow-300': status === 'en cours',
        'bg-green-300': status === 'terminer',
        'bg-red-300': status !== 'en cours' && status !== 'terminer',
      };
    },
  },
};
</script>

<style scoped>
.container {
  background: white;
  width: 700px;
  margin: 10px auto;
  padding: 20px;
}

.btn-start {
  background-color: rgb(249, 105, 105);
  color:white;
  border: none;
  border-radius: 10px;
}

.btn-finish {
  background-color: green;
  color:white;
  border: none;
  border-radius: 10px;
}

.text {
  color: black;
}

h5 {
  font-size: 16px;
}

.info {
  text-align: center;
}

.blue {
  color: blue;
}
</style>
