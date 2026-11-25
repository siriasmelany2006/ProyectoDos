@extends('layouts.web')

@section('titulo', 'Inicio')

@section('contenido')

{{-- SLIDER: tiendas destacadas por el administrador --}}
@if ($destacadas->isNotEmpty())
<div id="sliderTiendas" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($destacadas as $t)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <div class="text-white d-flex align-items-center justify-content-center"
                 style="height: 350px; background-color: #6c757d;
                 @if ($t->banner) background-image: url('{{ asset('storage/' . $t->banner) }}'); background-size: cover; background-position: center; @endif">
                <div class="text-center p-4 rounded" style="background: rgba(0,0,0,.45);">
                    {{-- Logo de la tienda --}}
                    <div class="bg-white text-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 overflow-hidden" style="width: 90px; height: 90px;">
                        @if ($t->logo)
                            <img src="{{ asset('storage/' . $t->logo) }}" alt="Logo de {{ $t->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-shop fs-1"></i>
                        @endif
                    </div>
                    <h2>{{ $t->nombre }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($t->descripcion, 100) }}</p>
                    <a href="{{ route('tiendas.show', $t->id_tienda) }}" class="btn btn-light">Ver tienda</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{-- Flechas del slider (solo si hay más de una tienda) --}}
    @if ($destacadas->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#sliderTiendas" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#sliderTiendas" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    @endif
</div>
@else
<div class="bg-dark text-white text-center py-5">
    <h1 class="display-6">Bienvenido a CrickoStore</h1>
    <p class="mb-0">Descubre productos de diferentes tiendas en un solo lugar.</p>
</div>
@endif

<div class="container px-5 py-5">

    {{-- PRODUCTOS MÁS VENDIDOS --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Productos más vendidos</h2>
        <a href="{{ route('productos.index') }}">Ver todos</a>
    </div>
    @if ($masVendidos->isNotEmpty())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-5 g-3 mb-5">
        @foreach ($masVendidos as $p)
        <div class="col">
            @include('partials.web.producto-card', ['p' => $p])
        </div>
        @endforeach
    </div>
    @else
        <p class="text-muted mb-5">Aún no hay ventas registradas.</p>
    @endif

    {{-- TIENDAS CON MAYORES VENTAS --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Tiendas con mayores ventas</h2>
        <a href="{{ route('tiendas.index') }}">Ver todas</a>
    </div>
    @if ($topTiendas->isNotEmpty())
    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach ($topTiendas as $t)
        <div class="col">
            @include('partials.web.tienda-card', ['t' => $t])
        </div>
        @endforeach
    </div>
    @else
        <p class="text-muted">Aún no hay ventas registradas.</p>
    @endif
</div>
@endsection
