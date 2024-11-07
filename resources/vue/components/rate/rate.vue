<template>
    <div id="gradient">
        <main class="container-xl d-flex flex-column justify-content-center align-items-center">
            <section class="row pt-4 pb-4">
                <div class="col-4 pt-4 pb-4 position-relative">
                    <img @click="openModal('camiones')" class="rate-image" src="../../../dist/img/tarifa/Opción_Tarifa.png" alt="Rate Option 1">
                </div>
                <div class="col-4 pt-4 pb-4 position-relative">
                    <img @click="openModal('bicicletas')" class="rate-image" src="../../../dist/img/tarifa/Opción_Tarifa2.png" alt="Rate Option 2">
                </div>
                <div class="col-4 pt-4 pb-4 position-relative">
                    <img @click="openModal('vehiculos_ingresados')" class="rate-image" src="../../../dist/img/tarifa/Opción_Tarifa3.png" alt="Rate Option 3">
                </div>
                <div class="col-4 pt-4 pb-4 position-relative">
                    <img @click="openModal('motos')" class="rate-image" src="../../../dist/img/tarifa/Opción_Tarifa4.png" alt="Rate Option 4">
                </div>
                <div class="col-4 pt-4 pb-4 position-relative">
                    <img @click="openModal('remolques')" class="rate-image" src="../../../dist/img/tarifa/Opción_Tarifa5.png" alt="Rate Option 5">
                </div>
                <div class="col-4 pt-4 pb-4 position-relative">
                    <img @click="openModal('peticion_particulares')" class="rate-image" src="../../../dist/img/tarifa/Opción_Tarifa6.png" alt="Rate Option 6">
                </div>
            </section>

            <!-- Modal -->
            <modal-component v-if="isModalOpen" :icon="modalIcon" @close="closeModal" />
        </main>
    </div>
</template>

<script>
import ModalComponent from './ModalComponent.vue'; // Importa el componente del modal

export default {
    name: 'RateInfo',
    components: {
        ModalComponent, // Registra el componente del modal
    },
    data() {
        return {
            isModalOpen: false,
            modalIcon: '',
        };
    },
    methods: {
        openModal(rateType) {
            this.isModalOpen = true;
            switch (rateType) {
                case 'camiones':
                    this.modalIcon = 'fas fa-truck'; // Icono para camiones
                    break;
                case 'bicicletas':
                    this.modalIcon = 'fas fa-bicycle'; // Icono para bicicletas
                    break;
                case 'vehiculos_ingresados':
                    this.modalIcon = 'fas fa-car'; // Icono para vehículos ingresados
                    break;
                case 'motos':
                    this.modalIcon = 'fas fa-motorcycle'; // Icono para motos
                    break;
                case 'remolques':
                    this.modalIcon = 'fas fa-trailer'; // Icono para remolques
                    break;
                case 'peticion_particulares':
                    this.modalIcon = 'fas fa-user'; // Icono para petición de particulares
                    break;
                default:
                    this.modalIcon = '';
            }
        },
        closeModal() {
            this.isModalOpen = false;
            this.modalIcon = ''; // Limpia el icono al cerrar
        }
    }
};
</script>

<style scoped>
body {
    background-color: #000000;
    background-repeat: no-repeat;
}

#gradient {
    width: 100%;
    height: 800px;
    padding: 0;
    margin: 0;
}

main {
    background-color: rgba(255, 255, 255, 0.199);
    border-radius: 15px;
}

/* Estilo para las imágenes */
.rate-image {
    width: 100%; /* Asegúrate de que la imagen ocupe todo el ancho disponible */
    transition: filter 0.3s ease; /* Añadir transición para un efecto suave en la sombra */
    position: relative; /* Para el pseudo-elemento */
    z-index: 1; /* Asegura que la imagen esté por encima del pseudo-elemento */
}

/* Sombra interna al pasar el mouse */
.rate-image:hover {
    filter: brightness(0.8); /* Cambia el brillo para dar un efecto de sombra interna */
}

.position-relative {
    position: relative; /* Asegura que el contenedor tenga un contexto para el pseudo-elemento */
}

.position-relative::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3); /* Color de la sombra interna */
    border-radius: 15px; /* Opcional: para que la sombra interna sea redondeada */
    opacity: 0; /* Inicialmente invisible */
    transition: opacity 0.3s ease; /* Efecto de transición suave */
    z-index: 0; /* Asegúrate de que el pseudo-elemento esté detrás de la imagen */
}

.position-relative:hover::after {
    opacity: 1; /* Muestra la sombra interna al pasar el mouse */
}
</style>
