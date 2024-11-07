<template>
    <div>
        <button class="btn btn-warning btn-edit" @click="loadReservation(1)">Editar Reserva</button>

        <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="staticBackdropLabel">Modificación de Reserva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateReservation">
                            <div class="mb-3">
                                <label for="client_name" class="form-label">Nombre del Cliente</label>
                                <input id="client_name" type="text" class="form-control" v-model="reservation.client_name" required autofocus>
                                <span v-if="errors.client_name" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.client_name }}</strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="reservation_date" class="form-label">Fecha de Reserva</label>
                                <input id="reservation_date" type="date" class="form-control" v-model="reservation.reservation_date" required>
                                <span v-if="errors.reservation_date" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.reservation_date }}</strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado de la Reserva</label>
                                <select id="status" class="form-select" v-model="reservation.status" required>
                                    <option value="confirmada">Confirmada</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                                <span v-if="errors.status" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.status }}</strong>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            reservation: {
                id: '',
                client_name: '',
                reservation_date: '',
                status: '',
            },
            errors: {}
        };
    },
    methods: {
        loadReservation(reservationId) {
            axios.get(`/reservations/${reservationId}`)
                .then(response => {
                    this.reservation = response.data;
                    $('#modalForm').modal('show'); // Muestra el modal
                })
                .catch(error => {
                    console.error("Error al cargar los datos de la reserva:", error);
                    this.$swal('Error', 'No se pudieron cargar los datos de la reserva.', 'error');
                });
        },
        updateReservation() {
            axios.put(`/reservations/${this.reservation.id}`, this.reservation)
                .then(response => {
                    this.$swal('¡Éxito!', 'Reserva actualizada correctamente.', 'success');
                    $('#modalForm').modal('hide'); // Cierra el modal
                })
                .catch(error => {
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        }
    }
}
</script>

<style scoped>
/* Tus estilos aquí */
</style>
