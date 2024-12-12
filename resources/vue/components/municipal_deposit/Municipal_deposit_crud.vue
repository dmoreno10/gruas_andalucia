<template>
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ isEditing ? 'Modificar Depósito Municipal' : 'Crear Depósito Municipal' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="isEditing ? updateMunicipalDeposit() : createMunicipalDeposit()">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input id="name" type="text" class="form-control" v-model="municipalDeposit.name" required>
                            <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="direction" class="form-label">Dirección</label>
                            <input id="direction" type="text" class="form-control" v-model="municipalDeposit.direction" required>
                            <span v-if="errors.direction" class="text-danger">{{ errors.direction[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="town" class="form-label">Ciudad</label>
                            <input id="town" type="text" class="form-control" v-model="municipalDeposit.town" required>
                            <span v-if="errors.town" class="text-danger">{{ errors.town[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select id="status" class="form-select" v-model="municipalDeposit.status" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            <span v-if="errors.status" class="text-danger">{{ errors.status[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input id="phone" type="tel" class="form-control" v-model="municipalDeposit.phone" @input="validatePhone('phone')" required>
                            <span v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="mobile_phone" class="form-label">Teléfono Móvil</label>
                            <input id="mobile_phone" type="tel" class="form-control" v-model="municipalDeposit.mobile_phone" @input="validatePhone('mobile_phone')" required>
                            <span v-if="errors.mobile_phone" class="text-danger">{{ errors.mobile_phone[0] }}</span>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">{{ isEditing ? 'Guardar Cambios' : 'Crear Depósito Municipal' }}</button>
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
            municipalDeposit: {
                id: '',
                name: '',
                direction: '',
                town: '',  
                status: '1',
                phone: '',
                mobile_phone: ''
            },
            errors: {},
            isEditing: false,
        };
    },
    mounted() {
        $('#create-company-btn').on('click', this.openCreateModal);
    },
    methods: {
        validatePhone(field) {
            this.municipalDeposit[field] = this.municipalDeposit[field].replace(/\D/g, '');
        },
        openCreateModal() {
            this.municipalDeposit = { name: '', direction: '', town: '', status: '1', phone: '', mobile_phone: '' };
            this.errors = {};
            this.isEditing = false;
            $('#modalForm').modal('show');
        },
        openEditModal(depositId) {
            axios.get(`/municipal-deposit/${depositId}/edit`)
                .then(response => {
                    this.municipalDeposit = response.data;
                    this.isEditing = true;
                    $('#modalForm').modal('show');
                })
                .catch(error => {
                    console.error("Error al cargar el depósito municipal", error);
                });
        },
        createMunicipalDeposit() {
            axios.post('/municipal-deposit', this.municipalDeposit)
                .then(response => {
                    this.$swal('¡Éxito!', 'Depósito Municipal creado con éxito.', 'success');
                    this.municipalDeposit = { name: '', direction: '', town: '', status: '1', phone: '', mobile_phone: '' };
                    $('#modalForm').modal('hide');
                    $('#municipal-deposit-table').DataTable().draw();
                })
                .catch(error => {
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        },
        updateMunicipalDeposit() {
            if (!this.municipalDeposit.id) {
                this.$swal('Error', 'No se ha seleccionado un depósito válido para editar.', 'error');
                return;
            }

            axios.put(`/municipal-deposit/${this.municipalDeposit.id}`, this.municipalDeposit)
                .then(response => {
                    this.$swal('¡Éxito!', 'Depósito Municipal actualizado correctamente.', 'success');
                    $('#modalForm').modal('hide');
                    $('#municipal-deposit-table').DataTable().draw();
                })
                .catch(error => {
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        }
    },
};
</script>
