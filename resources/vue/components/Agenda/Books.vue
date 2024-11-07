<template>
    <div>
      <h1>Calendario</h1>

      <!-- Calendario donde los eventos se marcarán -->
      <Calendar :events="events" @dateclick="dateClick" @edit-event="openEditModal" @event-click="handleEventClick" ref="calendar"></Calendar>

      <!-- Modal solo visible cuando isModalVisible es true -->
      <CalendarModal
        :isModalVisible="isModalVisible"
        :selectedDate="selectedDate"
        :selectedEvent="selectedEvent"
        @save="onSaveEvent"
        @delete="onDeleteEvent"
        @close="closeModal"
      ></CalendarModal>
    </div>
  </template>

  <script>
  import Calendar from '../events/Calendar.vue';
  import CalendarModal from './CalendarModal.vue';
  import axios from 'axios';

  export default {
    name: 'Books',
    components: {
      Calendar,
      CalendarModal,
    },
    data() {
      return {
        isModalVisible: false, // Modal inicialmente no visible
        selectedDate: null, // Fecha seleccionada para el modal
        selectedEvent: {}, // Evento seleccionado para editar
        events: [], // Lista de eventos guardados
      };
    },
    methods: {
        async fetchEvents() {
      try {
        const response = await axios.get('/events'); // Asegúrate de que la URL sea correcta
        this.events = response.data; // Asignar los eventos obtenidos
      } catch (error) {
        console.error('Error al obtener eventos:', error);
      }
    },
      dateClick(arg) {
        console.log('Fecha seleccionada:', arg.dateStr);
        const dateObj = new Date(arg.dateStr); // Crear un objeto de fecha
        const formattedDate = dateObj.toISOString().split('T')[0]; // Obtener solo la fecha (yyyy-MM-dd)

        this.selectedDate = formattedDate; // Asignar la fecha formateada
        this.isModalVisible = true; // Mostrar el modal
      },

      closeModal() {
        this.isModalVisible = false; // Cerrar el modal
      },

      // Guardar evento
      async onSaveEvent(eventData) {
    const title = `${eventData.user}: ${eventData.motive}`; // Asegúrate de que motive esté definido
    const start_time = `${eventData.date}T${eventData.hour}:00`; // Concatenar fecha y hora

    // Comprobaciones para asegurar que los campos requeridos no estén vacíos
    if (!title || !start_time) {
        console.error('Campos requeridos faltan: title o start_time');
        return;
    }

    try {
        if (eventData.id) {

            // Editar un evento existente
            const response = await axios.put(`/events/${eventData.id}`, {
                title: title,
                start_time: start_time,
                description: eventData.description || '',
                user: eventData.user || null // Asegúrate de enviar el usuario también
            });

            // Actualizar el evento en la lista local
            const index = this.events.findIndex(event => event.id === eventData.id);
            if (index !== -1) {
                this.events.splice(index, 1, response.data.event);
            }
        } else {
            // Crear un nuevo evento
            const response = await axios.post('/events', {
                title: title,
                start_time: start_time,
                description: eventData.description || '',
                user: eventData.user || null // Asegúrate de enviar el usuario también
            });

            // Agregar el nuevo evento a la lista
            this.events.push(response.data.event);
        }

        // Actualiza el calendario
        this.$refs.calendar.updateCalendarEvents(this.events);
        this.closeModal();
    } catch (error) {
        console.error('Error al guardar el evento:', error.response || error);
    }
}

,

      // Manejar clic en un evento del calendario
      handleEventClick(clickInfo) {
        console.log(clickInfo.event); // Verifica la estructura del evento
        const eventData = {
          id: clickInfo.event.id, // Verifica que id esté presente
          user: clickInfo.event.extendedProps.user, // Verifica que user esté presente
          motive: clickInfo.event.extendedProps.motive, // Verifica que motive esté presente
          start: clickInfo.event.start, // Verifica que start esté presente
          duration: clickInfo.event.extendedProps.duration, // Verifica que duration esté presente
        };
        this.openEditModal(eventData);
      },

      openEditModal(eventData) {
        this.selectedEvent = eventData; // Asigna los datos del evento a una variable
        this.isModalVisible = true; // Muestra el modal
      },

      // Eliminar evento
      async onDeleteEvent(eventId) {
        console.log('Evento eliminado:', eventId);

        // Realizar la eliminación en el backend
        try {
          const response = await axios.delete(`/events/${eventId}`, {
            headers: {
              'Content-Type': 'application/json',
            },
          });

          console.log('Evento eliminado del backend:', response.data);

          // Eliminar el evento de la lista en el frontend
          this.events = [...this.events.filter(event => event.id !== eventId)]; // Filtra por ID
          this.closeModal(); // Cerrar el modal después de eliminar
          this.$refs.calendar.updateCalendarEvents(this.events);
        } catch (error) {
          console.error('Error al eliminar el evento:', error.response || error);
        }
      },
    },

  };
  </script>

  <style scoped>
  /* Estilos aquí si es necesario */
  </style>
