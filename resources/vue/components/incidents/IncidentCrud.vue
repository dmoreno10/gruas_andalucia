<template>
    <!-- Modal de Crear/Editar Incidencia -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ isEditing && incident.title ? 'Editar Incidencia' : 'Crear Nueva Incidencia' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="isEditing ? updateIncident() : createIncident()">
                        <div class="mb-3">
                            <label for="incidentTitle" class="form-label">Título de la Incidencia</label>
                            <input type="text" class="form-control" id="incidentTitle" v-model="incident.title"
                                required>
                            <span v-if="errors.title" class="invalid-feedback" role="alert">
                                <strong>{{ errors.title }}</strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="incidentDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="incidentDescription" v-model="incident.description" required></textarea>
                            <span v-if="errors.description" class="invalid-feedback" role="alert">
                                <strong>{{ errors.description }}</strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="incidentStatus" class="form-label">Estado</label>
                            <select class="form-select" id="incidentStatus" v-model="incident.status" required>
                                <option value="abierto">Abierto</option>
                                <option value="cerrado">Cerrado</option>
                                <option value="en_progreso">En Progreso</option>
                            </select>
                            <span v-if="errors.status" class="invalid-feedback" role="alert">
                                <strong>{{ errors.status }}</strong>
                            </span>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit"
                                class="btn btn-success">{{ isEditing ? 'Actualizar' : 'Crear Incidencia' }}</button>
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
            incident: {
                id: '',
                title: '',
                description: '',
                status: 'abierto',
                created_at: new Date().toISOString().slice(0, 19).replace('T', ' '), // Asignar fecha actual
            },
            errors: {},
            isEditing: false,
        };
    },
    methods: {
        openCreateModal() {
            this.incident = {
                title: '',
                description: '',
                status: 'abierto',
                created_at: new Date().toISOString().slice(0, 19).replace('T', ' '), // Asignar fecha actual
            };
            this.errors = {};
            this.isEditing = false;
            $('#modalForm').modal('show');
        },

        openEditModal(incidentId) {
            axios.get(`/incidents/${incidentId}/edit`)
                .then(response => {
                    if (response.data.incident) {
                        this.incident = response.data.incident;
                        this.isEditing = true;
                        const modal = new bootstrap.Modal(document.getElementById('modalForm'));
                        modal.show();
                    } else {
                        console.error('No se encontró la incidencia o los datos no son válidos');
                    }
                })
                .catch(error => {
                    console.error("Error al cargar la incidencia", error);
                });
        },

        createIncident() {
            axios.post('/incidents', this.incident)
                .then(response => {
                    this.$swal('¡Éxito!', 'Incidencia creada correctamente.', 'success');
                    this.incident = {
                        title: '',
                        description: '',
                        status: 'abierto',
                        created_at: new Date().toISOString().slice(0, 19).replace('T', ' '),
                    };
                    $('#modalForm').modal('hide');
                    $('#incidents-table').DataTable().draw();
                })
                .catch(error => {
                    this.errors = error.response.data.errors || {};
                    console.error(error.response);
                });
        },

        updateIncident() {
            if (!this.incident.id) {
                this.$swal('Error', 'No se ha seleccionado una incidencia válida para editar.', 'error');
                return;
            }

            axios.put(`/incidents/${this.incident.id}`, this.incident)
                .then(response => {
                    this.$swal('¡Éxito!', 'Incidencia actualizada correctamente.', 'success');
                    $('#modalForm').modal('hide');
                    $('#incidents-table').DataTable().draw();
                })
                .catch(error => {
                    console.error(error.response);
                    this.errors = error.response.data.errors || {};
                });
        },

        closeModal() {
            $('#modalForm').modal('hide');
        }
    },
    mounted() {
        document.getElementById('create-incident-btn').addEventListener('click', this.openCreateModal);

        $('body').on('click', '.btn-edit', (event) => {
            const incidentId = $(event.currentTarget).data('id');
            this.openEditModal(incidentId);
        });

        const self = this; 
            $(document).ready(() => {
                
                $('body').on('click', '.btn-delete', function() {
                    const form = $(this).closest('form');
                 
                    self.$swal({
                        title: '¿Estás seguro?',
                        text: '¡No podrás recuperar esto!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, borrar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); 
                        }
                    });
                });
            });

    }
};
</script>
