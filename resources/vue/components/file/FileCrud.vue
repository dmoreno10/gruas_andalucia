<template>
    <!-- Modal de Documentos -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modificación de datos de Documentos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="updateDocument">

                        <input type="hidden" id="documentId" v-model="document.id">

                        <div class="mb-3">
                            <label for="documentTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="documentTitle" v-model="document.title" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="documentDescription" v-model="document.description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="documentFileName" class="form-label">Nombre del Archivo</label>
                            <input type="text" class="form-control" id="documentFileName" v-model="document.file_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentFilePath" class="form-label">Ruta del Archivo</label>
                            <input type="text" class="form-control" id="documentFilePath" v-model="document.file_path" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentFileSize" class="form-label">Tamaño del Archivo (KB)</label>
                            <input type="number" class="form-control" id="documentFileSize" v-model="document.file_size" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentMimeType" class="form-label">Tipo MIME</label>
                            <input type="text" class="form-control" id="documentMimeType" v-model="document.mime_type" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentUploadDate" class="form-label">Fecha de Subida</label>
                            <input type="date" class="form-control" id="documentUploadDate" v-model="document.upload_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentTags" class="form-label">Etiquetas</label>
                            <input type="text" class="form-control" id="documentTags" v-model="document.tags">
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
            document: {
                id: '',
                title: '',
                description: '',
                file_name: '',
                file_path: '',
                file_size: '',
                mime_type: '',
                upload_date: '',
                tags: '',
            },
            errors: {}
        };
    },
    methods: {
        loadDocument(documentId) {
            console.log(documentId);
            axios.get(`/documents-gest/${documentId}`)
                .then(response => {
                    this.document = response.data;  // Asigna los datos del documento al objeto Vue
                    $('#modalForm').modal('show');  // Muestra el modal
                })
                .catch(error => {
                    console.error("Error al cargar los datos del documento:", error);
                });
        },
        updateDocument() {
            axios.put(`/documents-gest/${this.document.id}`, this.document)
                .then(response => {
                    // Mostrar mensaje de éxito
                    this.$swal('¡Éxito!', 'Documento actualizado correctamente.', 'success');
                    // Cerrar el modal
                    $('#modalForm').modal('hide');
                })
                .catch(error => {
                    // Manejo de errores
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
            // Cargar el documento en el modal al hacer clic en "editar"
            $('body').on('click', '.btn-edit', function() {
                const documentId = $(this).data('id'); // Obtener el ID del documento
                console.log("Botón edit clickeado con ID:", documentId); // Verificar si aquí imprime el ID
                self.loadDocument(documentId);  // Cargar el documento
            });

            // Manejo de eventos para confirmación de eliminación
            $('body').on('click', '.btn-delete', function() {
                var form = $(this).closest('form'); // Obtener el formulario asociado al botón de borrar
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
                        form.submit(); // Enviar el formulario si se confirma
                    }
                });
            });
        });
    }
};
</script>
