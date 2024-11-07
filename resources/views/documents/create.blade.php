@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>{{ __('Subir Nuevo Documento') }}</h4>
                </div>

                <div class="card-body">
                    <!-- Mostrar los mensajes de éxito o errores -->
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario de creación de documentos -->
                    <form action="{{ route('documents-gest.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf  <!-- Token CSRF obligatorio en formularios de Laravel -->

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Título del Documento') }}</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Descripción') }}</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">{{ __('Subir Archivo') }}</label>
                            <input type="file" name="document" id="document" class="form-control @error('document') is-invalid @enderror" required>
                            @error('document')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 d-block mx-auto">{{ __('Subir Documento') }}</button>
                    </form>

                    <!-- Enlace para regresar -->
                    <div class="text-center mt-3">
                        <a href="{{ route('documents-gest.index') }}" class="btn btn-secondary">{{ __('Volver a Documentos') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
