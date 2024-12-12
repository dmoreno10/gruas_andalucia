<template>
      <div class="d-flex align-items-center  mb-3">
            <a href="javascript:history.back()" class="me-2">
                <i style="color: black;" class="fas fa-arrow-left"></i>
            </a>
            <p class="mb-0">Atrás</p>
        </div>
    <div>
        <!-- FullCalendar Component -->
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
    </div>
</template>

<script>
    import FullCalendar from '@fullcalendar/vue3';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import timeGrid from '@fullcalendar/timegrid';
    import axios from 'axios';
    import esLocale from '@fullcalendar/core/locales/es';


    export default {
        name: 'Calendar',
        components: {
            FullCalendar,
        },
        props: {
            events: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [dayGridPlugin, interactionPlugin, timeGrid],
                    initialView: 'dayGridMonth',
                    editable: true,
                    timeZone: 'UTC',
                    locale: 'es',

                    dateClick: this.handleDateClick,
                    headerToolbar: {
                        left: 'prev,next,today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay',
                    },
                    height: 'auto',
                    slotMinTime: '12:00:00',
                    slotMaxTime: '20:00:00',
                    allDaySlot: false,
                    events: this.events, // Inicialmente, los eventos se obtienen desde props
                    eventClick: this.handleEventClick,
                    eventDrop: this.handleEventDrop,
                    eventContent: (arg) => {
                        return {
                            html: `<div style="background-color: purple; color: white; padding: 5px; border-radius: 4px; display: flex; justify-content: center; align-items: center; height: 100%; text-align: center;">${arg.event.title}</div>`,
                        };
                    },
                    buttonText: {
                        today: 'Hoy', 
                        month: 'Mes', 
                        week: 'Semana', 
                        day: 'Día', 
                        list: 'Lista',
                    }

                },
            };
        },

        watch: {
            events: {
                immediate: true,
                handler(newEvents) {
                    this.updateCalendarEvents(newEvents);
                },
            },
        },
        mounted() {
            this.fetchEvents(); // Cargar eventos al montar el componente
        },
        methods: {
            handleEventDrop(dropInfo) {
                const updatedEvent = {
                    id: dropInfo.event.id,
                    start: dropInfo.event.start.toISOString(),
                    end: dropInfo.event.end ? dropInfo.event.end.toISOString() : null,
                };

                console.log('Evento movido:', updatedEvent);

                axios.post(`/events/update/${updatedEvent.id}`, {
                        start_time: updatedEvent.start,
                        end_time: updatedEvent.end,
                    })
                    .then(response => {
                        console.log('Evento actualizado en la base de datos', response.data);
                        // Actualizar eventos localmente sin esperar a fetchEvents
                        this.updateEventLocally(updatedEvent);
                    })
                    .catch(error => {
                        console.error('Error al actualizar el evento', error);
                    });
            },

            async fetchEvents() {
                try {
                    const response = await axios.get('/events/get/data');
                    console.log('Eventos recuperados:', response.data); // Verifica la respuesta

                    const fetchedEvents = response.data.map(event => ({
                        id: event.id,
                        title: event.title,
                        start: event.start_time,
                        description: event.description,
                    }));

                    console.log('Eventos formateados:', fetchedEvents); // Verifica el formato
                    this.updateCalendarEvents(fetchedEvents);
                } catch (error) {
                    console.error("Error fetching events:", error);
                }
            },

            async deleteEvent(eventId) {
                const calendarApi = this.$refs.fullCalendar.getApi();
                const eventToRemove = calendarApi.getEventById(eventId);

                if (eventToRemove) {
                    // Eliminar el evento del calendario
                    eventToRemove.remove();

                    try {
                        const response = await axios.delete(`/events/delete/${eventId}`);
                        console.log('Evento eliminado del backend:', response.data);

                    } catch (error) {
                        console.error('Error al eliminar el evento en el backend:', error);
                        // Si la eliminación falla en el backend, podrías agregar el evento de nuevo al calendario
                    }
                    this.fetchEvents();

                } else {
                    console.error('Error: evento no encontrado en el calendario');
                }
            },

            updateCalendarEvents(events) {
                const formattedEvents = events.map((event) => ({
                    id: event.id,
                    title: `${event.title}: ${event.description}`,
                    start: event.start,
                    allDay: true,
                }));

                this.$nextTick(() => {
                    const calendarApi = this.$refs.fullCalendar.getApi();

                    if (calendarApi) {
                        console.log('Limpieza de eventos actuales');
                        calendarApi.removeAllEvents(); // Eliminar eventos existentes
                        console.log('Agregando nuevos eventos:', formattedEvents);
                        calendarApi.addEventSource(formattedEvents); // Añadir nuevos eventos
                    } else {
                        console.error('Error: no se pudo obtener la API de FullCalendar');
                    }
                });
            },

            // Nuevo método para actualizar eventos localmente
            updateEventLocally(updatedEvent) {
                const calendarApi = this.$refs.fullCalendar.getApi();
                const existingEvent = calendarApi.getEventById(updatedEvent.id);

                if (existingEvent) {
                    existingEvent.setStart(updatedEvent.start);
                    existingEvent.setEnd(updatedEvent.end);
                } else {
                    console.error('Error: evento no encontrado en el calendario');
                }
            },

            // Nuevo método para eliminar un evento localmente
            removeEventLocally(eventId) {
                const calendarApi = this.$refs.fullCalendar.getApi();
                const eventToRemove = calendarApi.getEventById(eventId);

                if (eventToRemove) {
                    eventToRemove.remove();
                } else {
                    console.error('Error: evento no encontrado en el calendario');
                }
            },

            handleDateClick(clickinfo) {
                this.$emit('dateclick', clickinfo);
            },

            handleEventClick(clickInfo) {
                const eventData = {
                    id: clickInfo.event.id,
                    title: clickInfo.event.title,
                    description: clickInfo.event.extendedProps.description,
                    start_time: clickInfo.event.start,
                };
                this.$emit('edit-event', eventData);
            },
        },
    };
</script>

<style scoped>
    .fc-h-event .fc-event-main {
        background-color: purple !important;
        color: white !important;
    }
</style>
