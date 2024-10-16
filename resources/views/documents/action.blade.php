<!-- resources/views/users/action.blade.php -->
<div class="d-flex">
    {{-- <a href="{{ url('/users/' . $model->id . '/edit/') }}" class="btn btn-sm btn-info" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </a> --}}
    <button  class="btn btn-sm btn-info btn-edit" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </button>

    <form action="{{ route('incidents.destroy', $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-delete ms-2" data-id="{{ $model->id }}">
            <i class="fas fa-trash-alt"></i> Borrar
        </button>
    </form>
</div>

