@extends('layouts.web')

@section('titulo', $tienda->nombre)

@section('contenido')
@php
    // WhatsApp: si son 8 dígitos se le agrega el código de Costa Rica (506)
    $wa = preg_replace('/\D/', '', (string) $tienda->whatsapp);
    if (strlen($wa) == 8) { $wa = '506' . $wa; }

    // Redes: aceptan un enlace completo o solo el usuario
    $enlace = fn ($valor, $base) => str_starts_with($valor, 'http') ? $valor : $base . ltrim($valor, '@/');
@endphp

<div class="container px-5 py-5">

    {{-- Ruta de navegación --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tiendas.index') }}">Tiendas</a></li>
            <li class="breadcrumb-item active">{{ $tienda->nombre }}</li>
        </ol>
    </nav>

    {{-- Banner y logo --}}
    @if ($tienda->banner)
        <img src="{{ asset('storage/' . $tienda->banner) }}" alt="Banner" class="w-100" style="height: 160px; object-fit: cover;">
    @else
        <div class="bg-secondary" style="height: 160px;"></div>
    @endif
    <div class="text-center">
        <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden" style="width: 90px; height: 90px; margin-top: -45px;">
            @if ($tienda->logo)
                <img src="{{ asset('storage/' . $tienda->logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="bi bi-shop fs-1"></i>
            @endif
        </div>
        <h1 class="h3 mt-2">{{ $tienda->nombre }}</h1>

        {{-- Contactos y redes sociales (solo se muestran los que la tienda llenó) --}}
        <div class="fs-4">
            @if ($wa)
                <a href="https://wa.me/{{ $wa }}" target="_blank" class="link-dark mx-2"><i class="bi bi-whatsapp"></i></a>
            @endif
            @if ($tienda->telefono)
                <a href="tel:{{ $tienda->telefono }}" class="link-dark mx-2"><i class="bi bi-telephone"></i></a>
            @endif
            @if ($tienda->correo)
                <a href="mailto:{{ $tienda->correo }}" class="link-dark mx-2"><i class="bi bi-envelope"></i></a>
            @endif
            @if ($tienda->instagram)
                <a href="{{ $enlace($tienda->instagram, 'https://instagram.com/') }}" target="_blank" class="link-dark mx-2"><i class="bi bi-instagram"></i></a>
            @endif
            @if ($tienda->facebook)
                <a href="{{ $enlace($tienda->facebook, 'https://facebook.com/') }}" target="_blank" class="link-dark mx-2"><i class="bi bi-facebook"></i></a>
            @endif
            @if ($tienda->youtube)
                <a href="{{ $enlace($tienda->youtube, 'https://youtube.com/@') }}" target="_blank" class="link-dark mx-2"><i class="bi bi-youtube"></i></a>
            @endif
        </div>
    </div>

    <p class="my-4">{{ $tienda->descripcion }}</p>

    {{-- Productos de la tienda --}}
    <h2 class="h4 mb-3">Productos de esta tienda</h2>
    @if ($productos->isNotEmpty())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-5">
        @foreach ($productos as $p)
        <div class="col">
            @include('partials.web.producto-card', ['p' => $p, 'mostrarTienda' => false])
        </div>
        @endforeach
    </div>
    @else
        <p class="text-muted mb-5">Esta tienda aún no tiene productos disponibles.</p>
    @endif

    {{-- Formulario de contacto: envía un correo a la tienda --}}
    <div class="card shadow-sm" id="contacto">
        <div class="card-body">
            <h2 class="h4 mb-3">Contactar a la tienda</h2>
            <form action="{{ route('tiendas.contacto', $tienda->id_tienda) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Tu nombre">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" class="form-control" placeholder="tu@correo.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mensaje</label>
                        <textarea name="mensaje" class="form-control" rows="4" placeholder="Escribe tu mensaje">{{ old('mensaje') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark">Enviar mensaje</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
