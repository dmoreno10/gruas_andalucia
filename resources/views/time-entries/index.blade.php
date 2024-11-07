@extends('layouts.app')
@section('content')
<entries-crud></entries-crud>
<div  class="container">
    <h1>Entradas de Tiempo</h1>
    {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'entries-table']) }}
</div>

@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
