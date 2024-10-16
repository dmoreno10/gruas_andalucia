@extends('layouts.app')

@section('content')
    <h1>Accesos de los usuarios</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Logs de acceso registrados</h3>
                    </div>

                    <div class="card-body">
                        <!-- DataTable para mostrar los logs -->
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
