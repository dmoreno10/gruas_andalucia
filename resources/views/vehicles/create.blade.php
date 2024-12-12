@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary">Registrar Vehículo</h1>

    <div class="col-12 col-md-10 col-lg-11 mx-auto">
        <div class="card shadow-lg border-light">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Formulario de Registro de Vehículo</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('vehicles.store') }}" method="POST" id="vehicleForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Marca -->
                    <div class="form-group">
                        <label for="brand" class="font-weight-bold">Marca:</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>

                    <!-- Modelo -->
                    <div class="form-group">
                        <label for="model" class="font-weight-bold">Modelo:</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                    </div>

                    <!-- Año -->
                    <div class="form-group">
                        <label for="year" class="font-weight-bold">Año:</label>
                        <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') }}" required>
                    </div>

                    <!-- Tipo -->
                    <div class="form-group">
                        <label for="type" class="font-weight-bold">Tipo:</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="SUV">SUV</option>
                            <option value="Sedán">Sedán</option>
                            <option value="Camioneta">Camioneta</option>
                            <option value="Coupé">Coupé</option>
                            <option value="Convertible">Convertible</option>
                            <option value="Hatchback">Hatchback</option>
                        </select>
                    </div>

                    <!-- Color -->
                    <div class="form-group">
                        <label for="color" class="font-weight-bold">Color:</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>

                    <!-- Estado -->
                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Estado:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" disabled selected>Seleccione un estado</option>
                            <option value="En Depósito">En Depósito</option>
                            <option value="Liberado">Liberado</option>
                            <option value="En Revisión">En Revisión</option>
                        </select>
                    </div>

                    <!-- Depósito Municipal -->
                    <div class="form-group">
                        <label for="municipal_deposit_id" class="font-weight-bold">Depósito Municipal:</label>
                        <select class="form-control" id="municipal_deposit_id" name="municipal_deposit_id" required>
                            <option value="" disabled selected>Seleccione un depósito</option>
                            @foreach($municipalDeposits as $deposit)
                                <option value="{{ $deposit->id }}">{{ $deposit->town }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Matrícula -->
                    <div class="form-group">
                        <label for="matricula" class="font-weight-bold">Matrícula:</label>
                        <input type="text" class="form-control" id="license_plate" name="license_plate" required>
                    </div>

                    <!-- Fotos -->
                    <div class="form-group">
                        <label for="photos" class="font-weight-bold">Fotos:</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple required>
                    </div>

                    <!-- Vista previa de las imágenes -->
                    <div id="imagePreview" class="d-flex flex-wrap mt-3"></div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Guardar Vehículo</button>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-lg"><i class="fas fa-times-circle"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('photos').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = ''; // Limpiar las vistas previas anteriores

        const files = event.target.files;
        if (files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.style.width = '100px'; // Ancho fijo para cada imagen
                    imgElement.style.marginRight = '10px';
                    imgElement.style.marginBottom = '10px';
                    imgElement.classList.add('img-thumbnail', 'border', 'border-light');
                    previewContainer.appendChild(imgElement);
                };

                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endsection
