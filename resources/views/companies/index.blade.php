@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center  mb-3">
        <a href="javascript:history.back()" class="me-2">
            <i style="color: black;" class="fas fa-arrow-left"></i>
        </a>
        <p class="mb-0">Atrás</p>
    </div>
    <div class="card card-outline shadow">
    <h1 class="mb-4 text-center">Lista de Empresas</h1>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manejo de empresas</h5>
    <button id="create-company-btn" class="btn btn-primary">
        Crear Empresa
        <i class="fa fa-plus"></i>
    </button>
    </div>

    <div class="card-body">
        <div class="col-12 table-responsive">
            {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'companies-table']) }}
        </div>
    </div>

    <company-crud></company-crud>
</div>

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
@endsection
