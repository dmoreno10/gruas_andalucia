<template>
    <div class="table-responsive">
        <table id="users-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        filters: Object
    },
    mounted() {
        this.initializeDataTable();
    },
    methods: {
        initializeDataTable() {
            const table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("users.index") }}',
                    data: d => {
                        Object.assign(d, this.filters); // Añadir filtros avanzados de Vue
                    }
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'created_at', name: 'created_at' }
                ]
            });

            this.$on('updateDataTable', () => {
                table.ajax.reload(null, false); // Recarga sin reiniciar la paginación
            });
        }
    }
};
</script>

<style scoped>
.table-responsive {
    margin-top: 1rem;
}
</style>
