<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('tienda.mi-tienda') }}">
        <div class="sidebar-brand-icon"><i class="fas fa-store"></i></div>
        <div class="sidebar-brand-text mx-3">CrickoStore <small>Tienda</small></div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Menú: Mi tienda, Mis productos y Mis pedidos --}}
    <li class="nav-item {{ request()->is('tienda/mi-tienda*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tienda.mi-tienda') }}">
            <i class="fas fa-fw fa-home"></i><span>Mi tienda</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('tienda/productos*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tienda.productos.index') }}">
            <i class="fas fa-fw fa-tags"></i><span>Mis productos</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('tienda/pedidos*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tienda.pedidos.index') }}">
            <i class="fas fa-fw fa-box"></i><span>Mis pedidos</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Cerrar sesión (por ahora solo vuelve al inicio) --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-sign-out-alt"></i><span>Cerrar sesión</span>
        </a>
    </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>