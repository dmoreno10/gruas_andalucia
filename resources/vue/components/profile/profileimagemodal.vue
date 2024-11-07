<template>
    <div class="profile-image-container" @mouseover="hover = true" @mouseleave="hover = false">
      <!-- Imagen de perfil con evento de clic -->
      <img
        :src="profileImage"
        alt="Perfil"
        class="profile-image img-fluid rounded-circle"
        @click="handleImageClick"
      />

      <!-- Input de archivo oculto -->
      <input
        type="file"
        @change="handleFileUpload"
        class="d-none"
        ref="fileInput"
        accept="image/*"
      />

      <!-- Icono de lápiz que aparece al hacer hover -->
      <button v-if="hover" @click="handleImageClick" class="edit-button">
        <i class="fas fa-pencil-alt"></i>
      </button>

      <!-- Modal -->
      <div v-if="showModal" class="modal fade show d-block" tabindex="-1" role="dialog" @click.self="closeModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Actualizar Imagen de Perfil</h5>
              <button type="button" class="btn-close" @click="closeModal"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="submitForm">
                <div class="form-group">
                  <input type="file" @change="handleFileUpload" class="form-control" required />
                  <span v-if="error" class="text-danger">{{ error }}</span>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Actualizar Imagen</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div v-if="showModal" class="modal-backdrop fade show"></div> <!-- Backdrop -->
    </div>
  </template>

  <script>
  export default {
    props: {
      profileImage: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        showModal: false, // Estado para mostrar/ocultar el modal
        hover: false, // Estado para mostrar/ocultar el lápiz
        formData: new FormData(), // Contendrá la imagen seleccionada
        error: null, // Error para la validación
      };
    },
    methods: {
      handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
          this.formData.append("profile_image", file);
          this.submitForm(); // Enviar el archivo inmediatamente después de seleccionar
        }
      },
      submitForm() {
        // Enviar la imagen al backend
        axios
          .post("/profile/update-image", this.formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            location.reload(); // Recarga la página para ver la nueva imagen
          })
          .catch((error) => {
            this.error = "Error al subir la imagen. Inténtalo de nuevo.";
          });
      },
      closeModal() {
        this.showModal = false;
      },
      handleImageClick() {
        // Abrir el input de archivo al hacer clic en la imagen
        this.$refs.fileInput.click(); // Activa el input de archivo
      },
    },
  };
  </script>

  <style scoped>
  .profile-image-container {
    position: relative; /* Para posicionar el botón del lápiz */
    display: inline-block; /* Permite centrar el botón en la imagen */
  }

  .profile-image {
    display: block; /* Elimina espacio en la parte inferior */
    width: 150px; /* Ajusta el tamaño según sea necesario */
    height: 150px; /* Ajusta el tamaño según sea necesario */
    transition: filter 0.3s ease; /* Transición suave para el filtro */
    cursor: pointer; /* Cambiar el cursor a pointer al pasar sobre la imagen */
  }

  .edit-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: transparent; /* Fondo transparente */
    border: none; /* Sin borde */
    color: white; /* Color blanco para el lápiz */
    font-size: 24px; /* Tamaño del ícono */
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .profile-image-container:hover .profile-image {
    filter: brightness(50%); /* Oscurece la imagen más */
  }
  </style>
