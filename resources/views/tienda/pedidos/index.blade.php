@extends('layouts.admin')

@section('titulo', 'Mis pedidos')

@section('contenido')
@php
    // Datos de ejemplo (quemados)
    $pedidos = [
        ['id' => 105, 'cliente' => 'María López', 'correo' => 'maria@mail.com', 'total' => '₡75.000', 'estado' => 'En preparación', 'fecha' => '27/10/2026'],
        ['id' => 103, 'cliente' => 'Ana Vargas', 'correo' => 'ana@mail.com', 'total' => '₡18.000', 'estado' => 'Listo', 'fecha' => '25/10/2026'],
        ['id' => 102, 'cliente' => 'Luis Mora', 'correo' => 'luis@mail.com', 'total' => '₡32.000', 'estado' => 'En preparación', 'fecha' => '24/10/2026'],
        ['id' => 98, 'cliente' => 'Andrés Ruiz', 'correo' => 'andres@mail.com', 'total' => '₡27.000', 'estado' => 'Entregado', 'fecha' => '20/10/2026'],
    ];

    // Color de la etiqueta según el estado
    $colores = ['En preparación' => 'warning', 'Listo' => 'info', 'Entregado' => 'success'];
@endphp

<h1 class="h3 mb-1 text-gray-800">Mis pedidos</h1>
<p class="text-muted mb-4">Aquí se muestran los pedidos que contienen productos de tu tienda.</p>

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
                        <a href="{{ route('tienda.pedidos.show', $p['id']) }}" class="btn btn-sm btn-dark">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection