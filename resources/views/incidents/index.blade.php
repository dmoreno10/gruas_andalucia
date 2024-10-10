{{-- @extends('layouts.app')

@section('content')
   <h1>Listado de incidencias</h1>
   <div class="col-md-12">
    Incidencias registradss
    <hr>
        <div class="row card card-outline ">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{url('/users/create')}}" class="btn btn-primary">
                        Crear Incidencia
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>

            <div class="container">
                <div class="card">
                    <div class="card-header">Manejo de incidencias</div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

 --}}
