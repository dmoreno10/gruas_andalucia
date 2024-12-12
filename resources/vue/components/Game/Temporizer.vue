<template>
    <div class="time-tracker">
        <!-- Información de la tarea, ubicada en la esquina superior derecha -->
        <div class="task-info">
            <h2>Tarea: {{ task.description }}</h2>
            <h4>Puntos: {{ task.points }}</h4>
            <h4>Tiempo Estimado: {{ task.time_minutes }} minutos</h4>
        </div>

        <!-- Temporizador centrado sin fondo azul -->
        <div class="timer">
            <span>Temporizador: {{ formatTime(currentTime) }}</span>
        </div>

        <!-- Botones de control -->
        <div class="buttons">
            <button class="btn btn-start" @click="startTimer" :disabled="timerActive">Empezar</button>
            <button class="btn btn-danger" @click="stopTimer" :disabled="!timerActive">Detener</button>
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
                time_minutes: 0,
            },
            currentTime: Number(localStorage.getItem(`task-${this.taskId}-time`)) || 0,  // Persistir tiempo
            timerActive: false,
            timer: null,
        };
    },
    mounted() {
        this.loadTask(this.taskId);
        this.checkTimerStatus();
    },
    methods: {
        loadTask(taskId) {
            axios.get(`/tasks/${taskId}`)
                .then(response => {
                    this.task = response.data;
                })
                .catch(error => {
                    console.error("Error al cargar la tarea:", error);
                });
        },
        startTimer() {
            if (!this.timerActive) {
                this.timerActive = true;
                this.timer = setInterval(() => {
                    this.currentTime++;
                    localStorage.setItem(`task-${this.taskId}-time`, this.currentTime);  // Guardar tiempo
                }, 1000);
            }
        },
        stopTimer() {
            if (this.timerActive) {
                clearInterval(this.timer);  // Detener el temporizador
                this.timerActive = false;

                // Enviar el tiempo acumulado al backend
                const timeInMinutes = Math.floor(this.currentTime / 60);  // Convertir tiempo a minutos

                // Hacer la solicitud POST para guardar el tiempo
                axios.post(`/tasks/stop/${this.taskId}`, { time: timeInMinutes }, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                    }
                })
                .then(response => {
                    console.log('Tiempo guardado:', response.data);
                    // Eliminar el tiempo del localStorage solo después de guardar
                    localStorage.removeItem(`task-${this.taskId}-time`);
                    // Redirigir a la página de tareas
                    window.location.href = '/tasks';
                })
                .catch(error => {
                    console.error('Error al guardar el tiempo:', error);
                });
            }
        },
        formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        },
        checkTimerStatus() {
            if (this.currentTime > 0) {
                this.startTimer();  // Si hay tiempo guardado, continuar el temporizador
            }
        }
    },
    beforeDestroy() {
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
}
</script>

<style scoped>
.time-tracker {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    font-family: Arial, sans-serif;
    color: #333;
    position: relative;
    height: 100vh;
}

.task-info {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 1.2em; /* Aumento de tamaño de la fuente */
    color: #555;
}

.task-info h2 {
    font-size: 1.3em;  /* Aumento de tamaño */
    margin: 0;
}

.task-info h4 {
    font-size: 1.1em; /* Aumento de tamaño */
    margin: 5px 0;
}

.timer {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 3em;  /* Tamaño aumentado */
    font-weight: bold;
    color: #333;
    width: 100%;
    height: 50vh;  /* Altura ajustada */
    text-align: center;
    margin-top: 60px;
}

.buttons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.buttons button {
    background-color: #003366;
    color: white;
    border: none;
    padding: 15px 30px;  /* Aumento del tamaño del botón */
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.2em;  /* Aumento del tamaño de la fuente del botón */
    transition: background-color 0.3s;
}

.buttons button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.buttons button:hover {
    background-color: #0055a5;
}

.btn-start {
    background-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
}
</style>

