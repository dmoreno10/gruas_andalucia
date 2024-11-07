<template>
    <div class="notifications-container">
        <transition-group name="fade" mode="out-in">
            <div
                v-for="notification in notifications"
                :key="notification.id"
                class="notification card mb-2"
                :class="{ read: notification.read_at }"
            >
                <div class="card-body">
                    <button class="close" @click.stop="removeNotification(notification.id)">×</button>
                    <h5 class="notification-title">{{ notification.data.title }}</h5>
                    <p class="notification-time">Creado el: {{ timeAgo(notification.created_at) }}</p>
                    <a :href="`/incidents/${notification.data.incident_id}`" class="btn btn-link">Ver incidente</a>
                </div>
            </div>
            <p v-if="!notifications.length" class="text-center">No tienes notificaciones.</p>
        </transition-group>
    </div>
</template>

<script>
export default {
    props: {
        initialNotifications: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            notifications: this.initialNotifications,
            closedNotifications: new Set(),
        };
    },
    methods: {
        removeNotification(id) {
            console.log('Removing notification with id:', id); // Para depuración
            this.notifications = this.notifications.filter(notification => notification.id !== id);
            this.closedNotifications.add(id);
            this.saveClosedNotifications();
        },
        addNotification(newNotification) {
            this.notifications.push(newNotification);
        },
        timeAgo(date) {
            const createdAt = new Date(date);
            const now = new Date();
            const diff = Math.abs(now - createdAt); // Diferencia en milisegundos

            const minutes = Math.floor(diff / (1000 * 60));
            return `${minutes} minutos atrás`;
        },
        loadClosedNotifications() {
            const closedNotifications = localStorage.getItem('closedNotifications');
            if (closedNotifications) {
                this.closedNotifications = new Set(JSON.parse(closedNotifications));
            }
        },
        saveClosedNotifications() {
            localStorage.setItem('closedNotifications', JSON.stringify(Array.from(this.closedNotifications)));
        }
    },
    created() {
        this.loadClosedNotifications();
        console.log('Initial notifications:', this.initialNotifications); // Para depuración
        this.notifications = this.notifications.filter(notification => !this.closedNotifications.has(notification.id));
        console.log('Filtered notifications:', this.notifications); // Para depuración
    },
};
</script>

<style scoped>
.notifications-container {
    position: fixed; /* Fija la posición de la ventana de notificaciones */
    top: 80px; /* Ajusta la distancia desde la parte superior */
    right: 20px; /* Ajusta la distancia desde el lado derecho */
    max-width: 300px; /* Ancho máximo de la ventana de notificaciones */
    z-index: 1000; /* Asegúrate de que esté por encima de otros elementos */
    padding: 10px;
}

.notification {
    cursor: pointer;
    transition: transform 0.2s;
}

.notification:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.notification-title {
    font-weight: bold;
}

.notification-time {
    color: #6c757d;
    font-size: 0.9rem;
}

.read {
    background-color: #e9ecef;
}

.close {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 1.5rem;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}
</style>
