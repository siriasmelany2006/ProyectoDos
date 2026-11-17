@extends('layouts.admin')

@section('titulo', 'Pedidos')

@section('contenido')
@php
    // Datos de ejemplo (quemados)
    $pedidos = [
        ['id' => 105, 'cliente' => 'María López', 'correo' => 'maria@mail.com', 'total' => '₡75.000', 'estado' => 'En preparación', 'fecha' => '27/10/2026'],
        ['id' => 104, 'cliente' => 'Juan Pérez', 'correo' => 'juan@mail.com', 'total' => '₡42.500', 'estado' => 'Listo', 'fecha' => '26/10/2026'],
        ['id' => 103, 'cliente' => 'Ana Vargas', 'correo' => 'ana@mail.com', 'total' => '₡18.000', 'estado' => 'Entregado', 'fecha' => '25/10/2026'],
        ['id' => 102, 'cliente' => 'Luis Mora', 'correo' => 'luis@mail.com', 'total' => '₡32.000', 'estado' => 'En preparación', 'fecha' => '24/10/2026'],
        ['id' => 101, 'cliente' => 'Carla Rojas', 'correo' => 'carla@mail.com', 'total' => '₡28.500', 'estado' => 'Entregado', 'fecha' => '23/10/2026'],
    ];

    // Color de la etiqueta según el estado
    $colores = ['En preparación' => 'warning', 'Listo' => 'info', 'Entregado' => 'success'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pedidos</h1>
    <input type="search" class="form-control w-25" placeholder="Buscar pedidos...">
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th style="width: 90px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $p)
                <tr>
                    <td>#{{ $p['id'] }}</td>
                    <td>{{ $p['cliente'] }}</td>
                    <td>{{ $p['correo'] }}</td>
                    <td>{{ $p['total'] }}</td>
                    <td><span class="badge badge-{{ $colores[$p['estado']] }}">{{ $p['estado'] }}</span></td>
                    <td>{{ $p['fecha'] }}</td>
                    <td>
                        <a href="{{ route('admin.pedidos.show', $p['id']) }}" class="btn btn-sm btn-dark">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginación de ejemplo --}}
        <nav>
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection