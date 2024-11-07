<div class="d-flex">
    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </button>

    <form action="{{ route('employees.destroy', $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <!-- Cambia el tipo a "submit" para enviar el formulario -->
        <button type="submit" class="btn btn-sm btn-danger btn-delete ms-2" data-id="{{ $model->id }}">
            <i class="fas fa-trash-alt"></i> Borrar
        </button>
    </form>

    <form action="{{ route('employees.download-profile-pdf', $model->id) }}" method="GET" style="display: inline;">
        <button type="submit" class="btn btn-sm btn-primary ms-2">
            <i class="fas fa-download"></i> Descargar
        </button>
    </form>

</div>
