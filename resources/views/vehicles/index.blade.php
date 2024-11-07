@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Vehículos</h1>

    <div class="col-md-12">
        <p class="text-muted">Vehículos registrados</p>
        <hr>

        <div class="row">
            <div class="card card-outline shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manejo de Vehículos</h5>
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                        Crear Vehículo
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <vehicle-crud></vehicle-crud> <!-- Componente de Vue para gestionar vehículos -->
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
