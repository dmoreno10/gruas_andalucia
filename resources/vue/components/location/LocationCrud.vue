<template>
    <div class="map-container">
      <div id="map" class="map"></div>
      <div class="geocoder-control"></div>
    </div>
  </template>

  <script>
  import L from 'leaflet';
  import 'leaflet/dist/leaflet.css';
  import 'leaflet-control-geocoder/dist/Control.Geocoder.css'; // Asegúrate de importar el CSS del geocoder
  import 'leaflet-control-geocoder'; // Importar el geocoder

  export default {
    name: 'LocationCrud',
    mounted() {
      this.initMap();
    },
    methods: {
      initMap() {
        // Inicializar el mapa centrado en Málaga
        const map = L.map('map').setView([36.7213, -4.4214], 13); // Cambiadas las coordenadas a Málaga

        // Agregar la capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: 'Map data © <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        // Agregar un marcador en Málaga
        const marker = L.marker([36.7213, -4.4214]).addTo(map) // Cambiadas las coordenadas del marcador
          .bindPopup('Un marcador en Málaga.') // Cambiado el texto del popup
          .openPopup();

        // Agregar el control de geocodificación
        const geocoder = L.Control.geocoder({
          defaultMarkGeocode: true,
          collapsed: true,
          position: 'topright',
        }).on('markgeocode', (e) => {
          const center = e.geocode.center;
          map.setView(center, 13); // Centra el mapa en la ubicación buscada
          marker.setLatLng(center); // Mueve el marcador a la ubicación buscada
          marker.bindPopup(e.geocode.name).openPopup(); // Actualiza el popup con el nombre de la ubicación
        }).addTo(map);
      },
    },
  };
  </script>

  <style>
  .map-container {
    position: relative; /* Para posicionar el geocoder sobre el mapa */
    height: 500px;
    width: 100%;
    border-radius: 10px; /* Bordes redondeados */
    overflow: hidden; /* Para evitar desbordamiento */
  }

  .map {
    height: 100%;
    border: 2px solid #007bff; /* Cambiar el color del borde a azul */
    border-radius: 10px; /* Bordes redondeados */
  }

  .leaflet-control-geocoder {
    background: white;
    border-radius: 4px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.65);
    padding: 10px;
    z-index: 1000; /* Asegúrate de que el buscador esté por encima del mapa */
  }

  .leaflet-control-geocoder input {
    width: 220px; /* Ancho del campo de búsqueda */
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    transition: border-color 0.3s; /* Transición suave para el borde */
  }

  .leaflet-control-geocoder input:focus {
    border-color: #007bff; /* Color de borde al enfocar (azul) */
    outline: none; /* Eliminar el contorno predeterminado */
  }

  .leaflet-control-geocoder button {
    background-color: #007bff; /* Cambiar el botón a azul */
    border: none;
    border-radius: 4px;
    color: white;
    padding: 5px 10px;
    margin-left: 5px;
    cursor: pointer;
    transition: background-color 0.3s; /* Transición suave para el botón */
  }

  .leaflet-control-geocoder button:hover {
    background-color: #0056b3; /* Azul más oscuro al pasar el ratón */
  }
  </style>
