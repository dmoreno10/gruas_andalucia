@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Listado de Incidencias</h1>

        <div class="d-flex align-items-center  mb-3">
            <a href="javascript:history.back()" class="me-2">
                <i style="color: black;" class="fas fa-arrow-left"></i>
            </a>
            <p class="mb-0">Atrás</p>
        </div>

        <div class="col-md-12">
            
            <hr>

            <div class="row">
                <div class="card card-outline shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manejo de Incidencias</h5>
                        <!-- Usamos un id en vez de @click -->
                        <button class="btn btn-primary" id="create-incident-btn">
                            Crear Incidencia
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'incidents-table']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <incident-crud></incident-crud>
    </div>
@endsection

@push('scripts')
    <div class="col-12 table-responsive">
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    </div>
@endpush
