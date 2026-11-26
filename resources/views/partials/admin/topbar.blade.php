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

        {{-- Usuario que inició sesión --}}
        <li class="nav-item d-flex align-items-center">
            @if (auth()->user()->foto)
                <img src="{{ auth()->user()->foto }}" alt="" class="rounded-circle mr-2" style="width: 32px; height: 32px;" referrerpolicy="no-referrer">
            @endif
            <span class="text-gray-600 small">{{ auth()->user()->nombre }}</span>
        </li>
    </ul>
</nav>