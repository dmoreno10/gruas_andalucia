<div class="d-flex">
    <button class="btn btn-sm btn-info btn-edit"  data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </button>

    <form action="{{ route('municipal-deposit.destroy', $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <!-- Cambia el tipo a "submit" para enviar el formulario -->
        <button type="button" class="btn btn-sm btn-danger btn-delete ms-2" data-id="{{ $model->id }}">
            <i class="fas fa-trash-alt"></i> Borrar
        </button>
    </form>

</div>
