import '../js/bootstrap';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { createApp } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

// Configura Axios para usar el token CSRF
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Crear la instancia de la aplicación
const app = createApp({
    methods: {
        onUserUpdated(updatedUser) {
            // Aquí recargamos la tabla DataTable al recibir la actualización del usuario
            $('#users-table').DataTable().ajax.reload(null, false); // Recarga sin reiniciar la paginación
        }
    }
});

// Importar componentes
import UserCrud from './components/users/UserCrud.vue';
import IncidentCrud from './components/incidents/IncidentCrud.vue';
import Books from './components/Agenda/Books.vue';
import LocationCrud from './components/location/LocationCrud.vue';
import EmployeeCrud from './components/employee/EmployeeCrud.vue';
import EntriesCrud from './components/entries/EntriesCrud.vue';
import FileCrud from './components/file/FileCrud.vue';
import Profileimagemodal from './components/profile/profileimagemodal.vue';
import Rate from './components/Rate/rate.vue';
import NotificationCurd from './components/notification/notification-crud.vue';
import HeaderUser from './components/header-user.vue';
import ReservationCrud from './components/reservation/ReservationCrud.vue';
import Rankings from './components/Game/Rankings.vue';
import Points from './components/Game/Points.vue';
import Temporizer from './components/Game/Temporizer.vue';
import DatePicker from './components/entries/DatePicker.vue';

// Registrar componentes
app.component('user-crud', UserCrud);
app.component('incident-crud', IncidentCrud);
app.component('calendar-crud', Books);
app.component('location-crud', LocationCrud);
app.component('entries-crud', EntriesCrud);
app.component('employee-crud', EmployeeCrud);
app.component('document-crud', FileCrud);
app.component('profile-image-modal', Profileimagemodal);
app.component('rate-crud', Rate);
app.component('notification-crud', NotificationCurd);
app.component('header-user',HeaderUser);
app.component('reservation-crud',ReservationCrud);
app.component('points-crud',Points);
app.component('rankings-crud',Rankings);
app.component('temporizer-crud',Temporizer);
app.component('VueDatePicker', VueDatePicker);

// Usar SweetAlert2
app.use(VueSweetalert2);

// Montar la aplicación
app.mount('#app');

// Escuchar eventos de Echo
window.Echo.channel('users')
    .listen('UserUpdated', (event) => {
        console.log('User was updated:', event);
        // Si deseas, puedes actualizar la tabla aquí también
    });
