<template>
    <div>
      <!-- Sección de Contacto -->
      <div class="contact-section">
        <h2>Contacto de Grúas Andalucía</h2>
        <p><strong>Teléfono:</strong> +34 900 123 456</p>
        <p><strong>Email:</strong> contacto@gruasandalucia.com</p>
        <p><strong>Dirección:</strong> Calle de la Retirada, 123, 41000 Mijas, Andalucía</p>
        <p><strong>Horario de Atención:</strong> Lunes a Viernes, de 9:00 AM a 6:00 PM</p>
        <p><strong>Servicio de Emergencia:</strong> Disponible las 24 horas, los 7 días de la semana.</p>
      </div>
  
      <!-- Información Adicional -->
      <div class="additional-info-section container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-6 mb-4 text-center">
            <div class="info-card">
              <h3>¿Por qué elegir Grúas Andalucía?</h3>
              <ul>
                <li>Experiencia de más de 20 años en el sector.</li>
                <li>Retiros rápidos y seguros en toda Andalucía.</li>
                <li>Atención personalizada y disponible las 24 horas.</li>
                <li>Precios competitivos y sin sorpresas.</li>
              </ul>
            </div>
          </div>
  
          <div class="col-12 col-md-6 mb-4 text-center">
            <div class="info-card">
              <h3>Área de Cobertura</h3>
              <p>Operamos en toda la comunidad autónoma de Andalucía, incluyendo las principales ciudades como Sevilla, Málaga, Granada, y Córdoba.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {};
    },
    methods: {},
  };
  </script>
  
  <style scoped>
  .contact-section {
    text-align: center;
    margin: 30px auto;
    padding: 20px;
  }
  
  .contact-section h2 {
    font-size: 2rem;
    color: #0044cc;
  }
  
  .contact-section p {
    font-size: 1.2rem;
    color: #333;
  }
  
  .additional-info-section {
    margin-top: 50px;
    text-align: center;
  }
  
  .info-card {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
  }
  
  .info-card h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #0044cc;
  }
  
  .info-card ul {
    list-style-type: none;
    padding-left: 0;
  }
  
  .info-card ul li {
    color: #333;
    margin-bottom: 8px;
  }
  
  .info-card p {
    color: #333;
    font-size: 1.1rem;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .contact-section {
      padding: 15px;
    }
  
    .additional-info-section {
      margin: 20px;
    }
  }
  </style>
  