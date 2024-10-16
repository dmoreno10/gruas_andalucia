@extends('layouts.app')  <!-- Extiende tu layout principal -->

@section('content')
<div class="container">
    <div class="row justify-content-center"> <!-- Centra el contenido en la fila -->
        <div class="col-md-6"> <!-- Establece el ancho del formulario -->
            <h2 class="text-center">Subir nuevo documento</h2> <!-- Centra el título -->

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
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf  <!-- Token CSRF obligatorio en formularios de Laravel -->

                <div class="form-group">
                    <label for="title">Título del documento</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="document">Subir archivo</label>
                    <input type="file" name="document" id="document" class="form-control-file" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3 d-block mx-auto">Subir documento</button>
            </form>

            <!-- Enlace para regresar -->
            <div class="text-center mt-3">
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">Volver a documentos</a>
            </div>
        </div>
    </div>
</div>
@endsection
