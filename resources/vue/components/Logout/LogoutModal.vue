<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h3 class="modal-title">Cerrar sesión</h3>
        <p class="modal-message">¿Estás seguro de que quieres cerrar sesión?</p>
        <div class="modal-actions">
          <button class="btn-confirm" @click="confirmLogout">Sí, cerrar sesión</button>
          <button class="btn-cancel" @click="closeModal">Cancelar</button>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        isVisible: false,
      };
    },
    methods: {
      openModal() {
        this.isVisible = true;
      },
      closeModal() {
        this.isVisible = false;
      },
      confirmLogout() {
        document.getElementById('logout-form').submit();

        this.isVisible = false;
      },
    },
  };
  </script>

  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease;
  }

  .modal-content {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 350px;
    max-width: 90%;
    animation: slideUp 0.3s ease;
  }

  .modal-title {
    margin-bottom: 15px;
    font-size: 1.5rem;
    color: #333;
  }

  .modal-message {
    margin-bottom: 20px;
    font-size: 1rem;
    color: #666;
  }

  .modal-actions {
    display: flex;
    justify-content: space-around;
  }

  .btn-confirm, .btn-cancel {
    background-color: #f0f0f0;
    color: #333;
    padding: 10px 20px;
    border: 2px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s, border-color 0.3s;
  }

  .btn-confirm:hover, .btn-cancel:hover {
    background-color: #e6e6e6;
    border-color: #ccc;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  @keyframes slideUp {
    from {
      transform: translateY(20px);
    }
    to {
      transform: translateY(0);
    }
  }
  </style>
