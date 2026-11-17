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

            {{-- Buscador (por ahora solo lleva a la lista de productos) --}}
            <form class="d-flex me-3" action="{{ route('productos.index') }}" method="GET">
                <input class="form-control form-control-sm" type="search" name="q" placeholder="Buscar productos, tiendas...">
            </form>

            {{-- Carrito (el 3 es de ejemplo) --}}
            <a class="btn btn-outline-light btn-sm me-3" href="{{ route('carrito') }}">
                <i class="bi bi-cart"></i> <span class="badge bg-light text-dark">3</span>
            </a>

            {{-- Accesos directos a los paneles (temporales, mientras no hay login) --}}
            <a class="btn btn-outline-light btn-sm me-2" href="{{ route('admin.pedidos.index') }}">Admin</a>
            <a class="btn btn-outline-light btn-sm" href="{{ route('tienda.mi-tienda') }}">Mi tienda</a>
        </div>
    </div>
</nav>