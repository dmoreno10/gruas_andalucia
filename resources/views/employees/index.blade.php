@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trabajadores</h1>
    <div class="card-header">
        <div class="card-tools">
            <a href="{{route('employees.create')}}" class="btn btn-primary">
                Crear Trabajadores
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">Manejo de Trabajadores</div>
            <div class="card-body">
                    {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'employees-table'])}}
            </div>
        </div>
    </div>
    <employee-crud></employee-crud>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
