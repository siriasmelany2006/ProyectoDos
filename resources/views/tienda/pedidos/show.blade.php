@extends('layouts.admin')

@section('titulo', 'Detalle del pedido')

@section('contenido')
@php
    $coloresPedido = ['En preparación' => 'warning', 'Listo' => 'info', 'Entregado' => 'success'];
    $coloresLinea  = ['En espera' => 'secondary', 'Listo' => 'success'];
    $entregado = $pedido->estado === 'Entregado';
@endphp

<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tienda.pedidos.index') }}">Mis pedidos</a></li>
        <li class="breadcrumb-item active">#{{ $pedido->id_pedido }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Pedido #{{ $pedido->id_pedido }}
        <span class="badge badge-{{ $coloresPedido[$pedido->estado] ?? 'secondary' }}">{{ $pedido->estado }}</span>
    </h1>
    <span>Fecha: {{ $pedido->fecha->format('d/m/Y H:i') }}</span>
</div>

<div class="row">

    {{-- Información del cliente --}}
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Información del cliente</h6>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $pedido->cliente }}</p>
                <p><strong>Correo:</strong> {{ $pedido->correo }}</p>
                <p class="mb-0"><strong>Teléfono:</strong> {{ $pedido->telefono ?: 'No indicado' }}</p>
            </div>
        </div>
    </div>

    {{-- Solo los productos de mi tienda dentro del pedido --}}
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Productos del pedido (solo los de mi tienda)</h6>
            </div>
            <div class="card-body">

                @if ($entregado)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Este pedido ya fue entregado y no se puede modificar.
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($misDetalles as $d)
                        <tr>
                            <td>{{ $d->nombre_producto }}</td>
                            <td>₡{{ number_format($d->precio, 0, ',', '.') }}</td>
                            <td>{{ $d->cantidad }}</td>
                            <td>₡{{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            <td><span class="badge badge-{{ $coloresLinea[$d->estado] ?? 'secondary' }}">{{ $d->estado }}</span></td>
                            <td>
                                @if ($d->estado === 'Listo' || $entregado)
                                    {{-- Ya está listo o el pedido fue entregado: botón deshabilitado --}}
                                    <button class="btn btn-sm btn-secondary" disabled>Marcar como listo</button>
                                @else
                                    <form action="{{ route('tienda.pedidos.listo', $d->id_detalle) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-dark">
                                            <i class="fas fa-check"></i> Marcar como listo
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="text-right h5 mb-0">Total de mis productos: ₡{{ number_format($miTotal, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection