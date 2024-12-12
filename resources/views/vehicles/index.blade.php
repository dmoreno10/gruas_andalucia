@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Vehículos</h1>

    <div class="col-md-12">
        <p class="text-muted">Vehículos registrados y su estado actual</p>
        <hr>

        <div class="row">
            <div class="card card-outline shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manejo de Vehículos</h5>
                    <div class="d-flex">
                        <a href="{{ route('vehicles.create') }}" class="btn btn-primary mr-2">
                            Crear Vehículo <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h5>Resumen de Estadísticas</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Vehículos en Depósito
                    <span class="badge badge-primary badge-pill">{{ $vehiclesInDeposit }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Vehículos Liberados
                    <span class="badge badge-success badge-pill">{{ $vehiclesReleased }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Vehículos en Revisión
                    <span class="badge badge-warning badge-pill">{{ $vehiclesInReview }}</span>
                </li>
            </ul>
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
