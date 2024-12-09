<template>
  <div>
    <h1 class="">Editer</h1>
    <div class="">
      <form @submit.prevent="" >
        <div v-for="role in roles" :key="role.id" class="">
          <div class="">
            <input
              id="role"
              type="checkbox"
              :value="role.id"
              v-model="selectedRoles"
              class=""
            />
         
          <label for="role" class="">{{ role.name }}</label>
        </div>
        </div>
        <button type="submit" class="" @click="updateUser">
          Editer
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    userId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      roles: [],
      selectedRoles: [],
      user: null
    };
  },
  created() {
    this.fetchUserData();
  },
  methods: {
    fetchUserData() {
      axios.get("http://127.0.0.1:8000/api/users/edit/"+this.$route.params.id)
        .then(response => {
          this.user = response.data.user;
          this.roles = response.data.roles;
          this.selectedRoles = this.user.roles.map(role => role.id);
        })
        .catch(error => {
          console.error('Error fetching user data:', error);
        });
    },
    updateUser() {
      axios.put("http://127.0.0.1:8000/api/users/edit/"+this.$route.params.id, { roles: this.selectedRoles })
        .then(response => {
          console.log(response.data.message);
         this.$router.push({name:'users_management'})
        })
        .catch(error => {
          console.error('Error updating user roles:', error);
        });
    }
  }
};
</script>

<style scoped>
/* Ajoutez ici vos styles spécifiques au composant */
</style>
