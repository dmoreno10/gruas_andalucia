@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Listado de Reservas</h1>

    <div class="col-md-12">
        <p class="text-muted">Reservas registradas</p>
        <hr>

        <div class="row">
            <div class="card card-outline shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manejo de Reservas</h5>
                    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                        Crear Reserva
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'reservations-table']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
