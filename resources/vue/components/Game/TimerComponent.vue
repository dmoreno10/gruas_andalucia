<template>
    <div class="timer-container">
        <h3>Temporizador para {{ taskDescription }}</h3>
        <div>{{ formattedTime }}</div>
        <button @click="startTimer" :disabled="timerActive">Empezar</button>
        <button @click="pauseTimer" :disabled="!timerActive">Pausar</button>
        <button @click="stopTimer">Detener</button>
    </div>
</template>

<script>
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
        taskDescription: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            timer: null,
            currentTime: 0,
            timerActive: false,
            isPaused: false,
        };
    },
    computed: {
        formattedTime() {
            const hours = String(Math.floor(this.currentTime / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((this.currentTime % 3600) / 60)).padStart(2, '0');
            const seconds = String(this.currentTime % 60).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        },
    },
    methods: {
        startTimer() {
            if (!this.timerActive) {
                this.timerActive = true;
                this.timer = setInterval(() => {
                    if (!this.isPaused) {
                        this.currentTime++;
                    }
                }, 1000);
                this.startTimerBackend();
            }
        },
        pauseTimer() {
            this.isPaused = !this.isPaused;
        },
        stopTimer() {
            clearInterval(this.timer);
            this.timerActive = false;
            this.isPaused = false;
            this.updateTaskTime();
        },
        updateTaskTime() {
            fetch(`/tasks/stop/${this.taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                },
                body: JSON.stringify({ total_time: this.currentTime })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Task time updated successfully', data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        },
        startTimerBackend() {
            fetch(`/tasks/start/${this.taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Timer started for task:', data);
            })
            .catch(error => {
                console.error('Error al iniciar el temporizador:', error);
            });
        },
    },
};
</script>

<style scoped>
.timer-container {
    margin: 20px 0;
}
button {
    margin: 5px;
}
</style>
