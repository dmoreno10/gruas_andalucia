<div class="d-flex">
    <!-- Botón para editar una incidencia -->
    <button class="btn btn-sm btn-info btn-edit" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </button>

    <form action="{{ route('incidents.destroy', $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <!-- Botón para borrar la incidencia -->
        <button type="button" class="btn btn-sm btn-danger btn-delete ms-2" data-id="{{ $model->id }}">
            <i class="fas fa-trash-alt"></i> Borrar
        </button>
    </form>
</div>
