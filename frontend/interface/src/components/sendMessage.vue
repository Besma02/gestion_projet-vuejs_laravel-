<template>
    <div class="right message">
      <p>{{ message }}</p>
      <img
        src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg"
        alt="Profile picture"
      />
    </div>
  </template>
  
  <script>
  export default {
    name: 'MessageComponent',
    data() {
      return {
        // This is the message that will be displayed
        message: 'Your message here' // You can replace this with a default message or bind it from a parent component
      };
    }
  };
  </script>
  
  <style scoped>
 
  </style>
  