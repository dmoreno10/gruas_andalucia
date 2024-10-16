@extends('layouts.app')

@section('content')
   <h1>Listado de usuarios</h1>
   <div class="col-md-12">
    Usuarios registrados
    <hr>
        <div class="row card card-outline ">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{route('users.create')}}" class="btn btn-primary">
                        Crear Usuario
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>

            <div class="container">
                <div class="card">
                    <div class="card-header">Manejo de usuarios</div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>

            <user-crud></user-crud>

        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush


