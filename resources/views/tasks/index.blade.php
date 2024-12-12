@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('messages.tasks') }}</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-12 table-responsive">
        {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'tasks-table']) }}
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
