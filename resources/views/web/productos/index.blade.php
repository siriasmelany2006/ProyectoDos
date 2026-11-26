@extends('layouts.web')

@section('titulo', 'Productos')

@section('contenido')
<div class="container px-5 py-5">
    <div class="row">

        {{-- Panel lateral: categorías con cantidad de productos --}}
        <div class="col-lg-3 mb-4">
            <h2 class="h5">Categorías</h2>
            <div class="list-group">
                <a href="{{ route('productos.index') }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !$categoriaActual ? 'active' : '' }}">
                    Todas
                    <span class="badge bg-secondary">{{ $totalProductos }}</span>
                </a>
                @foreach ($categorias as $c)
                <a href="{{ route('productos.index', ['categoria' => $c->id_categoria]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $categoriaActual && $categoriaActual->id_categoria == $c->id_categoria ? 'active' : '' }}">
                    {{ $c->nombre }}
                    <span class="badge bg-secondary">{{ $c->productos_count }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Listado de productos --}}
        <div class="col-lg-9">
            <h1 class="h3 mb-4">
                {{ $categoriaActual ? $categoriaActual->nombre : 'Todos los productos' }}
                @if (request('q')) <small class="text-muted fs-6">· resultados de "{{ request('q') }}"</small> @endif
            </h1>

            @if ($productos->isNotEmpty())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach ($productos as $p)
                <div class="col">
                    @include('partials.web.producto-card', ['p' => $p])
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $productos->links() }}</div>
            @else
                <p class="text-muted">No se encontraron productos.</p>
            @endif
        </div>
    </div>
</div>
@endsection
