@extends('layouts.web')

@section('titulo', 'Inicio')

@section('contenido')
@php
    // Datos de ejemplo (quemados): no vienen de la base de datos
    $destacadas = [
        ['id' => 1, 'nombre' => 'Tienda Verde', 'descripcion' => 'Productos naturales para tu hogar.'],
        ['id' => 2, 'nombre' => 'Mundo Tech', 'descripcion' => 'Tecnología y accesorios al mejor precio.'],
        ['id' => 3, 'nombre' => 'Moda Express', 'descripcion' => 'Ropa y accesorios de temporada.'],
    ];

    $masVendidos = [
        ['id' => 1, 'nombre' => 'Audífonos Bluetooth', 'tienda' => 'Mundo Tech', 'precio' => '₡25.000'],
        ['id' => 2, 'nombre' => 'Lámpara de mesa', 'tienda' => 'Hogar y Estilo', 'precio' => '₡18.500'],
        ['id' => 3, 'nombre' => 'Camiseta deportiva', 'tienda' => 'Deportes CR', 'precio' => '₡12.000'],
        ['id' => 4, 'nombre' => 'Jabón artesanal', 'tienda' => 'Tienda Verde', 'precio' => '₡3.500'],
        ['id' => 5, 'nombre' => 'Bolso de mano', 'tienda' => 'Moda Express', 'precio' => '₡22.000'],
    ];

    $topTiendas = [
        ['id' => 2, 'nombre' => 'Mundo Tech', 'descripcion' => 'Tecnología y accesorios.'],
        ['id' => 1, 'nombre' => 'Tienda Verde', 'descripcion' => 'Productos naturales.'],
        ['id' => 3, 'nombre' => 'Moda Express', 'descripcion' => 'Ropa y accesorios.'],
    ];
@endphp

{{-- SLIDER: tiendas destacadas --}}
<div id="sliderTiendas" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($destacadas as $i => $t)
        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 350px;">
                <div class="text-center">
                    {{-- Logo de la tienda (círculo de ejemplo) --}}
                    <div class="bg-white text-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                        <i class="bi bi-shop fs-1"></i>
                    </div>
                    <h2>{{ $t['nombre'] }}</h2>
                    <p>{{ $t['descripcion'] }}</p>
                    <a href="{{ route('tiendas.show', $t['id']) }}" class="btn btn-light">Ver tienda</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{-- Flechas del slider --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#sliderTiendas" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#sliderTiendas" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container px-5 py-5">

    {{-- PRODUCTOS MÁS VENDIDOS --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Productos más vendidos</h2>
        <a href="{{ route('productos.index') }}">Ver todos</a>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-5 g-3 mb-5">
        @foreach ($masVendidos as $p)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                    <i class="bi bi-image fs-1 text-secondary"></i>
                </div>
                <div class="card-body d-flex flex-column">
                    <h3 class="h6 card-title">{{ $p['nombre'] }}</h3>
                    <p class="small text-muted mb-1">{{ $p['tienda'] }}</p>
                    <p class="fw-bold">{{ $p['precio'] }}</p>
                    <a href="{{ route('productos.show', $p['id']) }}" class="btn btn-dark btn-sm mt-auto">Ver detalle</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- TIENDAS CON MAYORES VENTAS --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Tiendas destacadas</h2>
        <a href="{{ route('tiendas.index') }}">Ver todas</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach ($topTiendas as $t)
        <div class="col">
            <div class="card h-100 shadow-sm text-center">
                {{-- Banner y logo de la tienda --}}
                <div class="bg-secondary" style="height: 100px;"></div>
                <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 70px; height: 70px; margin-top: -35px;">
                    <i class="bi bi-shop fs-3"></i>
                </div>
                <div class="card-body">
                    <h3 class="h6">{{ $t['nombre'] }}</h3>
                    <p class="small text-muted">{{ $t['descripcion'] }}</p>
                    <a href="{{ route('tiendas.show', $t['id']) }}" class="btn btn-dark btn-sm">Ver tienda</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection