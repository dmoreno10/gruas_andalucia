<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Empleado</title>
    <style>
        /* Estilos para el PDF */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Detalles del Empleado</h1>
    <p><strong>ID:</strong> {{ $employee->id }}</p>
    <p><strong>Nombre:</strong> {{ $employee->name }}</p>
    <p><strong>Correo Electrónico:</strong> {{ $employee->email }}</p>
    <p><strong>Puesto:</strong> {{ $employee->position }}</p>
    <p><strong>Fecha de Contratación:</strong> {{ $employee->hired_at->format('d/m/Y') }}</p>
    <!-- Agrega más detalles según sea necesario -->
</body>
</html>
