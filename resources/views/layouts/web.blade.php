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

        {{-- Mensajes (éxito, error y errores de validación) --}}
        <div class="container px-5 pt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mb-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

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
