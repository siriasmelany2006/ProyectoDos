@extends('layouts.admin')

@section('titulo', 'Mis productos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mis productos</h1>
    <a href="{{ route('tienda.productos.crear') }}" class="btn btn-dark">
        <i class="fas fa-plus"></i> Nuevo producto
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">

        {{-- Buscador --}}
        <form method="GET" action="{{ route('tienda.productos.index') }}" class="form-inline mb-3">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control mr-2" placeholder="Buscar por nombre">
            <button type="submit" class="btn btn-outline-dark mr-2"><i class="fas fa-search"></i> Buscar</button>
            @if (request('q'))
                <a href="{{ route('tienda.productos.index') }}" class="btn btn-link">Limpiar</a>
            @endif
        </form>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categorías</th>
                    <th>Estado</th>
                    <th style="width: 200px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $p)
                <tr>
                    <td>{{ $p->id_producto }}</td>
                    <td><img src="{{ $p->imagen_url }}" alt="{{ $p->nombre }}" style="width: 60px; height: 45px; object-fit: cover;"></td>
                    <td>{{ $p->nombre }}</td>
                    <td>₡{{ number_format($p->precio, 0, ',', '.') }}</td>
                    <td>
                        @foreach ($p->categorias as $c)
                            <span class="badge badge-secondary">{{ $c->nombre }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if ($p->activo)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tienda.productos.editar', $p->id_producto) }}" class="btn btn-sm btn-dark">
                            <i class="fas fa-pen"></i> Editar
                        </a>

                        {{-- Activar o desactivar (solo cambia el estado, no se borra) --}}
                        <form action="{{ route('tienda.productos.activo', $p->id_producto) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if ($p->activo)
                                <button type="submit" class="btn btn-sm btn-danger">Desactivar</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-success">Activar</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Todavía no tienes productos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $productos->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection