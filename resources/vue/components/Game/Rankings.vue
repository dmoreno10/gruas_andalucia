<template>
    <div>
      <h1>Clasificación de Puntos por Empleado</h1>
      <canvas id="rankingChart"></canvas> <!-- Aquí se renderizará el gráfico -->
    </div>
  </template>

  <script>
  import Chart from 'chart.js/auto'; // Importa Chart.js completo

  export default {
    data() {
      return {
        rankings: [],
        chart: null, // Para almacenar la instancia de Chart.js
      };
    },
    mounted() {
      this.fetchRankings();
    },
    methods: {
      async fetchRankings() {
        const response = await fetch('/api/rankings');
        this.rankings = await response.json();
        this.renderChart(); // Renderizar el gráfico después de obtener los datos
      },
      renderChart() {
        // Destruir gráfico anterior si existe
        if (this.chart) {
          this.chart.destroy();
        }

        // Preparar los datos para el gráfico
        const labels = this.rankings.map(r => r.name); // Nombres de los empleados
        const data = this.rankings.map(r => r.total_points); // Total de puntos por empleado

        // Crear una nueva instancia de Chart.js para la gráfica de barras
        const ctx = document.getElementById('rankingChart').getContext('2d');
        this.chart = new Chart(ctx, {
          type: 'bar', // Especificar el tipo de gráfico
          data: {
            labels: labels,
            datasets: [
              {
                label: 'Total de Puntos',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'top',
              },
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1,
                },
              },
            },
          },
        });
      },
    },
  };
  </script>

  <style scoped>
  canvas {
    max-width: 800px;
    margin: auto;
  }
  </style>
