@extends('layouts.admin')

@section('titulo', 'Pedidos')

@section('contenido')
@php
    // Color de la etiqueta según el estado
    $colores = ['En preparación' => 'warning', 'Listo' => 'info', 'Entregado' => 'success'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pedidos</h1>

    {{-- Buscador: por cliente, correo o número de pedido --}}
    <form action="{{ route('admin.pedidos.index') }}" method="GET" class="w-25">
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
                    <th>Total</th>
                    <th>Estado</th>
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
                    <td>₡{{ number_format($p->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $colores[$p->estado] ?? 'secondary' }}">{{ $p->estado }}</span></td>
                    <td>{{ $p->fecha->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.pedidos.show', $p->id_pedido) }}" class="btn btn-sm btn-dark">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No se encontraron pedidos.</td>
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