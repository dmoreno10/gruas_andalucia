<template>
    <!-- Modal de Incidencia -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modificación de datos de Incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="updateIncident">

                        <input type="hidden" id="incidentId" v-model="incident.id">

                        <div class="mb-3">
                            <label for="incidentTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="incidentTitle" v-model="incident.title" required>
                        </div>
                        <div class="mb-3">
                            <label for="incidentDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="incidentDescription" v-model="incident.description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="incidentStatus" class="form-label">Estado</label>
                            <select class="form-select" id="incidentStatus" v-model="incident.status" required>
                                <option value="abierto">Pendiente</option>
                                <option value="en_progreso">En Progreso</option>
                                <option value="resuelto">Resuelto</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
export default {
    data() {
        return {
            incident: {
                id: '',
                title: '',
                description: '',
                status: ''
            },
            errors: {}
        };
    },
    methods: {

        loadIncident(incidentId) {
            console.log(incidentId)
            axios.get(`/incidents/${incidentId}`)
                .then(response => {
                    this.incident = response.data;  // Asigna los datos de la incidencia al objeto Vue
                    $('#modalForm').modal('show');  // Muestra el modal
                })
                .catch(error => {
                    console.error("Error al cargar los datos de la incidencia:", error);
                });
    }
,
        updateIncident() {
            axios.put(`/incidents/${this.incident.id}`, this.incident)
                .then(response => {
                    // Mostrar mensaje de éxito
                    this.$swal('¡Éxito!', 'Incidencia actualizada correctamente.', 'success');
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
            // Cargar la incidencia en el modal al hacer clic en "editar"
            $('body').on('click', '.btn-edit', function() {
                const incidentId = $(this).data('id'); // Obtener el ID de la incidencia
                console.log("Botón edit clickeado con ID:", incidentId); // Verificar si aquí imprime el ID
                self.loadIncident(incidentId);  // Cargar la incidencia
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
