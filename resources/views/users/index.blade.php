@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">{{ __('messages.user_list') }}</h1>

        <!-- Botón para crear un nuevo usuario -->
        <div class="card-header d-flex justify-content-between">
            <!-- Aquí agregamos el botón con un id para la creación de usuario -->
            <button id="create-user-btn" class="btn btn-primary">
                Crear Usuario
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div id="app" class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Usuarios Registrados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'users-table']) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Componente Vue para CRUD de usuarios -->
    <user-crud></user-crud>
@endsection

@push('scripts')
    <div class="col-12 table-responsive">
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    </div>
@endpush
