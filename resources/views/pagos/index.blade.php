@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Gestión de Pagos</h1>

    <div class="card shadow">
        <div class="card-header">
            <h3 class="mb-0">Lista de Pagos Registrados</h3>
            <button class="btn btn-primary float-right" id="createNewPago" data-toggle="modal" data-target="#pagoModal">Agregar Pago</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <!-- DataTable para mostrar los pagos -->
                <table id="pagosTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar pagos -->
    <div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pagoModalLabel">Agregar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pagoForm">
                        @csrf
                        <input type="hidden" name="id" id="pagoId">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="savePago">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar DataTable
        let table = $('#pagosTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pagos.data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'descripcion', name: 'descripcion'},
                {data: 'monto', name: 'monto'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Mostrar el modal para crear un nuevo pago
        $('#createNewPago').click(function() {
            $('#pagoForm')[0].reset(); // Resetear el formulario
            $('#pagoId').val(''); // Limpiar el id
            $('#pagoModalLabel').text('Agregar Pago'); // Cambiar el título del modal
            $('#pagoModal').modal('show'); // Mostrar el modal
        });

        // Guardar nuevo pago o editar
        $('#pagoForm').on('submit', function(e) {
            e.preventDefault(); // Prevenir el envío normal del formulario

            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('pagos.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#pagoModal').modal('hide'); // Ocultar el modal
                    table.ajax.reload(); // Recargar la tabla
                    alert('Pago guardado correctamente.'); // Mensaje de éxito
                },
                error: function(data) {
                    alert('Error al guardar el pago.'); // Mensaje de error
                }
            });
        });

        // Funcionalidad para editar y eliminar pagos puede ir aquí
    });
</script>
@endpush
