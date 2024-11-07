<template>
    <!-- Modal de Reserva -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow-lg">
          <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="staticBackdropLabel">Modificación de datos de Reserva</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateReservation">
              <input type="hidden" id="reservationId" v-model="reservation.id">

              <div class="mb-3">
                <label for="clientName" class="form-label">Nombre del Cliente</label>
                <input type="text" class="form-control" id="clientName" v-model="reservation.client_name" required>
                <span v-if="errors.client_name" class="invalid-feedback" role="alert">
                  <strong>{{ errors.client_name }}</strong>
                </span>
              </div>

              <div class="mb-3">
                <label for="reservationDate" class="form-label">Fecha de Reserva</label>
                <input type="date" class="form-control" id="reservationDate" v-model="reservation.reservation_date" required>
                <span v-if="errors.reservation_date" class="invalid-feedback" role="alert">
                  <strong>{{ errors.reservation_date }}</strong>
                </span>
              </div>

              <div class="mb-3">
                <label for="reservationStatus" class="form-label">Estado</label>
                <select class="form-select" id="reservationStatus" v-model="reservation.status" required>
                  <option value="confirmada">Confirmada</option>
                  <option value="pendiente">Pendiente</option>
                  <option value="cancelada">Cancelada</option>
                </select>
                <span v-if="errors.status" class="invalid-feedback" role="alert">
                  <strong>{{ errors.status }}</strong>
                </span>
              </div>

              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Cerrar</button>
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
          status: ''
        },
        errors: {}
      };
    },
    methods: {
      loadReservation(reservationId) {
        axios.get(`/reservations/${reservationId}`)
          .then(response => {
            this.reservation = response.data;  // Asigna los datos de la reserva al objeto Vue
            $('#modalForm').modal('show');  // Muestra el modal
          })
          .catch(error => {
            console.error("Error al cargar los datos de la reserva:", error);
          });
      },
      updateReservation() {
        axios.put(`/reservations/${this.reservation.id}`, this.reservation)
          .then(response => {
            // Mostrar mensaje de éxito
            this.$swal('¡Éxito!', 'Reserva actualizada correctamente.', 'success');
            $('#reservations-table').DataTable().draw();

            // Cerrar el modal
            $('#modalForm').modal('hide');
          })
          .catch(error => {
            // Manejo de errores
            this.errors = error.response.data.errors || {};
          });
      },
      closeModal() {
        $('#modalForm').modal('hide');
      }
    },
    mounted() {
      let self = this;
      $(document).ready(function() {
        // Cargar la reserva en el modal al hacer clic en "editar"
        $('body').on('click', '.btn-edit', function() {
          const reservationId = $(this).data('id'); // Obtener el ID de la reserva
          self.loadReservation(reservationId);  // Cargar la reserva
        });

        // Manejo de eventos para confirmación de eliminación
        $('body').on('click', '.btn-delete', function() {
          var form = $(this).closest('form'); // Obtener el formulario asociado al botón de borrar
          self.$swal({
            title: '¿Estás seguro?',
            text: '¡No podrás recuperar esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit(); // Enviar el formulario si se confirma
            }
          });
        });
      });
    }
  };
  </script>

  <style scoped>
  .modal-content {
    border-radius: 15px; /* Bordes redondeados */
  }

  .modal-header {
    border-bottom: none; /* Elimina el borde inferior */
  }

  .modal-body {
    background: #f8f9fa; /* Color de fondo suave */
  }

  .modal-footer {
    border-top: none; /* Elimina el borde superior */
  }

  .btn-success {
    background-color: #28a745; /* Color verde para el botón Guardar */
    border: none; /* Sin borde */
  }

  .btn-success:hover {
    background-color: #218838; /* Verde más oscuro al pasar el ratón */
  }

  .btn-secondary {
    background-color: #6c757d; /* Color gris para el botón Cerrar */
    border: none; /* Sin borde */
  }

  .btn-secondary:hover {
    background-color: #5a6268; /* Gris más oscuro al pasar el ratón */
  }
  </style>
