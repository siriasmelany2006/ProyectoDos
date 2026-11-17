@extends('layouts.web')

@section('titulo', 'Detalle del producto')

@section('contenido')
<div class="container px-5 py-5">

    {{-- Ruta de navegación --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Audífonos Bluetooth</li>
        </ol>
    </nav>

    <div class="row">

        {{-- Galería: imagen principal y 4 imágenes pequeñas --}}
        <div class="col-md-6 mb-4">
            <div class="bg-light d-flex align-items-center justify-content-center mb-2" style="height: 350px;">
                <i class="bi bi-image text-secondary" style="font-size: 4rem;"></i>
            </div>
            <div class="row g-2">
                @for ($i = 1; $i <= 4; $i++)
                <div class="col-3">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 70px;">
                        <i class="bi bi-image text-secondary"></i>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- Información del producto --}}
        <div class="col-md-6">
            <h1 class="h3">Audífonos Bluetooth</h1>
            <p class="text-muted">Tienda: <a href="{{ route('tiendas.show', 2) }}">Mundo Tech</a></p>
            <p class="h4">₡25.000</p>

            <label for="cantidad" class="form-label">Cantidad:</label>
            <input type="number" id="cantidad" class="form-control mb-3" value="1" min="1" style="width: 100px;">

            {{-- Por ahora solo lleva al carrito --}}
            <a href="{{ route('carrito') }}" class="btn btn-dark w-100 mb-4">
                <i class="bi bi-cart"></i> Agregar al carrito
            </a>

            <h2 class="h6">Descripción del producto</h2>
            <p>Audífonos inalámbricos con cancelación de ruido y hasta 20 horas de batería.</p>

            <h2 class="h6">Categorías</h2>
            <span class="badge bg-secondary">Tecnología</span>
            <span class="badge bg-secondary">Accesorios</span>
        </div>
    </div>
</div>
@endsection