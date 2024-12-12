@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Detalles del Vehículo</h1>

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Información del Vehículo</h5>
            </div>

            <div class="card-body">
                <p><strong>Marca:</strong> {{ $vehicle->brand }}</p>
                <p><strong>Modelo:</strong> {{ $vehicle->model }}</p>
                <p><strong>Año:</strong> {{ $vehicle->year }}</p>
                <p><strong>Tipo:</strong> {{ $vehicle->type }}</p>
                <p><strong>Color:</strong> {{ $vehicle->color }}</p>
                <p><strong>Estado:</strong> {{ $vehicle->status }}</p>

                <!-- Galería de imágenes -->
                <h5 class="mt-4">Galería de Fotos</h5>
                <div class="row">
                    @foreach($photos as $photo)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/' . $photo) }}" class="img-fluid" alt="Imagen del vehículo">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
