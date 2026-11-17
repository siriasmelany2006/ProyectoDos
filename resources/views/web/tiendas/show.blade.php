@extends('layouts.web')

@section('titulo', 'Detalle de la tienda')

@section('contenido')
@php
    // Productos de ejemplo de esta tienda (quemados)
    $productos = [
        ['id' => 1, 'nombre' => 'Audífonos Bluetooth', 'precio' => '₡25.000'],
        ['id' => 6, 'nombre' => 'Cargador portátil', 'precio' => '₡15.000'],
        ['id' => 7, 'nombre' => 'Mouse inalámbrico', 'precio' => '₡9.500'],
        ['id' => 8, 'nombre' => 'Teclado compacto', 'precio' => '₡20.000'],
    ];
@endphp

<div class="container px-5 py-5">

    {{-- Ruta de navegación --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tiendas.index') }}">Tiendas</a></li>
            <li class="breadcrumb-item active">Mundo Tech</li>
        </ol>
    </nav>

    {{-- Banner y logo --}}
    <div class="bg-secondary" style="height: 160px;"></div>
    <div class="text-center">
        <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 90px; height: 90px; margin-top: -45px;">
            <i class="bi bi-shop fs-1"></i>
        </div>
        <h1 class="h3 mt-2">Mundo Tech</h1>

        {{-- Contactos y redes sociales --}}
        <div class="fs-4">
            <a href="https://wa.me/50687777777" class="link-dark mx-2"><i class="bi bi-whatsapp"></i></a>
            <a href="tel:+50687777777" class="link-dark mx-2"><i class="bi bi-telephone"></i></a>
            <a href="mailto:tienda@mundotech.com" class="link-dark mx-2"><i class="bi bi-envelope"></i></a>
            <a href="https://instagram.com" class="link-dark mx-2"><i class="bi bi-instagram"></i></a>
            <a href="https://facebook.com" class="link-dark mx-2"><i class="bi bi-facebook"></i></a>
            <a href="https://youtube.com" class="link-dark mx-2"><i class="bi bi-youtube"></i></a>
        </div>
    </div>

    <p class="my-4">Somos una tienda especializada en tecnología y accesorios. Ofrecemos productos de calidad con garantía y envíos a todo el país.</p>

    {{-- Productos de la tienda --}}
    <h2 class="h4 mb-3">Productos de esta tienda</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-5">
        @foreach ($productos as $p)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                    <i class="bi bi-image fs-1 text-secondary"></i>
                </div>
                <div class="card-body d-flex flex-column">
                    <h3 class="h6 card-title">{{ $p['nombre'] }}</h3>
                    <p class="fw-bold">{{ $p['precio'] }}</p>
                    <a href="{{ route('productos.show', $p['id']) }}" class="btn btn-dark btn-sm mt-auto">Ver detalle</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Formulario de contacto (después enviará un correo con Mailtrap) --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="h4 mb-3">Contactar a la tienda</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" placeholder="Tu nombre">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" placeholder="tu@correo.com">
                </div>
                <div class="col-12">
                    <label class="form-label">Mensaje</label>
                    <textarea class="form-control" rows="4" placeholder="Escribí tu mensaje"></textarea>
                </div>
                <div class="col-12">
                    {{-- Por ahora solo recarga la tienda --}}
                    <a href="{{ route('tiendas.show', 2) }}" class="btn btn-dark">Enviar mensaje</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection