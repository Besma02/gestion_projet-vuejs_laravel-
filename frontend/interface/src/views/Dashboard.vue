<template>
  <div class="dashboard-container">
    <aside class="sidebar">
      <h2>Menu</h2>
      <ul>
        <li><router-link to="/dashboard/Tasks">All Tasks</router-link></li>
        <li><router-link to="/dashboard/taskAssigned">My Tasks</router-link></li>
        <li><router-link to="/dashboard/create">Add New Task</router-link></li>
        <li><router-link to="/dashboard/Users_management">Users Management</router-link></li>
      </ul>
    </aside>
    <main class="content">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>

export default {
  name: 'Dashboard',
  methods: {
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    }
  },
  mounted(){
      let user=localStorage.getItem('user')
      if(!user){
        this.$router.push({name:'signUp'})
    }
    }
};
</script>

<style scoped>
.dashboard-container {
  display: flex;
  height: 100vh;
}

.sidebar {
  width: 250px;
  padding: 20px;
  background-color: #5d8dc0;
  color: white;
}

.sidebar h2 {
  margin-top: 0;
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar ul li {
  margin: 10px 0;
}

.sidebar ul li a {
  color: white;
  text-decoration: none;
}

.sidebar ul li a:hover {
  text-decoration: underline;
}

.content {
  flex-grow: 1;
  padding: 20px;
  background-color: #ecf0f1;
}
</style>
