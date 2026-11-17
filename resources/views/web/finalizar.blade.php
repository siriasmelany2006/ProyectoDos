@extends('layouts.web')

@section('titulo', 'Finalizar pedido')

@section('contenido')
@php
    // Resumen de ejemplo (quemado)
    $items = [
        ['nombre' => 'Audífonos Bluetooth', 'tienda' => 'Mundo Tech', 'detalle' => '₡25.000 x 1', 'subtotal' => '₡25.000'],
        ['nombre' => 'Lámpara de mesa', 'tienda' => 'Hogar y Estilo', 'detalle' => '₡18.500 x 2', 'subtotal' => '₡37.000'],
        ['nombre' => 'Jabón artesanal', 'tienda' => 'Tienda Verde', 'detalle' => '₡3.500 x 3', 'subtotal' => '₡10.500'],
    ];
@endphp

<div class="container px-5 py-5">
    <h1 class="h3 mb-4">Finalizar pedido</h1>

    <div class="row">

        {{-- Datos del comprador --}}
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Información del cliente</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" placeholder="Tu nombre completo">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" placeholder="tu@correo.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" class="form-control" placeholder="8888-8888">
                    </div>
                    {{-- Por ahora vuelve al inicio --}}
                    <a href="{{ route('home') }}" class="btn btn-dark w-100">
                        <i class="bi bi-cart-check"></i> Confirmar pedido
                    </a>
                </div>
            </div>
        </div>

        {{-- Resumen del pedido --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">Resumen del pedido</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{ $item['nombre'] }}<br>
                                    <small class="text-muted">{{ $item['tienda'] }}</small>
                                </td>
                                <td>{{ $item['detalle'] }}</td>
                                <td class="text-end">{{ $item['subtotal'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="d-flex justify-content-between mb-1"><span>Subtotal:</span> <span>₡72.500</span></p>
                    <p class="d-flex justify-content-between h5"><span>Total:</span> <span>₡72.500</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection