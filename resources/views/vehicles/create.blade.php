@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Crear Vehículo</h1>

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Formulario de Vehículo</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('vehicles.store') }}" method="POST" id="vehicleForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="brand">Marca:</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>

                    <div class="form-group">
                        <label for="model">Modelo:</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                    </div>

                    <div class="form-group">
                        <label for="year">Año:</label>
                        <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Tipo:</label>
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

                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Estado:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" disabled selected>Seleccione un estado</option>
                            <option value="Nuevo">Nuevo</option>
                            <option value="Usado">Usado</option>
                            <option value="Reparación">Reparación</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="photos">Fotos:</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple required>
                    </div>


                    <button type="submit" class="btn btn-success">Guardar Vehículo</button>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
