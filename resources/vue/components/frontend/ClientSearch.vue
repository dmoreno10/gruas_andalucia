<template>
  <div>
    <div class="search-section">
      <h2>Buscar vehículo por matrícula</h2>
      <input type="text" v-model="searchQuery" placeholder="Introduzca la matrícula del vehículo" />
      <button @click="searchVehicle">Buscar</button>
    </div>

    <div v-if="searchResults" id="results" class="d-flex flex-column align-items-center results-section">
      <div class="d-flex justify-content" v-html="searchResults"></div>
    </div>

    <div class="container py-4">
      <div class="row justify-content-center">
        <!-- Grúas para coches -->
        <div class="col-12 col-md-4 mb-4 text-center">
          <div class="service-category">
            <!-- Icono de coche -->
            <i class="fas fa-car fa-4x mb-3" style="color: #0044cc;"></i>
            <h3>Grúas para coches</h3>
            <ul>
              <li>Grúas para coche en Andalucía</li>
              <li>Servicio de transporte para compraventa y coches particulares sin seguro</li>
            </ul>
          </div>
        </div>

        <!-- Grúas para motos -->
        <div class="col-12 col-md-4 mb-4 text-center">
          <div class="service-category">
            <!-- Icono de moto -->
            <i class="fas fa-motorcycle fa-4x mb-3" style="color: #0044cc;"></i>
            <h3>Grúas para motos</h3>
            <ul>
              <li>Grúa para moto en Andalucía</li>
              <li>Transporte de motos en Andalucía sin servicio de asistencia en carretera</li>
            </ul>
          </div>
        </div>

        <!-- Coches clásicos -->
        <div class="col-12 col-md-4 mb-4 text-center">
          <div class="service-category">
            <!-- Icono de coche clásico -->
            <i class="fas fa-car-side fa-4x mb-3" style="color: #0044cc;"></i>
            <h3>Coches clásicos</h3>
            <ul>
              <li>Grúa para coche clásico</li>
              <li>Traslado de vehículos históricos en Andalucía con medidas especiales</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      searchResults: null
    };
  },
  props: {
    vehicles: Array,
  },
  methods: {
    async searchVehicle() {
      if (!this.searchQuery.trim()) {
        this.searchResults = '<p style="color: red;">Por favor, introduzca una matrícula válida.</p>';
        return;
      }

      try {
        this.searchResults = `<p>Buscando información para la matrícula: <strong>${this.searchQuery}</strong>...</p>`;

        const response = await fetch(`/search-vehicle?searchQuery=${this.searchQuery}`);
        const data = await response.json();

        if (response.ok) {
          this.searchResults = `
            <div class="search-result-card">
              <h3>Resultado encontrado:</h3>
              <p><strong>Matrícula:</strong> ${data.vehicle.license_plate}</p>
              <p><strong>Estado:</strong> En depósito</p>
              <p><strong>Ubicación:</strong> ${data.deposit}</p>
              <p><strong>Fecha de ingreso:</strong> ${data.vehicle.created_at}</p>
            </div>
          `;
        } else {
          this.searchResults = `<p style="color: red;">${data.message}</p>`;
        }
      } catch (error) {
        this.searchResults = `<p style="color: red;">Hubo un error en la búsqueda.</p>`;
      }
    }
  }
};
</script>

<style scoped>
.search-section {
  margin: 30px auto;
  text-align: center;
  padding: 20px;
  max-width: 700px;
}

.search-section input[type="text"] {
  padding: 12px;
  width: 80%;
  max-width: 500px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  outline: none;
}

.search-section button {
  padding: 12px 24px;
  font-size: 16px;
  background-color: #0044cc;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
}

.search-section button:hover {
  background-color: #003399;
}

.service-category {
  margin-bottom: 20px;
}

.service-category h3 {
  color: #0044cc;
  margin-bottom: 10px;
  font-size: 20px;
}

.service-category ul {
  list-style-type: none;
  padding-left: 0;
}

.service-category ul li {
  line-height: 1.6;
  color: #333;
  margin-bottom: 8px;
}

.footer {
  background-color: #333;
  color: white;
  padding: 20px 0;
  text-align: center;
  font-size: 14px;
}

.footer .contact-info strong {
  color: #ffcc00;
}

.footer a {
  color: #ffcc00;
  text-decoration: none;
}

.footer a:hover {
  text-decoration: underline;
}

@media (max-width: 768px) {
  .search-section input[type="text"] {
    width: 90%;
  }

  .search-section button {
    width: 90%;
    font-size: 14px;
  }

  .info-section {
    padding: 15px;
  }
}

@media (max-width: 480px) {
  .footer {
    font-size: 12px;
  }
}
</style>
