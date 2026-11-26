@extends('layouts.web')

@section('titulo', $producto->nombre)

@section('contenido')
@php
    // Todas las fotos: la principal primero y luego la galería
    $fotos = collect([$producto->imagen])->merge($producto->imagenes->pluck('imagen'))->filter()->values();
@endphp

<div class="container px-5 py-5">

    {{-- Ruta de navegación --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <div class="row">

        {{-- Galería: imagen principal e imágenes pequeñas (clic para cambiar la grande) --}}
        <div class="col-md-6 mb-4">
            <div class="bg-light d-flex align-items-center justify-content-center mb-2 overflow-hidden" style="height: 350px;">
                @if ($fotos->isNotEmpty())
                    <img id="imgPrincipal" src="{{ asset('storage/' . $fotos->first()) }}" alt="{{ $producto->nombre }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @else
                    <i class="bi bi-image text-secondary" style="font-size: 4rem;"></i>
                @endif
            </div>
            @if ($fotos->count() > 1)
            <div class="row g-2">
                @foreach ($fotos as $foto)
                <div class="col-3">
                    <img src="{{ asset('storage/' . $foto) }}" class="miniatura img-thumbnail" alt="Miniatura" style="height: 70px; width: 100%; object-fit: cover; cursor: pointer;">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Información del producto --}}
        <div class="col-md-6">
            <h1 class="h3">{{ $producto->nombre }}</h1>
            <p class="text-muted">Tienda: <a href="{{ route('tiendas.show', $producto->id_tienda) }}">{{ $producto->tienda->nombre }}</a></p>
            <p class="h4">₡{{ number_format($producto->precio, 0, ',', '.') }}</p>

            {{-- Agregar al carrito --}}
            <form action="{{ route('carrito.agregar') }}" method="POST">
                @csrf
                <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">

                <label for="cantidad" class="form-label">Cantidad:</label>
                <div class="input-group mb-3" style="width: 150px;">
                    <button type="button" class="btn btn-outline-secondary" id="menos">−</button>
                    <input type="number" id="cantidad" name="cantidad" class="form-control text-center" value="1" min="1" max="99">
                    <button type="button" class="btn btn-outline-secondary" id="mas">+</button>
                </div>

                <button type="submit" class="btn btn-dark w-100 mb-4">
                    <i class="bi bi-cart"></i> Agregar al carrito
                </button>
            </form>

            <h2 class="h6">Descripción del producto</h2>
            <p>{{ $producto->descripcion }}</p>

            <h2 class="h6">Categorías</h2>
            @foreach ($producto->categorias as $cat)
                <a href="{{ route('productos.index', ['categoria' => $cat->id_categoria]) }}" class="badge bg-secondary text-decoration-none">{{ $cat->nombre }}</a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Clic en una miniatura: cambia la imagen grande
    $('.miniatura').on('click', function () {
        $('#imgPrincipal').attr('src', $(this).attr('src'));
    });

    // Botones + y − de la cantidad
    $('#mas').on('click', function () {
        var v = parseInt($('#cantidad').val()) || 1;
        $('#cantidad').val(Math.min(99, v + 1));
    });
    $('#menos').on('click', function () {
        var v = parseInt($('#cantidad').val()) || 1;
        $('#cantidad').val(Math.max(1, v - 1));
    });
</script>
@endsection
