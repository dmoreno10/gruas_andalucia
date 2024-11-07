<template>
    <div class="modal-backdrop">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Borrado</h5>
                    <button type="button" class="close" @click="$emit('close')">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas borrar esta tarea?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="$emit('close')">Cancelar</button>
                    <button type="button" class="btn btn-danger" @click="$emit('confirm', taskId)">Borrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['taskId'],
};
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
