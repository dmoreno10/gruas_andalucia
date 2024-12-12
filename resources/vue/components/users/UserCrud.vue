<template>
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ isEditing ? 'Modificar Usuario' : 'Crear Usuario' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="isEditing ? updateUser() : createUser()">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Usuario</label>
                            <input id="name" type="text" class="form-control" v-model="user.name" required
                                autocomplete="name" autofocus>
                            <span v-if="errors.name" class="invalid-feedback" role="alert">
                                <strong>{{ errors . name }}</strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control" v-model="user.email" required>
                            <span v-if="errors.email" class="invalid-feedback" role="alert">
                                <strong>{{ errors . email }}</strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control" v-model="user.password" required
                                autocomplete="new-password">
                            <span v-if="errors.password" class="invalid-feedback" role="alert">
                                <strong>{{ errors . password }}</strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                v-model="user.password_confirmation" required autocomplete="new-password">
                            <span v-if="errors.password_confirmation" class="invalid-feedback" role="alert">
                                <strong>{{ errors . password_confirmation }}</strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol del Usuario</label>
                            <select id="role" class="form-select" v-model="user.role" required>
                                <option value="admin">Administrador</option>
                                <option value="client">Usuario</option>
                            </select>
                            <span v-if="errors.role" class="invalid-feedback" role="alert">
                                <strong>{{ errors . role }}</strong>
                            </span>
                        </div>
                        <div v-if="!isEditing" class="mb-3 form-check">
                            <input id="createEmployeeCheckbox" type="checkbox" class="form-check-input"
                                v-model="isCreatingEmployee" @change="loadCompaniesIfNeeded">
                            <label for="createEmployeeCheckbox" class="form-check-label">Crear Empleado Asociado</label>
                        </div>
                        <div v-if="isCreatingEmployee">
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
                                <label for="department" class="form-label">Departamento</label>
                                <input id="department" type="text" class="form-control" v-model="employee.department"
                                    required>
                                <span v-if="errors.department" class="invalid-feedback" role="alert">
                                    <strong>{{ errors . department }}</strong>
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
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit"
                                class="btn btn-success">{{ isEditing ? 'Guardar Cambios' : 'Crear Usuario' }}</button>
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
                user: {
                    id: '',
                    name: '',
                    email: '',
                    role: '',
                    company_id: ''
                },
                employee: {
                    department: '',
                    status: 'activo',
                },
                companies: [],
                errors: {},
                isEditing: false,
                isCreatingEmployee: false,
            };
        },
        methods: {
            validateForm() {
                this.errors = {};
                if (!this.user.name) this.errors.name = 'El nombre es obligatorio.';
                if (!this.user.email) this.errors.email = 'El correo electrónico es obligatorio.';
                if (!this.isEditing && !this.user.password) this.errors.password = 'La contraseña es obligatoria.';
                if (!this.isEditing && this.user.password !== this.user.password_confirmation) {
                    this.errors.password_confirmation = 'Las contraseñas no coinciden.';
                }
                if (!this.user.role) this.errors.role = 'El rol es obligatorio.';
                return Object.keys(this.errors).length === 0;
            },
            handleSubmit() {
                if (!this.validateForm()) {
                    this.$swal('Error', 'Por favor corrige los errores antes de continuar.', 'error');
                    return;
                }
                if (this.isEditing) {
                    this.updateUser();
                } else {
                    this.createUser();
                }
            },
            openCreateModal() {
                this.user = {
                    id: '',
                    name: '',
                    email: '',
                    role: 'user',
                    company_id: ''
                };
                this.employee = {
                    department: '',
                    status: 'activo'
                };
                this.errors = {};
                this.isEditing = false;
                this.isCreatingEmployee = false;
                $('#modalForm').modal('show');
            },
            loadUser(userId) {
                axios.get(`/users/${userId}`)
                    .then(response => {
                        this.user = response.data;
                        this.isEditing = true;
                        $('#modalForm').modal('show');
                    })
                    .catch(error => {
                        console.error("Error al cargar los datos del usuario:", error);
                        this.$swal('Error', 'No se pudieron cargar los datos del usuario.', 'error');
                    });
            },
            loadCompaniesIfNeeded() {
                if (this.isCreatingEmployee && this.companies.length === 0) {
                    this.fetchCompanies();
                }
            },
            fetchCompanies() {
                axios.get('/companies/get/data')
                    .then(response => {
                        this.companies = response.data;
                    })
                    .catch(error => {
                        console.error("Error al cargar las empresas:", error);
                        this.$swal('Error', 'No se pudieron cargar las empresas.', 'error');
                    });
            },
            createUser() {
                // Crear solo el usuario con los campos necesarios
                const userData = {
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password ||
                        'defaultPassword', // Opcional: establecer un valor por defecto para la contraseña
                    password_confirmation: this.user.password_confirmation,
                    role: this.user.role, // Asegúrate de enviar el campo 'role'
                };

                axios.post('/users', userData)
                    .then(response => {
                        this.$swal('¡Éxito!', 'Usuario creado correctamente.', 'success');
                        this.user = response.data.user; // Guarda el usuario creado con el ID
                        if (this.isCreatingEmployee) {
                            this.createEmployee(response.data.user.id); // Ahora pasas el ID del usuario creado al crear el empleado
                        }
                        $('#modalForm').modal('hide');
                        $('#users-table').DataTable().draw();
                    })
                    .catch(error => {
                        console.error(error.response); // Agregar depuración aquí
                        this.errors = error.response.data.errors || {};
                        this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                    });
            },

            createEmployee(userId) {
                const employeeData = {
                    name: this.user.name || 'Nombre del Empleado', // Agregar 'name'
                    position: this.user.position || 'Sin especificar',
                    department: this.employee.department || 'Sin especificar',
                    email: this.user.email || 'exampleEmail@gmail.com',
                    status: this.employee.status || 'Inactivo',
                    company_id: this.employee.company_id,
                    user_id: userId, // Enviar el ID del usuario recién creado
                };

                console.log('Datos del empleado enviados:', employeeData); 

                axios.post('/employees', employeeData)
                    .then(response => {
                        this.$swal('¡Éxito!', 'Empleado creado correctamente.', 'success');
                        $('#employees-table').DataTable().draw();
                    })
                    .catch(error => {
                        console.error('Error al crear empleado:', error.response.data);
                        if (error.response && error.response.data && error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        } else {
                            this.errors = {}; // Para manejar cualquier otro tipo de error
                        }
                        this.$swal('Error', 'No se pudo crear el empleado, corrige los errores.', 'error');
                    });
            },
            updateUser() {
                axios.put(`/users/${this.user.id}`, this.user)
                    .then(response => {
                        this.$swal('¡Éxito!', 'Usuario actualizado correctamente.', 'success');
                        $('#modalForm').modal('hide');
                        $('#users-table').DataTable().draw();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors || {};
                        this.$swal('Error', 'Por favor corrige los errores y vuelve a intentarlo.', 'error');
                    });
            }
        },
        mounted() {
            document.getElementById('create-user-btn').addEventListener('click', this.openCreateModal);

            $(document).ready(() => {
                $('body').on('click', '.btn-edit', (event) => {
                    const userId = $(event.currentTarget).data('id');
                    this.loadUser(userId);
                });
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
    }
</script>
