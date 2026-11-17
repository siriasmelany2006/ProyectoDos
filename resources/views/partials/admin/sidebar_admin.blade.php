<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.pedidos.index') }}">
        <div class="sidebar-brand-icon"><i class="fas fa-store"></i></div>
        <div class="sidebar-brand-text mx-3">CrickoStore <small>Admin</small></div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Menú: Pedidos y Tiendas --}}
    <li class="nav-item {{ request()->is('admin/pedidos*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pedidos.index') }}">
            <i class="fas fa-fw fa-box"></i><span>Pedidos</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('admin/tiendas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.tiendas.index') }}">
            <i class="fas fa-fw fa-store"></i><span>Tiendas</span>
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