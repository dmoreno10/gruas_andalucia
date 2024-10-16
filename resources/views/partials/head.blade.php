<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ env('APP_NAME') }}</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />

    <link
      rel="icon"
      href="{{ Vite::asset('resources/dist/img/logic-sistemas.png') }}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <!-- v--- Forma de poner un enlace  -->
    <script src="{{ url('/dist/js/plugin\webfont\webfont.min.js') }}"></script>

    @vite([
        'resources\js\fonts.js'
    ])

    <!-- CSS Files -->
    @vite([
        'resources/dist/css/bootstrap.min.css',
        'resources/dist/css/plugins.min.css',
        'resources/dist/css/kaiadmin.min.css',
        'resources/dist/css/demo.css',
    ])

  </head>
