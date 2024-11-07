@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Gestión Documental</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('documents-gest.create') }}" class="btn btn-primary">
            Añadir Documento
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0">Documentos Registrados</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-bordered']) !!}
            </div>
        </div>
    </div>
</div>

<document-crud></document-crud>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
