@vite([
    'resources/dist/js/core/jquery-3.7.1.min.js', // jQuery (debe ser primero)
    'resources/dist/js/plugin/jquery.sparkline/jquery.sparkline.min.js', // Plugin Sparkline (debe ser después de jQuery)
    'resources/dist/js/core/popper.min.js', // Popper
    'resources/dist/js/core/bootstrap.min.js', // Bootstrap
    'resources/dist/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js', // jQuery Scrollbar
    'resources/dist/js/plugin/chart.js/chart.min.js', // Chart.js
    'resources/dist/js/plugin/chart-circle/circles.min.js', // Chart Circle
    'resources/dist/js/plugin/datatables/datatables.min.js', // DataTables
    'resources/dist/js/plugin/bootstrap-notify/bootstrap-notify.min.js', // Bootstrap Notify
    'resources/dist/js/plugin/jsvectormap/jsvectormap.min.js', // JS Vector Map
    'resources/dist/js/plugin/jsvectormap/world.js', // World Map
    'resources/dist/js/plugin/sweetalert/sweetalert.min.js', // SweetAlert
    'resources/dist/js/kaiadmin.min.js', // Kai Admin
    'resources/dist/js/setting-demo.js', // Setting Demo
    'resources/dist/js/demo.js', // Demo
    'resources/vue/app.js'
])

<script>
    $(document).ready(function() {
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    });
</script>
 @stack('scripts')
