import '../js/bootstrap';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { createApp } from 'vue';
import axios from 'axios';

// Configura Axios para usar el token CSRF

const app = createApp({});

import UserCrud from './components/users/UserCrud.vue';
import IncidentCrud from './components/incidents/IncidentCrud.vue';
app.component('incident-crud', IncidentCrud);
app.component('user-crud', UserCrud);

app.use(VueSweetalert2);

app.mount('#app');
