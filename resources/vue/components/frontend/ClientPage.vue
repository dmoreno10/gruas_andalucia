<template>
    <div class="content-wrapper bg-gray-100 min-h-screen">
      <!-- Navbar -->
      <nav class="bg-black text-white py-4 px-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
          <!-- Logo -->
  
          <!-- Mobile Menu Toggle Button -->
          <div v-if="isMobile" class="flex md:hidden">
            <button @click="toggleMenu" class="btn focus:outline-none">
              <i class="fa fa-bars text-white"></i>
            </button>
          </div>
  
          <!-- Menu for Desktop (Large screens) -->
          <ul v-if="!isMobile" class="d-flex align-items-center">
            <li><a @click="toggleSection('home')" class="hover:text-yellow-400 transition">Inicio</a></li>
            <li><a @click="toggleSection('searchVehicles')" class="hover:text-yellow-400 transition">Buscar Vehiculo</a></li>
            <li><a @click="toggleSection('contactInfo')" class="hover:text-yellow-400 transition">Contacto</a></li>
          </ul>
        </div>
        <ul v-if="isMobile && showMobileMenu"
            class="absolute top-16 left-0 w-full bg-black text-white flex flex-col items-center py-4 shadow-lg z-50">
            <li class="w-full">
                <a @click="toggleSection('home')" class="block w-full py-3 px-4 text-center hover:bg-gray-700 transition">
                    Inicio
                </a>
            </li>
            <li class="w-full">
                <a @click="toggleSection('searchVehicles')" class="block w-full py-3 px-4 text-center hover:bg-gray-700 transition">
                    Buscar Vehículo
                </a>
            </li>
            <li class="w-full">
                <a @click="toggleSection('contactInfo')" class="block w-full py-3 px-4 text-center hover:bg-gray-700 transition">
                    Contacto
                </a>
            </li>
        </ul>
  
      </nav>
  
      <!-- Mostrar las secciones dependiendo de la acción -->
      <client-contact v-if="showContactInfo" @close="closeContactInfo" />
      <client-crud v-if="showSearchVehicles" :vehicles="vehicles" @close="closeSearchVehicles" />
      <div v-if="!showSearchVehicles && !showContactInfo && showHome">
        <!-- Contenido de la página de inicio (Imagen y Descripción) -->
        <section class="relative bg-cover bg-center d-flex flex-column justify-content-end "
            style="background-image: url('/documents/gruas.jpg'); background-repeat: none; background-size: cover; height: 700px;">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </section>
        <div class="d-flex flex-column align-items-center  ">
          <h3 class="text-3xl font-bold mb-6 text-black">Nuestros Servicios de Retiro</h3>
          <p class="text-lg max-w-3xl mx-auto text-black mb-8">
              Con más de 20 años de experiencia en el sector, ofrecemos un servicio rápido y seguro para el retiro
              de vehículos.
              Disponibilidad 24/7 para toda Andalucía.
          </p>
        </div>
      </div>
  
    </div>
    <footer class="footer bg-blue-900 text-white py-6 text-center mt-auto">
      <p>&copy; 2024 Grúas Andalucía. Todos los derechos reservados.</p>
    </footer>
  </template>
  
  <script>
  import Client from './ClientSearch.vue';
  import ClientContact from './ClientContact.vue';
  
  export default {
    name: "ClientePage2",
    components: {
      Client,
      ClientContact
    },
    props: {
      vehicles: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        isMobile: false,
        showMobileMenu: false,
        showSearchVehicles: false,
        showContactInfo: false,
        showHome: true,
      };
    },
    mounted() {
      this.checkMobile();
      window.addEventListener("resize", this.checkMobile);
    },
    beforeDestroy() {
      window.removeEventListener("resize", this.checkMobile);
    },
    methods: {
      checkMobile() {
        this.isMobile = window.innerWidth <= 768;
        if (!this.isMobile) {
          this.showMobileMenu = false;
        }
      },
      toggleMenu() {
        this.showMobileMenu = !this.showMobileMenu;
      },
      toggleSection(section) {
        // Cerrar todas las secciones primero
        this.showHome = false;
        this.showSearchVehicles = false;
        this.showContactInfo = false;
  
        // Abrir la sección seleccionada
        if (section === 'home') {
          this.showHome = true;
        } else if (section === 'searchVehicles') {
          this.showSearchVehicles = true;
        } else if (section === 'contactInfo') {
          this.showContactInfo = true;
        }
      },
      closeSearchVehicles() {
        this.showSearchVehicles = false;
      },
      closeContactInfo() {
        this.showContactInfo = false;
      },
    },
  }
  </script>
  
  <style scoped>
  ul {
    display: flex;
    justify-content: center;
    gap: 20px;
  }
  
  ul li {
    list-style-type: none;
  }
  
  ul li a {
    text-decoration: none;
    color: white;
    padding: 10px 15px;
    transition: color 0.3s ease, background-color 0.3s ease;
    border-radius: 5px;
  }
  
  ul li a:hover {
    color: #ffcc00;
    background-color: rgba(255, 255, 255, 0.1);
  }
  
  /* Mobile Menu */
  ul.bg-black {
    display: block;
    width: 100%;
  }
  
  ul.bg-black li a {
    display: block;
    padding: 12px;
    text-align: center;
    font-size: 18px;
    border-bottom: 1px solid #555;
  }
  
  ul.bg-black li a:hover {
    background-color: #444;
  }
  
  .content-wrapper {
    display: flex;
    position: relative;
    flex-direction: column;
    min-height: 100vh;
  }
  
  footer {
    position: relative;
    margin-top: auto;
    background-color: #003366;
    text-align: center;
    color: white;
    padding: 20px;
  }
  
  @media (min-width: 769px) {
    ul {
      display: flex;
      justify-content: space-around;
    }
  }
  </style>
  