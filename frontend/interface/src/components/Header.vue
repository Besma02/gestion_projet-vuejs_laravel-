<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{ title }}</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarColor01"
        aria-controls="navbarColor01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/register">Sign Up</router-link>
          </li>
         
          <li class="nav-item">
            <router-link class="nav-link" to="/logout" @click="logout">Logout</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/chat">Chat</router-link>
          </li>
          <!-- Notifications -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="notificationDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              @click.prevent="fetchNotifications"
            >
              <i class="fas fa-bell"></i>
              <span v-if="unreadCount > 0" class="badge bg-danger">{{ unreadCount }}</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
              <li v-for="notification in notifications" :key="notification.id">
                <router-link
                  class="dropdown-item"
                  :to="{ name: 'notificationDetail', params: { id: notification.id } }"
                  @click.prevent="markAsRead(notification.id)"
                >
                  {{ notification.data.message }}
                </router-link>
              </li>
              <li v-if="notifications.length === 0">
                <span class="dropdown-item">Aucune notification</span>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from 'axios';

export default {
  props: { title: String },
  data() {
    return {
      notifications: [],
      unreadCount: 0,
    };
  },
  created() {
    this.fetchNotifications();
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push({ name: 'login' });
    },
    async fetchNotifications() {
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('http://127.0.0.1:8000/api/notifications', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.notifications = response.data.notifications;
        this.unreadCount = this.notifications.filter(n => !n.read_at).length;
      } catch (error) {
        console.error('Erreur lors de la récupération des notifications:', error);
      }
    },
    async markAsRead(notificationId) {
      try {
        const token = localStorage.getItem('token');
        await axios.post(`http://127.0.0.1:8000/api/notifications/${notificationId}/read`, {}, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.fetchNotifications(); // Update notifications after marking as read
      } catch (error) {
        console.error('Erreur lors de la mise à jour de la notification:', error);
      }
    },
  },
};
</script>
