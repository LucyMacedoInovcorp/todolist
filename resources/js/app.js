import './bootstrap';
import { createApp } from 'vue';
import ListComponent from './components/ListComponent.vue';

// Criar a aplicação Vue
const app = createApp({});

// Registrar componentes
app.component('ListComponent', ListComponent);

// Montar a aplicação
app.mount('#app');
