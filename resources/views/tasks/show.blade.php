@if ($task)
    <h1>{{ $task->description }}</h1>
    <p>ID de Tarea: {{ $task->id }}</p> <!-- Para ver el ID -->
    <Temporizer :taskId="{{ $task->id }}" :csrfToken="'{{ csrf_token() }}'" />
@else
    <p>No se encontró la tarea.</p>
@endif
