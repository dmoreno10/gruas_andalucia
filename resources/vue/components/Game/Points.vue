<template>
    <div>
      <h1>Puntos</h1>
      <form @submit.prevent="addPoint">
        <select v-model="point.employee_id">
          <option disabled value="">Seleccione un empleado</option>
          <option v-for="employee in employees" :key="employee.id" :value="employee.id">
            {{ employee.name }}
          </option>
        </select>
        <input v-model="point.points" type="number" placeholder="Puntos" required />
        <input v-model="point.description" type="text" placeholder="Descripción" />
        <button type="submit">Agregar Puntos</button>
      </form>

      <ul>
        <li v-for="p in points" :key="p.id">
          {{ p.employee.name }}: {{ p.points }} - {{ p.description }}
          <button @click="deletePoint(p.id)">Eliminar</button>
        </li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        point: {
          employee_id: '',
          points: '',
          description: '',
        },
        points: [],
        employees: [],
      };
    },
    mounted() {
      this.fetchPoints();
      this.fetchEmployees();
    },
    methods: {
        async fetchPoints() {
    try {
        const token = localStorage.getItem('authToken');
        const response = await fetch('/api/points', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            // Si la respuesta no es 200, podemos lanzar un error aquí
            throw new Error(`Error al obtener puntos: ${response.status} ${response.statusText}`);
        }

        const data = await response.json(); // Intenta analizar como JSON
        this.points = data; // Almacena los datos obtenidos
    } catch (error) {
        console.error('Hubo un problema con la operación fetch:', error);
        // Manejo adicional del error, tal vez mostrar un mensaje al usuario
    }
}
,
      async fetchEmployees() {
        try {
          const token = localStorage.getItem('authToken'); // Obtener el token aquí también
          const response = await fetch('/api/employees', {
            method: 'GET',
            headers: {
              'Authorization': `Bearer ${token}`, // Agregar el token en los encabezados
              'Content-Type': 'application/json'
            }
          });

          if (!response.ok) {
            throw new Error('Error al obtener empleados: ' + response.statusText);
          }

          const data = await response.json();
          this.employees = data; // Almacena los empleados obtenidos
        } catch (error) {
          console.error('Hubo un problema con la operación fetch:', error);
        }
      },
      async addPoint() {
        await fetch('/api/points', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`, // Asegúrate de incluir el token aquí también
          },
          body: JSON.stringify(this.point),
        });
        this.point = { employee_id: '', points: '', description: '' }; // Reset form
        this.fetchPoints(); // Refresh points list
      },
      async deletePoint(id) {
        await fetch(`/api/points/${id}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`, // Asegúrate de incluir el token aquí también
          },
        });
        this.fetchPoints(); // Refresh points list
      },
    },
  };
  </script>
