@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="d-flex justify-content-center" >Trabajadores</h1>
    <div class="d-flex align-items-center  mb-3">
        <a href="javascript:history.back()" class="me-2">
            <i style="color: black;" class="fas fa-arrow-left"></i>
        </a>
        <p class="mb-0">Atrás</p>
    </div>
    <div class="card-header">
        <div  class="card-tools d-flex justify-content-start">
            <!-- Usamos un id en vez de @click -->
            <button class="btn btn-primary" id="create-employee-btn">
                Crear Trabajadores
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="col-12 table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'employees-table']) }}
            </div>
        </div>
    </div>

    <employee-crud></employee-crud>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
