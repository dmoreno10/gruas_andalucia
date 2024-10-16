@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Configuración</h1>

    <!-- Mensaje de éxito al actualizar la configuración -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulario para crear o actualizar configuración -->
    <form action="{{ route('configuration.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Logo -->
        <div class="form-group">
            <label for="logo">Logo</label>
            @if(isset($configuracion) && $configuracion->logo)
                <p>Logo actual: <img src="{{ asset('storage/' . $configuracion->logo) }}" width="100" alt="Logo"></p>
            @endif
            <input type="file" name="logo" class="form-control">
            @error('logo')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Imagen de usuario -->
        <div class="form-group">
            <label for="user_image">Imagen de Usuario</label>
            @if(isset($configuracion) && $configuracion->user_image)
                <p>Imagen de usuario actual: <img src="{{ asset('storage/' . $configuracion->user_image) }}" width="100" alt="Imagen de usuario"></p>
            @endif
            <input type="file" name="user_image" class="form-control">
            @error('user_image')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Botón para guardar la configuración -->
        <button type="submit" class="btn btn-primary">Guardar configuración</button>
    </form>

</div>
@endsection


