<template>
    <div>
      <ul>
        <li v-if="permissions.includes('canCreateTask')" class="md:mr-5 py-2 md:py-0">
            <router-link to="#">Add New Task</router-link>
        </li>
        <!-- Vous pouvez ajouter d'autres éléments ici en fonction des permissions -->
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        permissions: []
      };
    },
    created() {
      this.fetchPermissions();
    },
    methods: {
      fetchPermissions() {
        axios.get('http://127.0.0.1:8000/api/user/permissions')
          .then(response => {
            this.permissions = response.data.permissions;
          })
          .catch(error => {
            console.error('Error fetching permissions:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Ajoutez ici vos styles spécifiques au composant */
  </style>
  