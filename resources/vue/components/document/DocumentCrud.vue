<template>
  <!-- Modal para Crear/Editar Documento -->
  <div class="modal fade" id="documentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="staticBackdropLabel">{{ isEditing ? 'Editar Documento' : 'Añadir Nuevo Documento' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="isEditing ? updateDocument() : createDocument">
            <div class="mb-3">
              <label for="title" class="form-label">Título del Documento</label>
              <input type="text" class="form-control" id="title" v-model="document.title" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <textarea class="form-control" id="description" v-model="document.description" required></textarea>
            </div>

            <div class="mb-3">
              <label for="document" class="form-label">Subir Documento</label>
              <input type="file" class="form-control" id="document" ref="fileInput" @change="handleFileChange" :disabled="isEditing">
            </div>

            <button type="submit" class="btn btn-primary">{{ isEditing ? 'Actualizar Documento' : 'Subir Documento' }}</button>
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
import axios from 'axios';

export default {
  data() {
    return {
      document: {
        id: '',
        title: '',
        description: '',
        file: null,
      },
      isEditing: false,
    };
  },
  methods: {
    // Método para abrir el modal en modo creación
    openModal() {
      this.resetForm();
      const modal = new bootstrap.Modal(document.getElementById('documentModal'));
      modal.show();
    },

    // Método para abrir el modal en modo edición
    openEditModal(documentData) {
      this.document = { ...documentData, file: null }; // No asignamos el archivo al editar
      this.isEditing = true;
      const modal = new bootstrap.Modal(document.getElementById('documentModal'));
      modal.show();
    },

    // Método para cerrar el modal
    closeModal() {
      const modal = bootstrap.Modal.getInstance(document.getElementById('documentModal'));
      modal.hide();
    },

    // Método para crear un nuevo documento
    createDocument() {
      const formData = new FormData();
      formData.append('title', this.document.title);
      formData.append('description', this.document.description);
      if (this.document.file) {
        formData.append('document', this.document.file);
      }

      axios.post('/documents-gest', formData)
        .then(response => {
          this.$swal('¡Éxito!', 'Documento creado correctamente.', 'success');
          this.closeModal();
          // Aquí puedes agregar lógica para actualizar la tabla o la vista
        })
        .catch(error => {
          console.error('Error creando documento', error);
        });
    },
    mounted(){
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

    // Método para actualizar un documento existente
    updateDocument() {
      const formData = new FormData();
      formData.append('title', this.document.title);
      formData.append('description', this.document.description);
      if (this.document.file) {
        formData.append('document', this.document.file);
      }

      axios.put(`/documents-gest/${this.document.id}`, formData)
        .then(response => {
          this.$swal('¡Éxito!', 'Documento actualizado correctamente.', 'success');
          this.closeModal();
          // Aquí puedes agregar lógica para actualizar la tabla o la vista
        })
        .catch(error => {
          console.error('Error actualizando documento', error);
        });
    },

    // Método para manejar el archivo seleccionado
    handleFileChange(event) {
      this.document.file = event.target.files[0];
    },

    // Resetear el formulario
    resetForm() {
      this.document = {
        id: '',
        title: '',
        description: '',
        file: null,
      };
      this.isEditing = false;
    },
  },
};

</script>

<style scoped>
/* Estilos para el modal */
.modal-content {
  border-radius: 15px;
}
.modal-header {
  border-bottom: none;
}
.modal-footer {
  border-top: none;
}
</style>
