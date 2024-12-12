<!-- resources/views/companies/action.blade.php -->
<div class="d-flex align-items-center">
    <!-- Botón para editar empresa -->
    <button class="btn btn-sm btn-info me-2 btn-edit" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </button>

    <!-- Botón para eliminar empresa -->
    <form action="{{ route('companies.destroy', $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger me-2" onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">
            <i class="fas fa-trash-alt"></i> Eliminar
        </button>
    </form>
</div>
