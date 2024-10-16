<!-- resources/views/incidents/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Incidencia</title>
</head>
<body>
    <h1>Detalles de Incidencia</h1>

    <p><strong>ID:</strong> {{ $incident->id }}</p>
    <p><strong>Título:</strong> {{ $incident->title }}</p>
    <p><strong>Descripción:</strong> {{ $incident->description }}</p>
    <p><strong>Estado:</strong> {{ $incident->status }}</p>

    <!-- Puedes agregar más campos si es necesario, como fecha de creación, actualización, etc. -->
    <p><strong>Creado el:</strong> {{ $incident->created_at }}</p>
    <p><strong>Actualizado el:</strong> {{ $incident->updated_at }}</p>

    <!-- Botones para editar o regresar a la lista de incidencias -->
    <a href="{{ route('incidents.edit', $incident->id) }}" class="btn btn-primary">Editar</a>
    <a href="{{ route('incidents.index') }}" class="btn btn-secondary">Regresar a la lista</a>
</body>
</html>
