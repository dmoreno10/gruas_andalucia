<template>
    <!-- Modal de reservas -->
    <div class="modal-overlay" v-show="isModalVisible" @click="handleOverlayClick">
      <div class="modal-content" @click.stop>
        <span @click="closeModal" class="close-btn">Cerrar</span>
        <h2>{{ selectedEvent.id ? 'Editar Reserva' : 'Crear Reserva' }}</h2>

        <!-- Mensaje de error -->
        <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>

        <!-- Buscar Usuario -->
        <div class="form-group">
          <label for="user">Nombre del evento</label>
          <input type="text" id="user" placeholder="Buscar Usuario" v-model="form.user" />
        </div>

        <!-- Motivo -->
        <div class="form-group">
          <label for="motive">Motivo</label>
          <input type="text" id="motive" placeholder="Ingresa el motivo de la consulta" v-model="form.motive" />
        </div>

        <!-- Fecha -->
        <div class="form-group">
          <label for="date">Fecha</label>
          <input type="date" id="date" v-model="form.date" />
        </div>

        <!-- Hora -->
        <div class="form-group">
          <label for="hour">Hora</label>
          <input type="time" id="hour" v-model="form.hour" />
        </div>

        <!-- Duración -->
        <div class="form-group">
          <label for="duration">Duración</label>
          <select id="duration" v-model="form.duration">
            <option>15 minutos</option>
            <option>30 minutos</option>
            <option>1 hora</option>
          </select>
        </div>

        <!-- Botones -->
        <div class="modal-buttons">
          <button @click="closeModal">Atrás</button>
          <button @click="onSave">{{ selectedEvent.id ? 'Actualizar' : 'Guardar' }}</button>
          <button v-if="selectedEvent" @click="confirmDelete" class="danger">Eliminar</button>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props: {
    selectedDate: {
      type: String,
      required: false,
    },
    isModalVisible: {
      type: Boolean,
      default: false,  // Para recibir visibilidad desde el padre
    },
    selectedEvent: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      form: {
        user: '',
        motive: '',
        date: this.selectedDate || '', // Inicializa con la fecha seleccionada
        hour: '',
        duration: '15 minutos',
      },
      errorMessage: '', // Variable para almacenar mensajes de error
    };
  },
  watch: {
    selectedEvent: {
      immediate: true,
      handler(newEvent) {
        if (newEvent && Object.keys(newEvent).length > 0 && newEvent.start_time) { // Verifica que start_time exista
          console.log('Evento seleccionado:', newEvent);
          const titleParts = newEvent.title.split(': ');
          this.form.user = titleParts[0] || ''; // Nombre del usuario
          this.form.motive = titleParts[1] || '';
          const date = newEvent.start_time.toISOString().split('T')[0]; // Extrae la fecha en formato YYYY-MM-DD
          const time = newEvent.start_time.toISOString().split('T')[1].slice(0, 5); // Extrae la hora en formato HH:mm
          this.form.date = date; // Asigna la fecha
          this.form.hour = time; // Asigna la hora
          this.form.duration = newEvent.duration || '15 minutos'; // Ajusta según sea necesario
        } else {
          this.resetForm(); // Llama a un método para restablecer el formulario
        }
      },
    },
  },
  methods: {
    resetForm() {
      this.form = {
        user: '',
        motive: '',
        date: this.selectedDate || '',
        hour: '',
        duration: '15 minutos',
      };
      this.errorMessage = ''; // Resetea el mensaje de error
    },
    handleOverlayClick() {
      this.selectedEvent.id=null;
      this.closeModal(); // Cierra el modal
      this.resetForm(); // Resetea el formulario después de guardar
    },
    closeModal() {
      this.selectedEvent.id=null;
      this.$emit('close'); // Emitir evento de cierre del modal
      this.resetForm(); // Resetea el formulario después de guardar
    },
    async onSave() {
      const eventData = {
        user: this.form.user,
        motive: this.form.motive,
        title: this.form.title,
        date: this.form.date,
        hour: this.form.hour,
        duration: this.form.duration,
      };
      const combinedDateTime = `${this.form.date}T${this.form.hour}:00`;
      console.log("Datos a guardar:", eventData); // Añadir depuración para ver el contenido de eventData

      if (this.selectedEvent && this.selectedEvent.id) {
        eventData.id = this.selectedEvent.id; // Asegúrate de que el ID está presente
        console.log("Actualizando evento:", eventData);
        // Emitir evento para actualizar

        const response = await axios.post('/events', {
          id: this.selectedEvent.id,
          title: this.form.user,
          start_time: combinedDateTime,
          description: this.form.motive ?? null,
          user: this.selectedEvent.user ?? null // Asegúrate de enviar el usuario también
        });
        this.$emit('update', eventData);
      } else {
        console.log("Creando nuevo evento:", eventData);
        const response = await axios.post('/events', {
          id: this.selectedEvent.id,
          title: this.form.user,
          start_time: combinedDateTime,
          description: this.form.motive,
          user: this.selectedEvent.user ?? null // Asegúrate de enviar el usuario también
        });
        this.$emit('create', eventData); // Emitir evento para crear

      }

      this.closeModal(); // Cerrar modal después de guardar
      this.resetForm(); // Resetea el formulario después de guardar
    },
    confirmDelete() {
      if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
        this.onDelete();
      }
    },
    onDelete() {
      this.$emit('delete', this.selectedEvent.id); // Emitir evento para eliminar el evento seleccionado
      this.closeModal(); // Cerrar modal después de eliminar
      this.resetForm(); // Resetea el formulario después de eliminar
    },
  },
};
</script>

<style scoped>
/* Estilos para la superposición del modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999; /* Asegúrate de que sea lo más alto */
  animation: fadeIn 0.3s ease-in-out; /* Efecto de aparición */
}

.modal-content {
  position: relative;
  width: 400px;
  background-color: white;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  z-index: 10000; /* Lo más alto en el modal */
  cursor: auto; /* Asegura que el modal no propague clics */
}

.error-message {
  color: red; /* Color del mensaje de error */
  margin-bottom: 10px; /* Espaciado debajo del mensaje */
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.modal-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button.danger {
  background-color: #ff4d4f;
  color: white;
}

button:hover {
  opacity: 0.9;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 14px;
  color: red;
}
</style>
