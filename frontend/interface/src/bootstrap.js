import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '42158bfbc0a94140a843',  // Assurez-vous que cette clé est correcte
    cluster: 'eu',                // Assurez-vous que le cluster est correct
    forceTLS: true,
});
