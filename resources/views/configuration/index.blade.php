@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary">Configuración de la Cuenta</h1>

    <!-- Mensaje de éxito al actualizar la configuración -->
    @if(session('success'))
        <div id="successMessage" class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulario para crear o actualizar configuración -->
    <form action="{{ route('configuration.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-lg" style="max-width: 600px; margin: 0 auto;">
        @csrf

        <div class="mb-4">
            <h4 class="mb-3 text-center text-secondary">Cargar Imágenes</h4>

            <!-- Logo -->
            <div class="form-group mb-4 text-center">
                <label for="logo" class="form-label">Logo</label>
                <div class="input-group">
                    <input type="file" name="logo" class="form-control" accept="image/*" id="logo">
                </div>
                @error('logo')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Imagen de usuario -->
            <div class="form-group mb-4 text-center">
                <label for="user_image" class="form-label">Imagen de Usuario</label>
                <div class="input-group">
                    <input type="file" name="user_image" class="form-control" accept="image/*" id="user_image">
                </div>
                @error('user_image')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Botón para guardar la configuración -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">Guardar Configuración</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // Espera 5 segundos (5000 milisegundos) y luego oculta el mensaje de éxito
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            // Utiliza Bootstrap para ocultar la alerta
            successMessage.classList.remove('show');  // Quita la clase 'show'
            successMessage.classList.add('fade');  // Añade la clase 'fade'
        }
    }, 5000); // 5000 ms = 5 segundos
</script>
@endpush
