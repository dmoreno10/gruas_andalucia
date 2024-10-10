<!-- resources/views/users/action.blade.php -->
<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ url('/users/' . $model->id . '/edit/') }}" class="btn btn-sm btn-info btn-edit" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </a>
    <form action="{{ url('/users/' . $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger btn-delete ms-2" data-id="{{ $model->id }}">
            <i class="fas fa-trash-alt"></i> Borrar
        </button>
    </form>
</div>



