@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Tarea: {{ $task->description }}</h3>
    <p>Puntos: {{ $task->points }}</p>
    <temporizer-crud :task-id="{{ $task->id }}" csrf-token="{{ csrf_token() }}"></temporizer-crud>

</div>
@endsection
