@extends('layouts.web')

@section('titulo', 'Tiendas')

@section('contenido')
@php
    // Datos de ejemplo (quemados)
    $tiendas = [
        ['id' => 1, 'nombre' => 'Tienda Verde', 'descripcion' => 'Productos naturales para tu hogar.'],
        ['id' => 2, 'nombre' => 'Mundo Tech', 'descripcion' => 'Tecnología y accesorios.'],
        ['id' => 3, 'nombre' => 'Hogar y Estilo', 'descripcion' => 'Decoración y muebles.'],
        ['id' => 4, 'nombre' => 'Moda Express', 'descripcion' => 'Ropa y accesorios de temporada.'],
        ['id' => 5, 'nombre' => 'Deportes CR', 'descripcion' => 'Todo para tu entrenamiento.'],
        ['id' => 6, 'nombre' => 'Mascotas Felices', 'descripcion' => 'Alimento y juguetes para mascotas.'],
    ];
@endphp

<div class="container px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Todas las tiendas</h1>
        <input type="search" class="form-control w-25" placeholder="Buscar tiendas...">
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach ($tiendas as $t)
        <div class="col">
            <div class="card h-100 shadow-sm text-center">
                {{-- Banner y logo de la tienda --}}
                <div class="bg-secondary" style="height: 100px;"></div>
                <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 70px; height: 70px; margin-top: -35px;">
                    <i class="bi bi-shop fs-3"></i>
                </div>
                <div class="card-body">
                    <h2 class="h6">{{ $t['nombre'] }}</h2>
                    <p class="small text-muted">{{ $t['descripcion'] }}</p>
                    <a href="{{ route('tiendas.show', $t['id']) }}" class="btn btn-dark btn-sm">Ver tienda</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection