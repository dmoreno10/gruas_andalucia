@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h1 class="mb-4 text-center">{{__('messages.user_list')}}</h1>

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

<user-crud></user-crud>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}


@endpush
