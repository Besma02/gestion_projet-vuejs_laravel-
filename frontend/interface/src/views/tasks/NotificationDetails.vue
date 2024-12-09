<template>
    <div class="container">
      <h1 >Notification Details</h1>
      <div v-if="notification">
        <h6>{{ notification.data.message }}</h6>
        <p>Task ID: {{ notification.data.task_id }}</p>
        <p>Task name: {{ notification.data.name }}</p>
        <!-- Add more details as needed -->
      </div>
      <div v-else>
        <p>Loading notification details...</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['id'],
    data() {
      return {
        notification: null,
      };
    },
    async created() {
      const notificationId = this.$route.params.id;
      await this.fetchNotification(notificationId);
    },
    methods: {
      async fetchNotification(notificationId) {
        try {
          const token = localStorage.getItem('token');
          const response = await axios.get(`http://127.0.0.1:8000/api/notifications/${notificationId}`, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.notification = response.data.notification; // Adjust according to your API response structure
        } catch (error) {
          console.error('Error fetching notification:', error);
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
   margin-left: 5%;
 }

 </style>
  