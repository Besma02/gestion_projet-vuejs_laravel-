import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle';

// Afficher les variables d'environnement dans la console
// console.log('Pusher Key:', import.meta.env.VITE_PUSHER_APP_KEY);
// console.log('Pusher Cluster:', import.meta.env.VITE_PUSHER_APP_CLUSTER);

// window.Pusher = Pusher;

// window.Echo = new Echo({
//   broadcaster: 'pusher',
//   key: import.meta.env.VITE_PUSHER_APP_KEY, // Utilisez ces variables ici
//   cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Utilisez ces variables ici
//   encrypted: true
// });

const app = createApp(App);

app.use(router);

app.mount('#app');
