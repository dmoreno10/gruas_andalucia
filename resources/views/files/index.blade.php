@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Archivos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla para DataTables -->
    <table id="files-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre del Archivo</th>
                <th>Tipo</th>
                <th>Tamaño</th>
                <th>Subido por</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables llenará automáticamente el contenido -->
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#files-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('files.data') }}',  // Ruta para obtener los datos vía AJAX
            columns: [
                { data: 'file_name', name: 'file_name' },
                { data: 'mime_type', name: 'mime_type' },
                { data: 'file_size', name: 'file_size' },
                { data: 'user.name', name: 'user.name' },  // Relación con el nombre del usuario
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]

