<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('titulo') | CrickoStore</title>

    {{-- Plantilla SB Admin 2 (archivos en public/theme-admin) --}}
    <link href="{{ asset('theme-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <link href="{{ asset('theme-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">

    <div id="wrapper">

        {{-- Menú lateral: si la ruta empieza con /admin usa el del administrador, si no, el de la tienda --}}
        @if (request()->is('admin*'))
            @include('partials.admin.sidebar_admin')
        @else
            @include('partials.admin.sidebar_tienda')
        @endif

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                {{-- Barra superior --}}
                @include('partials.admin.topbar')

                {{-- Aquí entra el contenido de cada página --}}
                <div class="container-fluid">
                    @yield('contenido')
                </div>
            </div>

            {{-- Pie de página --}}
            @include('partials.admin.footer')
        </div>
    </div>

    <script src="{{ asset('theme-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('theme-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('theme-admin/js/sb-admin-2.min.js') }}"></script>

    {{-- Scripts propios de cada página --}}
    @yield('scripts')
</body>
</html>