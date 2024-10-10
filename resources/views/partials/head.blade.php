<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ env('APP_NAME') }}</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />

    <link
      rel="icon"
      href="{{ Vite::asset('resources/dist/img/kaiadmin/favicon.ico') }}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <!-- v--- Forma de poner un enlace  -->
    @vite(['resources\dist\js\plugin\webfont\webfont.min.js'])
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["dist/css/fonts.min.css"],
        },
        active: function () {
           sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    @vite([
        'resources/dist/css/bootstrap.min.css',
        'resources/dist/css/plugins.min.css',
        'resources/dist/css/kaiadmin.min.css',
        'resources/dist/css/demo.css',
    ])
  </head>
