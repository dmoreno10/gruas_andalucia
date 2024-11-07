@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h3>{{ __('Creación de Incidencias') }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('incidents.store') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Título del Incidente') }}</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Descripción del Incidente') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Estado del Incidente') }}</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="" disabled selected>Seleccionar Estado</option>
                                <option value="abierto" {{ old('status') == 'abierto' ? 'selected' : '' }}>Abierto</option>
                                <option value="cerrado" {{ old('status') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                                <option value="en_progreso" {{ old('status') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="created_at" class="form-label">{{ __('Fecha de Creación') }}</label>
                            <input id="created_at" type="date" class="form-control @error('created_at') is-invalid @enderror" name="created_at" value="{{ old('created_at') }}" required>
                            @error('created_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url('incidents') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
