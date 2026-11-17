    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Botón del menú en pantallas pequeñas --}}
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Título según el panel donde estemos --}}
    <span class="h5 mb-0 text-gray-800">
        {{ request()->is('admin*') ? 'Panel del Administrador' : 'Panel de la Tienda' }}
    </span>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                <i class="fas fa-external-link-alt fa-sm mr-1"></i> Ver sitio
            </a>
        </li>
    </ul>
</nav>