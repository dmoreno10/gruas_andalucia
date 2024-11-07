@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="points">Points</label>
            <input type="number" name="points" id="points" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="employee_id">Employee</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option disabled selected value="">Select an employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>
@endsection
