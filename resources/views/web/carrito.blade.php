@extends('layouts.web')

@section('titulo', 'Carrito')

@section('contenido')
@php
    // Productos de ejemplo en el carrito (quemados)
    $items = [
        ['nombre' => 'Audífonos Bluetooth', 'tienda' => 'Mundo Tech', 'precio' => '₡25.000', 'cantidad' => 1, 'subtotal' => '₡25.000'],
        ['nombre' => 'Lámpara de mesa', 'tienda' => 'Hogar y Estilo', 'precio' => '₡18.500', 'cantidad' => 2, 'subtotal' => '₡37.000'],
        ['nombre' => 'Jabón artesanal', 'tienda' => 'Tienda Verde', 'precio' => '₡3.500', 'cantidad' => 3, 'subtotal' => '₡10.500'],
    ];
@endphp

<div class="container px-5 py-5">
    <h1 class="h3 mb-4">Carrito de compra</h1>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th style="width: 120px;">Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                        <strong>{{ $item['nombre'] }}</strong><br>
                        <small class="text-muted">{{ $item['tienda'] }}</small>
                    </td>
                    <td>{{ $item['precio'] }}</td>
                    <td><input type="number" class="form-control" value="{{ $item['cantidad'] }}" min="1"></td>
                    <td>{{ $item['subtotal'] }}</td>
                    <td>
                        {{-- Quitar producto (por ahora recarga el carrito) --}}
                        <a href="{{ route('carrito') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-start">
        <a href="{{ route('productos.index') }}" class="btn btn-outline-dark">Seguir comprando</a>
        <div class="text-end">
            <p class="h4">Total: ₡72.500</p>
            <a href="{{ route('finalizar') }}" class="btn btn-dark">
                <i class="bi bi-cart-check"></i> Finalizar pedido
            </a>
        </div>
    </div>
</div>
@endsection