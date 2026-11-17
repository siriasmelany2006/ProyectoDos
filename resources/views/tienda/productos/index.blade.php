@extends('layouts.admin')

@section('titulo', 'Mis productos')

@section('contenido')
@php
    // Datos de ejemplo (quemados)
    $productos = [
        ['id' => 1, 'nombre' => 'Producto A', 'precio' => '₡25.000', 'categorias' => ['Tecnología', 'Accesorios'], 'activo' => true],
        ['id' => 2, 'nombre' => 'Producto B', 'precio' => '₡30.000', 'categorias' => ['Hogar', 'Decoración'], 'activo' => true],
        ['id' => 3, 'nombre' => 'Producto C', 'precio' => '₡20.000', 'categorias' => ['Moda'], 'activo' => false],
        ['id' => 4, 'nombre' => 'Producto D', 'precio' => '₡18.000', 'categorias' => ['Belleza'], 'activo' => true],
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mis productos</h1>
    <a href="{{ route('tienda.productos.crear') }}" class="btn btn-dark">
        <i class="fas fa-plus"></i> Nuevo producto
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categorías</th>
                    <th>Estado</th>
                    <th style="width: 200px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $p)
                <tr>
                    <td>{{ $p['id'] }}</td>
                    <td><i class="fas fa-image fa-2x text-gray-500"></i></td>
                    <td>{{ $p['nombre'] }}</td>
                    <td>{{ $p['precio'] }}</td>
                    <td>
                        @foreach ($p['categorias'] as $c)
                            <span class="badge badge-secondary">{{ $c }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if ($p['activo'])
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tienda.productos.editar', $p['id']) }}" class="btn btn-sm btn-dark">
                            <i class="fas fa-pen"></i> Editar
                        </a>
                        {{-- Activar o desactivar (por ahora recarga la lista) --}}
                        @if ($p['activo'])
                            <a href="{{ route('tienda.productos.index') }}" class="btn btn-sm btn-danger">Desactivar</a>
                        @else
                            <a href="{{ route('tienda.productos.index') }}" class="btn btn-sm btn-success">Activar</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection