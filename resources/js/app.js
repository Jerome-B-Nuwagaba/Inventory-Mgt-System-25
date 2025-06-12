import './bootstrap';
import { createApp } from 'vue';
import ChatInterface from './components/Chat/ChatInterface.vue';
import ChatNotification from './components/Chat/ChatNotification.vue';

const app = createApp({});

// Register components
app.component('chat-interface', ChatInterface);
app.component('chat-notification', ChatNotification);

// Mount the app
app.mount('#app');
