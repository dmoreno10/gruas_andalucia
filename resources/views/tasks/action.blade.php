<!-- resources/views/users/action.blade.php -->
<div class="d-flex align-items-center">
    <a href="{{ route('tasks.start', $model->id) }}" class="btn btn-sm btn-primary me-2 btn-start">
        <i class="fas fa-play"></i> Empezar
    </a>

    <button type="button" class="btn btn-sm btn-danger me-2 btn-delete" data-id="{{ $model->id }}" @click="openDeleteModal({{ $model->id }})">
        <i class="fas fa-trash-alt"></i> Anular
    </button>


    <a href="{{ route('user.download_profile_pdf', $model->id) }}" class="btn btn-sm btn-success">
        <i class="fas fa-file-pdf"></i> Completar
    </a>
</div>
