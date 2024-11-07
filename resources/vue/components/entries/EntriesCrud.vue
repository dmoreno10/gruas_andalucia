<template>
  <div class="time-tracker">
    <!-- DatePicker en la esquina superior derecha -->
    <VueDatePicker v-model="date" range multi-calendars class="date-picker"></VueDatePicker>

    <!-- Contenedor principal alineado horizontalmente -->
    <div class="main-row">
      <div class="time-display">
        <h2>DURACIÓN DE JORNADA</h2>
        <p class="duration">{{ formattedDuration }}</p>
      </div>
      <div class="buttons">
        <button @click="startSession" :disabled="sessionActive">Iniciar Jornada</button>
        <button @click="endSession" :disabled="!sessionActive">Terminar</button>
      </div>
    </div>

    <!-- Historial de Jornadas -->
    <div class="entries-list">
      <ul>
        <li v-for="entry in entries" :key="entry.id">
          <p>Inicio: {{ formatDateTime(entry.start_time) }}</p>
          <p>Fin: {{ entry.ended_at ? formatDateTime(entry.ended_at) : '-' }}</p>
          <p>Total: {{ entry.formatted_duration ? entry.formatted_duration : '00:00:00' }}</p>

        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import axios from 'axios';
import '@vuepic/vue-datepicker/dist/main.css';

axios.defaults.withCredentials = true;

export default {
  components: { VueDatePicker },

  setup() {
    const date = ref([]);
    const duration = ref(0);
    const sessionActive = ref(false);
    const entries = ref([]);
    let timer = null;

    onMounted(() => {
      const startDate = new Date();
      const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
      date.value = [startDate, endDate];
      fetchEntries();
    });

    const formattedDuration = computed(() => {
      const hours = String(Math.floor(duration.value / 3600)).padStart(2, '0');
      const minutes = String(Math.floor((duration.value % 3600) / 60)).padStart(2, '0');
      const seconds = String(duration.value % 60).padStart(2, '0');
      return `${hours}:${minutes}:${seconds}`;
    });

    const startSession = async () => {
      try {
        const response = await axios.post('/time-entries/start');
        if (response.status === 201) {
          const startTimeUTC=response.data.data.start_time;
          const startTimeLocal = new Date(startTimeUTC).toISOString();
          console.log('Datos que enviar desde el frontend al backend: '+startTimeLocal);
          sessionActive.value = true;
          duration.value = 0;
          timer = setInterval(() => {
            duration.value++;
          }, 1000);
          alert('Jornada iniciada con éxito.');
          $('#entries-table').DataTable().draw();
        }
      } catch (error) {
        console.error('Error al iniciar la jornada:', error.response?.data);
        alert('No se pudo iniciar la jornada.');
      }
    };

    const endSession = async () => {
  try {
    const endTime = new Date().toISOString(); // Esto es el tiempo de finalización (hora actual)
    console.log('Datos de end que enviar al backend: '+endTime);
    const response = await axios.post('/time-entries/end', {
      ended_at: endTime,
    });

    if (response.status === 200) {
      sessionActive.value = false;
      clearInterval(timer);
      timer = null;
      await fetchEntries();
      alert('Jornada terminada con éxito.');
      $('#entries-table').DataTable().draw();
    }
  } catch (error) {
    console.error('Error al terminar la jornada:', error.response?.data);
    alert('No se pudo terminar la jornada.');
  }
};






    const formatDateTime = (dateTime) => {
      const date = new Date(dateTime);
      return date.toLocaleString();
    };

    const fetchEntries = async () => {
  try {
    const response = await axios.get('/time-entries');
    entries.value = response.data.entries || [];
  } catch (error) {
    console.error('Error al obtener las entradas:', error);
    alert('No se pudo obtener el historial de jornadas.');
  }
};


    return {
      date,
      duration,
      sessionActive,
      formattedDuration,
      entries,
      startSession,
      endSession,
      formatDateTime,
    };
  },
};
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
  }

  .date-picker {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 120px;
  }

  .main-row {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: 20px;
  }

  .time-display {
    background-color: #002F6C;
    color: #FFFFFF;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
  }

  .duration {
    font-size: 2em;
    font-weight: bold;
    margin: 0;
  }

  .buttons {
    display: flex;
    gap: 10px;
  }

  .buttons button {
    background-color: #003366;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
  }

  .buttons button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
  }

  .entries-list {
    width: 100%;
    max-width: 600px;
    margin-top: 20px;
  }

  .entries-list ul {
    list-style-type: none;
    padding: 0;
  }

  .entries-list li {
    background-color: #f2f2f2;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
  }
  </style>
