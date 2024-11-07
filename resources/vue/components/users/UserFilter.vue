<template>
    <div class="filters">
        <input
            v-model="filters.name"
            @input="applyFilters"
            placeholder="Buscar por nombre"
            class="form-control mb-3"
        />

        <select v-model="filters.role" @change="applyFilters" class="form-control mb-3">
            <option value="">Seleccionar rol</option>
            <option value="admin">Admin</option>
            <option value="user">Usuario</option>
        </select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            filters: {
                name: '',
                role: ''
            }
        };
    },
    methods: {
        applyFilters() {
            this.$emit('apply-filters', this.filters);
        }
    }
};
</script>

<style scoped>
.filters {
    margin-bottom: 1rem;
}
</style>
