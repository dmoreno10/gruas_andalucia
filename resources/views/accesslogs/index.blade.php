@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Accesos de los Usuarios</h1>

    <div class="card shadow">
        <div class="card-header">
            <h3 class="mb-0">Logs de Acceso Registrados</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <!-- DataTable para mostrar los logs -->
                {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
