<!-- resources/views/users/action.blade.php -->
<div class="d-flex align-items-center">
    <button class="btn btn-sm btn-info me-2 btn-edit" data-id="{{ $model->id }}">
        <i class="fas fa-edit"></i> Editar
    </button>

    <form action="{{ url('/users/' . $model->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-delete ms-2" data-id="{{ $model->id }}">
            <i class="fas fa-trash-alt"></i> Borrar
        </button>
    </form>

    <a href="{{ route('user.download_profile_pdf', $model->id) }}" class="btn btn-sm btn-success">
        <i class="fas fa-file-pdf"></i> Descargar PDF
    </a>
</div>
