@extends('layouts.app')
@section('content')
<div class="d-flex align-items-center  mb-3">
    <a href="javascript:history.back()" class="me-2">
        <i style="color: black;" class="fas fa-arrow-left"></i>
    </a>
    <p class="mb-0">Atrás</p>
</div>

<entries-crud></entries-crud>
<div  class="container">
    
    <h1>Entradas de Tiempo</h1>
    {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'entries-table']) }}
</div>

@endsection

@push('scripts')
<div class="col-12 table-responsive">
{!! $dataTable->scripts() !!}
</div>
@endpush
