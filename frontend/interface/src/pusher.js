import Pusher from 'pusher-js';

const pusher = new Pusher('42158bfbc0a94140a843', {
    cluster: 'chatApp',
});
const channel = pusher.subscribe('chatApp');

channel.bind('ChatMessageSent', function(data) {
  console.log("Nouveau message reçu:", data.message);
  // Ici, vous pouvez mettre à jour votre état ou votre liste de messages
});

export default pusher;