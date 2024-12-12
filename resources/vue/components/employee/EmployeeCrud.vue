<template>
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ isEditing ? 'Modificar Trabajador' : 'Crear Trabajador' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="isEditing ? updateEmployee() : createEmployee()">
                        <div class="mb-3">
                            <label for="employeeName" class="form-label">Nombre</label>
                            <input id="employeeName" type="text" class="form-control" v-model="employee.name" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeEmail" class="form-label">Correo Electrónico</label>
                            <input id="employeeEmail" type="email" class="form-control" v-model="employee.email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeePosition" class="form-label">Puesto</label>
                            <input id="employeePosition" type="text" class="form-control" v-model="employee.position" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeDepartment" class="form-label">Departamento</label>
                            <input id="employeeDepartment" type="text" class="form-control" v-model="employee.department" required>
                        </div>

                        <!-- Select para Empresa -->
                        <div class="mb-3">
                                <label for="companySelect" class="form-label">Empresa</label>
                                <select id="companySelect" class="form-select" v-model="employee.company_id" required>
                                    <option v-for="company in companies" :key="company.id" :value="company.id">
                                        {{ company . name }}
                                    </option>
                                </select>
                                <span v-if="errors.company_id" class="invalid-feedback" role="alert">
                                    <strong>{{ errors . company_id }}</strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select id="status" class="form-select" v-model="employee.status" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                                <span v-if="errors.status" class="invalid-feedback" role="alert">
                                    <strong>{{ errors . status }}</strong>
                                </span>
                            </div>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">{{ isEditing ? 'Guardar Cambios' : 'Crear Trabajador' }}</button>
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
            employee: {
                id: '',
                name: '',
                email: '',
                position: '',
                department: '',
                company_id: '' // Campo para la empresa
            },
            companies: [], // Lista de empresas
            errors: {},
            isEditing: false,
        };
    },
    methods: {
        openCreateModal() {
            // Limpiar los datos previos para crear un nuevo empleado
            this.employee = { name: '', email: '', position: '', department: '', company_id: '' };
            this.errors = {};
            this.isEditing = false;
            this.fetchCompanies(); // Cargar las empresas cuando se abre el modal
            $('#modalForm').modal('show'); // Mostrar el modal
        },
        openEditModal(employeeId) {
            axios.get(`/employees/${employeeId}/edit`)
                .then(response => {
                    this.employee = response.data.employee;
                    this.companies = response.data.companies; // Cargar las empresas disponibles
                    this.isEditing = true;
                    $('#modalForm').modal('show'); // Mostrar el modal
                })
                .catch(error => {
                    console.error("Error al cargar el empleado", error);
                });
        },
        fetchCompanies() {
            axios.get('/companies/get/data')  // Solicitar las empresas desde la nueva ruta
                .then(response => {
                    this.companies = response.data; // Guardar las empresas en el estado
                })
                .catch(error => {
                    console.error("Error al cargar las empresas", error);
                });
        },
        createEmployee() {
            axios.post('/employees', this.employee)
                .then(response => {
                    this.$swal('¡Éxito!', 'Empleado creado con éxito.', 'success');
                    this.employee = { name: '', email: '', position: '', department: '', company_id: '' }; // Limpiar formulario
                    $('#modalForm').modal('hide'); // Cerrar el modal
                    $('#employees-table').DataTable().draw(); // Actualizar la tabla
                })
                .catch(error => {
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        },
        updateEmployee() {

            if (!this.employee.id) {
                this.$swal('Error', 'No se ha seleccionado un empleado válido para editar.', 'error');
                return;
            }

            axios.put(`/employees/${this.employee.id}`, this.employee)
                .then(response => {
                    this.$swal('¡Éxito!', 'Empleado actualizado correctamente.', 'success');
                    $('#modalForm').modal('hide'); // Cerrar el modal
                    $('#employees-table').DataTable().draw(); // Actualizar la tabla
                })
                .catch(error => {
                    console.error(error.response);  // Muestra la respuesta completa del error
                    this.errors = error.response.data.errors || {};
                    this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                });
        }
    },
    mounted() {
        // Escuchar clic en el botón de crear empleado
        document.getElementById('create-employee-btn').addEventListener('click', this.openCreateModal);

        // Escuchar clic en los botones de editar
        $('body').on('click', '.btn-edit', (event) => {
            const employeeId = $(event.currentTarget).data('id');
            this.openEditModal(employeeId);
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
