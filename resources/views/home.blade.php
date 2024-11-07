@extends('layouts.app')

@section('content')
<div class="main-container">
    <header class="header">
        <h1>Bienvenido a la Aplicación</h1>
        <p class="subtitle">Gestione sus reservas de manera fácil y rápida</p>
    </header>

    <div class="content">
        <div class="welcome-message">
            <h2>¡Hola, {{ (Auth::user()) ? Auth::user()->name : 'invitado' }}!</h2>
            <p>Esta es la vista principal de la aplicación. Desde aquí podrás gestionar tus reservas, ver tus eventos y mucho más.</p>
            <div class="button-container">
                <a href="{{ route('reservations.index') }}" class="primary-button">Ver Reservas</a>
                <a href="{{ route('events.index') }}" class="primary-button">Ver Eventos</a>
            </div>
        </div>

        <div class="features">
            <h3>Características Principales:</h3>
            <ul>
                <li>✨ Crear y gestionar reservas fácilmente.</li>
                <li>📅 Visualización de eventos en un calendario.</li>
                <li>👩‍💻 Interfaz intuitiva y amigable.</li>
                <li>🤝 Soporte en tiempo real para cualquier duda.</li>
                <li>🔔 Notificaciones de eventos y recordatorios.</li>
                <li>📱 Integración con redes sociales para compartir tus eventos.</li>
            </ul>
        </div>

        <div class="stats">
            <h3>Estadísticas Rápidas:</h3>
            <div class="stat-box">
                <h4>Total de Reservas</h4>
                <p>150</p>
            </div>
            <div class="stat-box">
                <h4>Total de Eventos</h4>
                <p>25</p>
            </div>
            <div class="stat-box">
                <h4>Usuarios Activos</h4>
                <p>320</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Su Empresa. Todos los derechos reservados.</p>
    </footer>
</div>
@endsection

<style scoped>
    body {
        background-image: linear-gradient(to right, #e6f9ff, #cceeff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    .main-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px;
        background: linear-gradient(to right, #3498db, #2ecc71);
        border-radius: 15px;
        color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .subtitle {
        font-size: 1.25rem;
        margin-bottom: 0;
    }

    .content {
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .welcome-message {
        margin-bottom: 30px;
        text-align: center;
    }

    .welcome-message h2 {
        font-size: 2rem;
        color: #2c3e50;
    }

    .welcome-message p {
        font-size: 1.1rem;
        color: #7f8c8d;
        margin: 10px 0;
    }

    .button-container {
        margin-top: 15px;
    }

    .primary-button {
        padding: 12px 24px;
        margin: 10px;
        background-color: #2ecc71;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease, transform 0.2s ease;
        font-size: 1rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .primary-button:hover {
        background-color: #27ae60;
        transform: translateY(-3px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .features {
        margin-top: 30px;
    }

    .features h3 {
        font-size: 1.5rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .features ul {
        list-style-type: none;
        padding-left: 0;
        margin: 0;
        text-align: left;
    }

    .features li {
        font-size: 1.1rem;
        color: #34495e;
        margin: 8px 0;
        position: relative;
        padding-left: 25px; /* Espacio para el ícono */
    }

    .features li::before {
        content: '✔'; /* Utilizar un ícono de verificación */
        color: #2ecc71; /* Color verde para el ícono */
        position: absolute;
        left: 0;
        font-size: 1.2rem; /* Tamaño del ícono */
    }

    .stats {
        margin-top: 30px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap; /* Permitir que los elementos se envuelvan */
    }

    .stat-box {
        background-color: #ecf0f1;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        flex: 1 1 30%; /* Asegura que todos los boxes tengan un tamaño mínimo */
        margin: 10px; /* Margen entre los boxes */
        transition: transform 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .stat-box h4 {
        margin-bottom: 10px;
        color: #34495e;
        font-size: 1.2rem;
    }

    .stat-box p {
        font-size: 1.5rem;
        color: #2c3e50;
        font-weight: bold;
    }

    .footer {
        text-align: center;
        margin-top: 30px;
        color: #95a5a6;
        font-size: 0.9rem;
    }
</style>
