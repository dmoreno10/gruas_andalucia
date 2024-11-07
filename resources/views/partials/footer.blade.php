<!--   Core JS Files   -->
<script src="{{ url('/dist/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ url('/dist/js/core/popper.min.js') }}"></script>
<script src="{{ url('/dist/js/core/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Handle delete button click
        $('.btn-delete').on('click', function() {
            var form = $(this).closest('form'); // Get the form associated with the delete button
            var userId = $(this).data('id'); // Get user ID from data attribute
            console.log('ok');

            // Display the SweetAlert confirmation dialog
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás recuperar esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>

<!--   Core JS Files   -->
<script src="{{ url('/dist/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ url('/dist/js/core/popper.min.js') }}"></script>
<script src="{{ url('/dist/js/core/bootstrap.min.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ url('/dist/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ url('/dist/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ url('/dist/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ url('/dist/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ url('/dist/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ url('/dist/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ url('/dist/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ url('/dist/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ url('/dist/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Kaiadmin JS -->
<script src="{{ url('/dist/js/kaiadmin.min.js') }}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ url('/dist/js/setting-demo.js') }}"></script>

<script src="{{ url('/dist/js/demo.js') }}"></script>

@vite([
    'resources/vue/app.js'
])

@stack('scripts')
