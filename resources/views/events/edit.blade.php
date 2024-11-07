@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Evento</h1>

        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                @error('title')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_time">Hora de Inicio</label>
                <input type="datetime-local" id="start_time" name="start_time" class="form-control" value="{{ old('start_time', $event->start_time) }}" required>
                @error('start_time')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">Hora de Fin</label>
                <input type="datetime-local" id="end_time" name="end_time" class="form-control" value="{{ old('end_time', $event->end_time) }}" required>
                @error('end_time')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
        </form>
    </div>
@endsection
