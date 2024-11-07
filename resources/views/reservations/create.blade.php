@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>{{ __('Crear Nueva Reserva') }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="client_name" class="form-label">{{ __('Nombre del Cliente') }}</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name') }}" required autofocus>
                            @error('client_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="reservation_date" class="form-label">{{ __('Fecha de Reserva') }}</label>
                            <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservation_date" name="reservation_date" value="{{ old('reservation_date') }}" required>
                            @error('reservation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">{{ __('Estado de la Reserva') }}</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="confirmada" {{ old('status') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="pendiente" {{ old('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelada" {{ old('status') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary" style="margin-right: 10px;">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
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

<style scoped>
    .card {
        border-radius: 10px;
    }

    .card-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
