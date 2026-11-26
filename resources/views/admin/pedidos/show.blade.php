@extends('layouts.admin')

@section('titulo', 'Detalle del pedido')

@section('contenido')
@php
    $coloresPedido = ['En preparación' => 'warning', 'Listo' => 'info', 'Entregado' => 'success'];
    $coloresLinea  = ['En espera' => 'secondary', 'Listo' => 'success'];
@endphp

<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.pedidos.index') }}">Pedidos</a></li>
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
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Información del cliente</h6></div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $pedido->cliente }}</p>
                <p><strong>Correo:</strong> {{ $pedido->correo }}</p>
                <p><strong>Teléfono:</strong> {{ $pedido->telefono ?: 'No indicado' }}</p>
                <p class="mb-0"><strong>Total:</strong> ₡{{ number_format($pedido->total, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Productos del pedido (de todas las tiendas) --}}
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Productos del pedido</h6></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Producto</th>
                            <th>Tienda</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedido->detalles as $d)
                        <tr>
                            <td>{{ $d->nombre_producto }}</td>
                            <td>{{ $d->nombre_tienda }}</td>
                            <td>₡{{ number_format($d->precio, 0, ',', '.') }}</td>
                            <td>{{ $d->cantidad }}</td>
                            <td>₡{{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            <td><span class="badge badge-{{ $coloresLinea[$d->estado] ?? 'secondary' }}">{{ $d->estado }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-right h5 mb-0">Total del pedido: ₡{{ number_format($pedido->total, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Confirmar entrega: solo se puede cuando TODOS los productos están en "Listo" --}}
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Confirmar entrega del pedido</h6></div>
    <div class="card-body">
        @if ($pedido->estado === 'Entregado')
            <p class="mb-0 text-success"><i class="fas fa-check-circle"></i> Este pedido ya fue entregado y no se puede modificar.</p>

        @elseif ($todosListos)
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1"><strong>Este pedido está listo para entregar</strong></p>
                    <small class="text-muted">Al confirmar la entrega, el pedido pasará al estado Entregado y ya no se podrá modificar.</small>
                </div>
                <form action="{{ route('admin.pedidos.entregar', $pedido->id_pedido) }}" method="POST"
                      onsubmit="return confirm('¿Confirmar la entrega? Después ya no se podrá modificar.');">
                    @csrf
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-check"></i> Confirmar entrega
                    </button>
                </form>
            </div>

        @else
            <p class="mb-0 text-muted">
                <i class="fas fa-info-circle"></i> La entrega se podrá confirmar cuando todas las tiendas marquen sus productos como Listo.
            </p>
        @endif
    </div>
</div>
@endsection