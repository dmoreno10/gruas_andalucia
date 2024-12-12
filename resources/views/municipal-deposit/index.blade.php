@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex align-items-center  mb-3">
            <a href="javascript:history.back()" class="me-2">
                <i style="color: black;" class="fas fa-arrow-left"></i>
            </a>
            <p class="mb-0">Atrás</p>
        </div>
        <h1 class="mb-4 text-center">{{ __('messages.deposit_list') }}</h1>
        <button id="create-company-btn" class="btn btn-primary mb-3">
            Crear Deposito Municipal
            <i class="fa fa-plus"></i>
        </button>
        <div id="app" class="card shadow">
            
            <div class="card-header">
                <h5 class="mb-0">Depositos Municipales</h5>
            </div>

            <div class="card-body">
                <div class="col-12 table-responsive">
                    {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'municipal_deposit-table']) }}
                </div>
            </div>
        </div>
        <deposit-crud></deposit-crud>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
