<template>
    <!-- Modal de Empleado -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modificación de datos de Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="updateEmployee">

                        <input type="hidden" id="employeeId" v-model="employee.id">

                        <div class="mb-3">
                            <label for="employeeName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="employeeName" v-model="employee.name" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="employeeEmail" v-model="employee.email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeePosition" class="form-label">Puesto</label>
                            <input type="text" class="form-control" id="employeePosition" v-model="employee.position" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeDepartment" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="employeeDepartment" v-model="employee.department" required>
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
            employee: {
                id: '',
                name: '',
                email: '',
                position: '',
                department: ''
            },
            errors: {}
        };
    },
    methods: {
        loadEmployee(employeeId) {
            console.log(employeeId);
            axios.get(`/employees/${employeeId}`)
                .then(response => {
                    this.employee = response.data;  // Asigna los datos del empleado al objeto Vue
                    $('#modalForm').modal('show');  // Muestra el modal
                })
                .catch(error => {
                    console.error("Error al cargar los datos del empleado:", error);
                });
        },
        updateEmployee() {
            axios.put(`/employees/${this.employee.id}`, this.employee)
                .then(response => {
                    // Mostrar mensaje de éxito
                    this.$swal('¡Éxito!', 'Empleado actualizado correctamente.', 'success');
                    $('#employees-table').DataTable().draw();
                    // Cerrar el modal
                    $('#modalForm').modal('hide');
                })
                .catch(error => {
                    // Control de errores
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
            // Cargar el empleado en el modal al hacer clic en "editar"
            $('body').on('click', '.btn-edit', function() {
                const employeeId = $(this).data('id'); // Obtener el ID del empleado
                console.log("Botón edit clickeado con ID:", employeeId); // Verificar si aquí imprime el ID
                self.loadEmployee(employeeId);  // Cargar el empleado
            });


            $('body').on('click', '.btn-delete', function() {
                var form = $(this).closest('form');
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
                        form.submit();
                    }
                });
            });
        });
    }
};
</script>
