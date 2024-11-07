@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="card mb-4">
        <div class="card-header">
            <h2>Perfil de Usuario</h2>
        </div>
        <div class="card-body">
            <!-- Botón para volver a la página anterior -->
            <div class="mb-3">
                <a href="javascript:history.back()">
                    <i style="color:black" class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="row">
                <div class="col-md-4 text-center">
                    <!-- Componente Vue para cambiar la imagen -->
                    <profile-image-modal :profile-image="{{ json_encode(asset('storage/' . $user->profile_image)) }}"></profile-image-modal>
                    <h4 class="mt-3">{{ $user->name }}</h4>
                    <p id="user" class="user_email text-muted">{{ $user->email }}</p>
                </div>
                <div class="col-md-8">
                    <h5>Información Adicional</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Fecha de Registro:</strong> {{ $user->created_at->format('d-m-Y') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Última Actividad:</strong>
                            {{ $lastLoginLog ? $lastLoginLog->created_at->format('d-m-Y H:i') : 'Nunca' }}
                        </li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
