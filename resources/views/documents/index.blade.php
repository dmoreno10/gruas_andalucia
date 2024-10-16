@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión Documental</h1>
    <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3">Añadir Documento</a>

    {!! $dataTable->table(['class' => 'table table-bordered']) !!}
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
