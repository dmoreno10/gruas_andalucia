import '../js/bootstrap';

import { createApp } from 'vue';

const app = createApp({});

import UserCrud from './components/UserCrud.vue';

app.component('user-crud', UserCrud);

app.mount('#app');
