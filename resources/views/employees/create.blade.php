@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>{{ __('Creación de Empleados') }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="post">
                        @csrf

                        <!-- Nombre del Empleado -->
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre del Empleado') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Electrónico') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Cargo -->
                        <div class="mb-3 row">
                            <label for="position" class="col-md-4 col-form-label text-md-end">{{ __('Cargo') }}</label>
                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required>
                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado del Empleado -->
                        <div class="mb-3 row">
                            <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Estado del Empleado') }}</label>
                            <div class="col-md-6">
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Departamento -->
                        <div class="mb-3 row">
                            <label for="department" class="col-md-4 col-form-label text-md-end">{{ __('Departamento') }}</label>
                            <div class="col-md-6">
                                <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" value="{{ old('department') }}" required>
                                @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <a href="{{ url('employees') }}" class="btn btn-secondary me-2">
                                    {{ __('Cancelar') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
