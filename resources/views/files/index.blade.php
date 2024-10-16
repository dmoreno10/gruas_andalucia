@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Gestión de Archivos</h2>

    <!-- Mostrar mensajes de éxito o error -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Formulario para subir archivos -->
    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Selecciona un archivo</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir archivo</button>
    </form>

    <!-- Listado de archivos -->
    <h3 class="mt-5">Archivos subidos:</h3>
    <ul class="list-group">
        @foreach ($files as $file)
            <li class="list-group-item">
                <a href="{{ Storage::url($file->file_path) }}" target="_blank">
                    {{ $file->file_name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
