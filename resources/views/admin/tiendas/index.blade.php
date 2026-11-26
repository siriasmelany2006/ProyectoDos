@extends('layouts.admin')

@section('titulo', 'Tiendas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Todas las tiendas</h1>

    {{-- Buscador de tiendas por nombre --}}
    <form action="{{ route('admin.tiendas.index') }}" method="GET" class="w-25">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar tiendas...">
    </form>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Activa</th>
                    <th>Destacada</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tiendas as $t)
                <tr>
                    <td>{{ $t->id_tienda }}</td>
                    <td style="width: 70px;">
                        @if ($t->logo)
                            <img src="{{ $t->logo_url }}" alt="Logo" class="rounded" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.style.display='none'">
                        @else
                            <i class="fas fa-store fa-2x text-gray-500"></i>
                        @endif
                    </td>
                    <td>{{ $t->nombre }}</td>
                    <td>WhatsApp: {{ $t->whatsapp ?: 'No indicado' }}</td>
                    <td>
                        {{-- Interruptor activa / inactiva: al moverlo se envía el formulario --}}
                        <form action="{{ route('admin.tiendas.activa', $t->id_tienda) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="valor" value="{{ $t->activa ? 0 : 1 }}">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input switch-auto" id="activa{{ $t->id_tienda }}" {{ $t->activa ? 'checked' : '' }}>
                                <label class="custom-control-label" for="activa{{ $t->id_tienda }}">{{ $t->activa ? 'Activa' : 'Oculta' }}</label>
                            </div>
                        </form>
                    </td>
                    <td>
                        {{-- Interruptor destacada (slider del inicio) --}}
                        <form action="{{ route('admin.tiendas.destacada', $t->id_tienda) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="valor" value="{{ $t->destacada ? 0 : 1 }}">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input switch-auto" id="destacada{{ $t->id_tienda }}" {{ $t->destacada ? 'checked' : '' }}>
                                <label class="custom-control-label" for="destacada{{ $t->id_tienda }}"></label>
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No se encontraron tiendas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $tiendas->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Al mover un interruptor se envía su formulario
    $('.switch-auto').on('change', function () {
        $(this).closest('form').submit();
    });
</script>
@endsection