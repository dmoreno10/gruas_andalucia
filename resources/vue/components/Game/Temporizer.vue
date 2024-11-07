<template>
    <div>
        <h2>Tarea: {{ task.description }}</h2>
        <h4>Puntos: {{ task.points }}</h4>
        <h4>Tiempo: {{ task.time_minutes }}</h4>

        <div>
            <span>Temporizador: {{ formatTime(currentTime) }}</span>
            <button class="btn btn-success" @click="startTimer">Empezar</button>
            <button class="btn btn-warning" @click="togglePause">{{ timerActive ? 'Pausar' : 'Continuar' }}</button>
            <button class="btn btn-danger" @click="stopTimer">Detener</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        taskId: {
            type: Number,
            required: true,
        },
        csrfToken: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            task: {
                description: '',
                points: 0,
            },
            currentTime: Number(localStorage.getItem(`task-${this.taskId}-time`)) || 0, // Carga el tiempo guardado o 0
            timerActive: false,
            timer: null,
        };
    },
    mounted() {
        this.loadTask(this.taskId);
        console.log('Tiempo cargado desde localStorage:', this.currentTime);
    },
    methods: {
        loadTask(taskId) {
            axios.get(`/tasks/${taskId}`)
                .then(response => {
                    this.task = response.data;
                    console.log("Datos de tarea cargados:", this.task);
                })
                .catch(error => {
                    console.error("Error al cargar la tarea:", error);
                    this.$swal('Error', 'No se pudieron cargar los datos de la tarea.', 'error');
                });
        },
        startTimer() {
    if (!this.timerActive) {
        this.timerActive = true;
        this.currentTime = Number(localStorage.getItem(`task-${this.taskId}-time`)) || 0; // Iniciar desde el tiempo guardado o 0
        console.log('Temporizador iniciado');
        this.timer = setInterval(() => {
            this.currentTime++;
            localStorage.setItem(`task-${this.taskId}-time`, this.currentTime);
        }, 1000);
    } else {
        console.log('El temporizador ya está activo'); // Verificación de estado
    }
}
,
        togglePause() {
            if (this.timerActive) {
                clearInterval(this.timer);
                this.timerActive = false;
            } else {
                this.startTimer(); // Reanuda el temporizador
            }
        },
        stopTimer() {
    if (this.timerActive) {
        clearInterval(this.timer);
        this.timerActive = false;

        // Enviar el tiempo acumulado (en minutos) al backend
        const timeInMinutes = Math.floor(this.currentTime / 60);
        console.log('Tiempo acumulado en segundos:', this.currentTime); // Verificar el tiempo acumulado
        console.log('Tiempo a guardar en minutos:', timeInMinutes); // Verificar el tiempo a guardar

        // Hacer la solicitud al backend
        axios.post(`/tasks/stop/${this.taskId}`, { time: timeInMinutes }, {
            headers: {
                'X-CSRF-TOKEN': this.csrfToken
            }
        })
        .then(response => {
            console.log('Temporizador detenido y tiempo guardado:', response.data);
            // Elimina el tiempo guardado del localStorage solo después de guardar
            localStorage.removeItem(`task-${this.taskId}-time`);
            // Reinicia el temporizador solo si el guardado fue exitoso
            this.currentTime = 0; // Reinicia solo después de guardar
            window.location.href = '/tasks'; // Opcional
        })
        .catch(error => {
            console.error('Error al detener el temporizador:', error);
        });
    }
}

,
        formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        },
    },
    beforeDestroy() {
        // Limpia el temporizador si el componente se destruye
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
}
</script>

<style scoped>
.container {
    font-size: 2em;
    margin: 20px 0;
}
button {
    margin: 5px;
}
</style>
