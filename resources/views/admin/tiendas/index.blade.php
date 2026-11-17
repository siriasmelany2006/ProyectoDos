@extends('layouts.admin')

@section('titulo', 'Tiendas')

@section('contenido')
@php
    // Datos de ejemplo (quemados)
    $tiendas = [
        ['id' => 1, 'nombre' => 'Tienda Verde', 'contacto' => 'WhatsApp: 8888-8888', 'activa' => true, 'destacada' => true],
        ['id' => 2, 'nombre' => 'Mundo Tech', 'contacto' => 'WhatsApp: 8777-7777', 'activa' => true, 'destacada' => false],
        ['id' => 3, 'nombre' => 'Hogar y Estilo', 'contacto' => 'WhatsApp: 8666-6666', 'activa' => false, 'destacada' => false],
        ['id' => 4, 'nombre' => 'Moda Express', 'contacto' => 'WhatsApp: 8555-5555', 'activa' => true, 'destacada' => true],
        ['id' => 5, 'nombre' => 'Deportes CR', 'contacto' => 'WhatsApp: 8444-4444', 'activa' => true, 'destacada' => false],
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Todas las tiendas</h1>
    <input type="search" class="form-control w-25" placeholder="Buscar tiendas...">
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Activa</th>
                    <th>Destacada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tiendas as $t)
                <tr>
                    <td>{{ $t['id'] }}</td>
                    <td><i class="fas fa-store fa-2x text-gray-500"></i></td>
                    <td>{{ $t['nombre'] }}</td>
                    <td>{{ $t['contacto'] }}</td>
                    <td>
                        {{-- Interruptor activa / inactiva (sin lógica por ahora) --}}
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="activa{{ $t['id'] }}" {{ $t['activa'] ? 'checked' : '' }}>
                            <label class="custom-control-label" for="activa{{ $t['id'] }}"></label>
                        </div>
                    </td>
                    <td>
                        {{-- Interruptor destacada (sin lógica por ahora) --}}
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="destacada{{ $t['id'] }}" {{ $t['destacada'] ? 'checked' : '' }}>
                            <label class="custom-control-label" for="destacada{{ $t['id'] }}"></label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection