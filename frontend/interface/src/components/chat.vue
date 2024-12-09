<template>
  <div class="chat-container">
    <div class="messages">
      <div v-for="msg in messages" :key="msg.id" class="message">
        <strong>{{ msg.user.name }}:</strong> {{ msg.message }}
      </div>
    </div>
    <form @submit.prevent="sendMessage">
      <input v-model="newMessage" placeholder="Écrivez un message..." required class="input" />
      <button type="submit" class="submit">Envoyer</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Echo from 'laravel-echo';


export default {
  data() {
    return {
      messages: [],
      newMessage: '',
    
    };
  },
  mounted() {
    // Vérifiez que Echo est accessible
    this.fetchMessages();
    this.listenForMessages();
  },
  methods: {
    // Récupérer les messages depuis l'API
    fetchMessages() {
      axios.get('http://localhost:8000/api/messages', {
        headers: {
          Authorization: `Bearer ${this.getToken()}`
        }
      })
      .then(response => {
        this.messages = response.data;
      })
      .catch(error => {
        console.error("Erreur lors de la récupération des messages:", error);
      });
    },
    
    // Envoyer un message à l'API
    sendMessage() {
      console.log("Données envoyées:", { message: this.newMessage });
      axios.post('http://localhost:8000/api/messages', { message: this.newMessage }, {
        headers: {
          Authorization: `Bearer ${this.getToken()}`
         
        }
        
      })
      .then(response => {
        this.newMessage = ''; // Réinitialiser le champ de message
        console.log("Message envoyé avec succès:", response.data);
      })
      .catch(error => {
        if (error.response) {
          console.error("Erreur lors de l'envoi du message:", error.response.data);
        } else {
          console.error("Erreur lors de l'envoi du message:", error);
        }
      });
    },

    // Écouter les nouveaux messages
    listenForMessages() {
        if (window.Echo) {
            Echo.channel('chatApp')
                .listen('ChatMessageSent', (event) => {
                    console.log("Nouveau message reçu:", event.message);
                    this.messages.push(event.message); // Ajoutez le nouveau message à la liste
                })
                .error(error => {
                    console.error("Erreur lors de l'écoute des messages:", error);
                });
        } else {
            console.error("Echo n'est pas défini.");
        }
    },

    // Récupérer le jeton JWT
    getToken() {
      return localStorage.getItem('token'); // ou d'où que vous le stockiez
    }
  }
};
</script>

<style scoped>
.chat-container {
  border: 1px solid #ccc;
  padding: 10px;
  width: 400px;
  height: 500px;
  overflow-y: scroll;
  margin:10px auto;
}
.messages {
  height: 450px;
  overflow-y: auto;
  
}
.message {
  margin-bottom: 10px;
}
.input{
  width: 78%;
  background-color: white;


 
}
.submit{
  color: white;
  background-color: skyblue;
  border: none;
  height:30px;
  margin-left: 5px;
  cursor: pointer;
}
</style>
