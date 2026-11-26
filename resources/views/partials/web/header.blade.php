<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">

        <a class="navbar-brand" href="{{ route('home') }}">CrickoStore</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            {{-- Menú: Inicio, Productos y Tiendas (la clase active marca la página actual) --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tiendas.*') ? 'active' : '' }}" href="{{ route('tiendas.index') }}">Tiendas</a>
                </li>
            </ul>

            {{-- Buscador: busca en productos (por nombre de producto o de tienda) --}}
            <form class="d-flex me-3" action="{{ route('productos.index') }}" method="GET">
                <input class="form-control form-control-sm" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar productos, tiendas...">
            </form>

            {{-- Carrito: el número sale de la sesión --}}
            @php $cantidadCarrito = \App\Services\CarritoService::cantidad(); @endphp
            <a class="btn btn-outline-light btn-sm me-3" href="{{ route('carrito') }}">
                <i class="bi bi-cart"></i> <span class="badge bg-light text-dark">{{ $cantidadCarrito }}</span>
            </a>

            {{-- Sesión: si hay usuario muestra su panel y cerrar sesión; si no, iniciar sesión --}}
            @auth
                <a class="btn btn-outline-light btn-sm me-2" href="{{ auth()->user()->esAdmin() ? route('admin.pedidos.index') : route('tienda.mi-tienda') }}">
                    {{ auth()->user()->esAdmin() ? 'Panel admin' : 'Mi tienda' }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                </form>
            @else
                <a class="btn btn-light btn-sm" href="{{ route('login') }}">Iniciar sesión</a>
            @endauth
        </div>
    </div>
</nav>