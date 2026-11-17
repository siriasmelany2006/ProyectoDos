<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('titulo') | CrickoStore</title>

    {{-- Plantilla del sitio público (archivos en public/theme-web) --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('theme-web/assets/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('theme-web/css/styles.css') }}" rel="stylesheet">
    @yield('estilos')
</head>
<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0">
        {{-- Menú superior --}}
        @include('partials.web.header')

        {{-- Aquí entra el contenido de cada página --}}
        @yield('contenido')
    </main>

    {{-- Pie de página --}}
    @include('partials.web.footer')

    {{-- jQuery, Bootstrap y el script de la plantilla --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme-web/js/scripts.js') }}"></script>

    {{-- Scripts propios de cada página --}}
    @yield('scripts')
</body>
</html>