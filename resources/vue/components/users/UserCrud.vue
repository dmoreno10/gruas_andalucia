<template>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modificación de datos de Usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="updateUser">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" v-model="user.name" required autocomplete="name" autofocus>
                                <span v-if="errors.name" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.name }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-model="user.email" autocomplete="email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" v-model="user.password" autocomplete="new-password">
                                <span v-if="errors.password" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.password }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirma Contraseña</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" v-model="user.password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
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
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {}
        };
    },
    methods: {
        loadUser(userId) {
            axios.get(`/users/${userId}`)
                .then(response => {
                    this.user = response.data;
                    $('#modalForm').modal('show'); // Muestra el modal
                })
                .catch(error => {
                    console.error("Error al cargar los datos del usuario:", error);
                });
        },
        updateUser() {
            axios.put(`/users/${this.user.id}/`, this.user)
        .then(response => {
            // Manejo de éxito
            this.$swal('¡Éxito!', 'Usuario actualizado correctamente.', 'success');
            // Cierra el modal
            $('#modalForm').modal('hide');
        })
        .catch(error => {
            // Manejo de errores
            this.errors = error.response.data.errors || {};
        });
        }
    },
    mounted() {
        let self = this;
        $(document).ready(function() {
            $('body').on('click', '.btn-edit', function () {
                const userId = $(this).data('id'); // Obtén el ID del usuario
                // Lógica para cargar los datos del usuario en el modal
                self.loadUser(userId);
            });

            $('body').on('click', '.btn-delete', function () {
                var form = $(this).closest('form'); // Obtiene el formulario asociado al botón de borrar
                // Mostrar el diálogo de confirmación de SweetAlert
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
                        form.submit(); // Envía el formulario si se confirma
                    }
                });
            });
        });
    }
}
</script>
