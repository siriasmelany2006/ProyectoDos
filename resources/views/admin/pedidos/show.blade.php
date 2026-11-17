@extends('layouts.admin')

@section('titulo', 'Detalle del pedido')

@section('contenido')
@php
    // Productos de ejemplo del pedido (quemados)
    $productos = [
        ['nombre' => 'Producto A', 'tienda' => 'Tienda Verde', 'precio' => '₡25.000', 'cantidad' => 1, 'subtotal' => '₡25.000', 'estado' => 'Listo'],
        ['nombre' => 'Producto B', 'tienda' => 'Mundo Tech', 'precio' => '₡30.000', 'cantidad' => 2, 'subtotal' => '₡60.000', 'estado' => 'Listo'],
        ['nombre' => 'Producto C', 'tienda' => 'Hogar y Estilo', 'precio' => '₡20.000', 'cantidad' => 1, 'subtotal' => '₡20.000', 'estado' => 'Listo'],
    ];
@endphp

<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.pedidos.index') }}">Pedidos</a></li>
        <li class="breadcrumb-item active">#105</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Pedido #105 <span class="badge badge-warning">En preparación</span>
    </h1>
    <span>Fecha: 27/10/2026 14:35</span>
</div>

<div class="row">

    {{-- Información del cliente --}}
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Información del cliente</h6></div>
            <div class="card-body">
                <p><strong>Nombre:</strong> María López</p>
                <p><strong>Correo:</strong> maria@mail.com</p>
                <p><strong>Teléfono:</strong> 8888-8888</p>
                <p class="mb-0"><strong>Total:</strong> ₡105.000</p>
            </div>
        </div>
    </div>

    {{-- Productos del pedido --}}
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
                        @foreach ($productos as $p)
                        <tr>
                            <td>{{ $p['nombre'] }}</td>
                            <td>{{ $p['tienda'] }}</td>
                            <td>{{ $p['precio'] }}</td>
                            <td>{{ $p['cantidad'] }}</td>
                            <td>{{ $p['subtotal'] }}</td>
                            <td><span class="badge badge-info">{{ $p['estado'] }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-right h5 mb-0">Total del pedido: ₡105.000</p>
            </div>
        </div>
    </div>
</div>

{{-- Confirmar entrega: después solo se mostrará si todos los productos están listos --}}
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Confirmar entrega del pedido</h6></div>
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <p class="mb-1"><strong>Este pedido está listo para entregar</strong></p>
            <small class="text-muted">Al confirmar la entrega, el pedido pasará al estado Entregado y ya no se podrá modificar.</small>
        </div>
        {{-- Por ahora vuelve a la lista de pedidos --}}
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-dark">
            <i class="fas fa-check"></i> Confirmar entrega
        </a>
    </div>
</div>
@endsection