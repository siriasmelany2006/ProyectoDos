@extends('layouts.web')

@section('titulo', 'Tiendas')

@section('contenido')
<div class="container px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Todas las tiendas</h1>
        {{-- Buscador de tiendas --}}
        <form action="{{ route('tiendas.index') }}" method="GET" class="w-25">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar tiendas...">
        </form>
    </div>

    @if ($tiendas->isNotEmpty())
    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach ($tiendas as $t)
        <div class="col">
            @include('partials.web.tienda-card', ['t' => $t])
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $tiendas->links() }}</div>
    @else
        <p class="text-muted">No se encontraron tiendas.</p>
    @endif
</div>
@endsection
