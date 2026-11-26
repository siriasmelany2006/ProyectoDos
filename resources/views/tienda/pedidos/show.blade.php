@extends('layouts.admin')

@section('titulo', 'Detalle del pedido')

@section('contenido')
@php
// datos quemados
$productos = [
['nombre' => 'Producto A', 'precio' => '₡25.000', 'cantidad' => 1, 'subtotal' => '₡25.000', 'estado' => 'Listo'],
['nombre' => 'Producto C', 'precio' => '₡20.000', 'cantidad' => 1, 'subtotal' => '₡20.000', 'estado' => 'En espera'],
];
@endphp

<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tienda.pedidos.index') }}">Mis pedidos</a></li>
        <li class="breadcrumb-item active">#105</li>
    </ol>
</nav>

<h1 class="h3 mb-4 text-gray-800">Pedido #105 <span class="badge badge-warning">En preparación</span></h1>

<div class="row">

    {{-- Información del cliente --}}
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Información del cliente</h6>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> María López</p>
                <p><strong>Correo:</strong> maria@mail.com</p>
                <p><strong>Teléfono:</strong> 8888-8888</p>
                <p class="mb-0"><strong>Fecha:</strong> 27/10/2026 14:35</p>
            </div>
        </div>
    </div>

    {{-- Productos de la tienda dentro del pedido --}}
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Productos del pedido (solo los de mi tienda)</h6>
            </div>
            <div class="card-body">
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
                        @foreach ($productos as $p)
                        <tr>
                            <td>{{ $p['nombre'] }}</td>
                            <td>{{ $p['precio'] }}</td>
                            <td>{{ $p['cantidad'] }}</td>
                            <td>{{ $p['subtotal'] }}</td>
                            <td>
                                <span class="badge badge-{{ $p['estado'] == 'Listo' ? 'info' : 'secondary' }}">{{ $p['estado'] }}</span>
                            </td>
                            <td>
                                @if ($p['estado'] == 'Listo')
                                {{-- Ya está listo: botón deshabilitado --}}
                                <button class="btn btn-sm btn-secondary" disabled>Marcar como listo</button>
                                @else
                                {{-- Por ahora recarga el detalle --}}
                                <a href="{{ route('tienda.pedidos.show', 105) }}" class="btn btn-sm btn-dark">
                                    <i class="fas fa-check"></i> Marcar como listo
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection