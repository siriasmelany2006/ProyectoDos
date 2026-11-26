@extends('layouts.admin')

@section('titulo', 'Mis pedidos')

@section('contenido')
@php
    // Color de la etiqueta según el estado del pedido
    $colores = ['En preparación' => 'warning', 'Listo' => 'info', 'Entregado' => 'success'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800">Mis pedidos</h1>
        <p class="text-muted mb-0">Aquí se muestran los pedidos que contienen productos de tu tienda.</p>
    </div>

    {{-- Buscador: por cliente, correo o número de pedido --}}
    <form action="{{ route('tienda.pedidos.index') }}" method="GET" class="w-25">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar pedidos...">
    </form>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Mi total</th>
                    <th>Mis productos</th>
                    <th>Estado del pedido</th>
                    <th>Fecha</th>
                    <th style="width: 90px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pedidos as $p)
                <tr>
                    <td>#{{ $p->id_pedido }}</td>
                    <td>{{ $p->cliente }}</td>
                    <td>{{ $p->correo }}</td>
                    <td>₡{{ number_format($p->mi_total, 0, ',', '.') }}</td>
                    <td>
                        @if ($p->mis_pendientes > 0)
                            <span class="badge badge-secondary">{{ $p->mis_pendientes }} en espera</span>
                        @else
                            <span class="badge badge-success">Todos listos</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $colores[$p->estado] ?? 'secondary' }}">{{ $p->estado }}</span></td>
                    <td>{{ $p->fecha->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('tienda.pedidos.show', $p->id_pedido) }}" class="btn btn-sm btn-dark">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Todavía no hay pedidos con productos de tu tienda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $pedidos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection