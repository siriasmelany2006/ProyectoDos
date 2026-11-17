@extends('layouts.web')

@section('titulo', 'Productos')

@section('contenido')
@php
    // Datos de ejemplo (quemados)
    $categorias = [
        ['Todas', 120], ['Tecnología', 28], ['Hogar', 15], ['Moda', 22], ['Belleza', 10],
        ['Deportes', 14], ['Juguetes', 8], ['Alimentos', 8], ['Mascotas', 6],
    ];

    $productos = [
        ['id' => 1, 'nombre' => 'Audífonos Bluetooth', 'tienda' => 'Mundo Tech', 'precio' => '₡25.000'],
        ['id' => 2, 'nombre' => 'Lámpara de mesa', 'tienda' => 'Hogar y Estilo', 'precio' => '₡18.500'],
        ['id' => 3, 'nombre' => 'Camiseta deportiva', 'tienda' => 'Deportes CR', 'precio' => '₡12.000'],
        ['id' => 4, 'nombre' => 'Jabón artesanal', 'tienda' => 'Tienda Verde', 'precio' => '₡3.500'],
        ['id' => 5, 'nombre' => 'Bolso de mano', 'tienda' => 'Moda Express', 'precio' => '₡22.000'],
        ['id' => 6, 'nombre' => 'Cargador portátil', 'tienda' => 'Mundo Tech', 'precio' => '₡15.000'],
    ];
@endphp

<div class="container px-5 py-5">
    <div class="row">

        {{-- Panel lateral: categorías con cantidad de productos --}}
        <div class="col-lg-3 mb-4">
            <h2 class="h5">Categorías</h2>
            <div class="list-group">
                @foreach ($categorias as $i => $c)
                <a href="{{ route('productos.index') }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $i == 0 ? 'active' : '' }}">
                    {{ $c[0] }}
                    <span class="badge bg-secondary">{{ $c[1] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Listado de productos --}}
        <div class="col-lg-9">
            <h1 class="h3 mb-4">Todos los productos</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach ($productos as $p)
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
        </div>
    </div>
</div>
@endsection