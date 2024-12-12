<template>
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ isEditing ? 'Modificar Empresa' : 'Crear Empresa' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="isEditing ? updateCompany() : createCompany()">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de la Empresa</label>
                            <input id="name" type="text" class="form-control" v-model="company.name" required>
                            <span v-if="errors.name" class="invalid-feedback" role="alert">
                                <strong>{{ errors.name }}</strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <input id="address" type="text" class="form-control" v-model="company.address" required>
                            <span v-if="errors.address" class="invalid-feedback" role="alert">
                                <strong>{{ errors.address }}</strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input id="phone" type="text" class="form-control" v-model="company.phone" required>
                            <span v-if="errors.phone" class="invalid-feedback" role="alert">
                                <strong>{{ errors.phone }}</strong>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control" v-model="company.email" required>
                            <span v-if="errors.email" class="invalid-feedback" role="alert">
                                <strong>{{ errors.email }}</strong>
                            </span>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">{{ isEditing ? 'Guardar Cambios' : 'Crear Empresa' }}</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
            company: {
                name: '',
                address: '',
                phone: '',
                email: '',
            },
            errors: {},
            isEditing: false,
        };
    },
    methods: {
        openCreateModal() {
            // Limpiar los datos previos para crear una nueva empresa
            this.company = { name: '', address: '', phone: '', email: '' };
            this.errors = {};
            this.isEditing = false;
            $('#modalForm').modal('show'); // Mostrar el modal
        },
        openEditModal(companyId) {
            axios.get(`/companies/${companyId}`)
                .then(response => {
                    this.company = response.data;
                    this.isEditing = true;
                    $('#modalForm').modal('show'); // Mostrar el modal
                })
                .catch(error => {
                    console.error("Error al cargar la empresa", error);
                });
        },
        createCompany() {
            axios.post('/companies', this.company)
                .then(response => {
                    this.$swal('¡Éxito!', 'Empresa creada con éxito.', 'success');
                    this.company = { name: '', address: '', phone: '', email: '' }; // Limpiar formulario
                    $('#modalForm').modal('hide'); // Cerrar el modal
                    $('#companies-table').DataTable().draw(); // Actualizar la tabla
                })
                .catch(error => {
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        },
        updateCompany() {
            if (!this.company.id) {
                this.$swal('Error', 'No se ha seleccionado una empresa válida para editar.', 'error');
                return;
            }

            axios.put(`/companies/${this.company.id}`, this.company)
                .then(response => {
                    this.$swal('¡Éxito!', 'Empresa actualizada correctamente.', 'success');
                    $('#modalForm').modal('hide'); // Cerrar el modal
                    $('#companies-table').DataTable().draw(); // Actualizar la tabla
                })
                .catch(error => {
                    console.error(error.response);  // Muestra la respuesta completa del error
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        }
    },
    mounted() {
        // Abrir el modal de creación de empresa cuando se hace clic en el botón
        document.getElementById('create-company-btn').addEventListener('click', this.openCreateModal);

        // Escuchar clics en los botones de editar
        $('body').on('click', '.btn-edit', (event) => {
            const companyId = $(event.currentTarget).data('id');
            this.openEditModal(companyId);
        });
    }
}
</script>

<style scoped>
.modal-content {
    border-radius: 15px;
}
.modal-header {
    border-bottom: none;
}
.modal-body {
    background: #f8f9fa;
}
.modal-footer {
    border-top: none;
}
.btn-success {
    background-color: #28a745;
    border: none;
}
.btn-success:hover {
    background-color: #218838;
}
.btn-secondary {
    background-color: #6c757d;
}
</style>
