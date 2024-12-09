<template>
  <div>
    <h1 class="title">Add new Task</h1>
    <div class="container">
      <form @submit.prevent="submitForm">
        <div class="mb-6">
          <label for="name">Task name</label>
          <input
            type="text"
            v-model="name"
            id="name"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            :class="{'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500': errors.name}"
            placeholder="Titre de la tâche"
          />
          <p v-if="errors.name" class="mt-2 text-sm text-red-600">
            <span class="font-medium">Oops!</span> {{ errors.name }}
          </p>
        </div>

        <div class="mb-6">
          <label for="start_date" class="block mb-2 text-sm font-medium text-gray-700">Date de début</label>
          <input
            type="date"
            v-model="start_date"
            id="start_date"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            :class="{'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500': errors.start_date}"
          />
          <p v-if="errors.start_date" class="mt-2 text-sm text-red-600">
            <span class="font-medium">Oops!</span> {{ errors.start_date }}
          </p>
        </div>

        <div class="mb-6">
          <label for="due_date" class="block mb-2 text-sm font-medium text-gray-700">Date de fin</label>
          <input
            type="date"
            v-model="due_date"
            id="due_date"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            :class="{'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500': errors.due_date}"
          />
          <p v-if="errors.due_date" class="mt-2 text-sm text-red-600">
            <span class="font-medium">Oops!</span> {{ errors.due_date }}
          </p>
        </div>

        <div class="mb-6">
          <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Votre message</label>
          <textarea
            id="description"
            v-model="description"
            rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            :class="{'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500': errors.description}"
            placeholder="Laissez un commentaire..."
          ></textarea>
          <p v-if="errors.description" class="mt-2 text-sm text-red-600">
            <span class="font-medium">Oops!</span> {{ errors.description }}
          </p>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Envoyer
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      start_date: '',
      due_date: '',
      description: '',
      errors: {},
    };
  },
  methods: {
    async submitForm() {
      const token = localStorage.getItem('token');
      try {
        const response = await axios.post(
          'http://127.0.0.1:8000/api/tasks/create',
          {
            name: this.name,
            start_date: this.start_date,
            due_date: this.due_date,
            description: this.description,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.$router.push({ name: 'tasks' });
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          // Gestion d'autres erreurs comme la connexion au serveur
          this.errors.general = 'Une erreur est survenue. Veuillez réessayer plus tard.';
        }
      }
    },
  },
};
</script>

<style scoped>
.container {
  background: white;
  width: 700px;
  margin: 10px auto;
}

form {
  padding: 20px;
  margin: 5px auto;
}

form input,
form textarea {
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
