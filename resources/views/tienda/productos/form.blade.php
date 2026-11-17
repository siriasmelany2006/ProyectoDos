@extends('layouts.admin')

@section('titulo', 'Producto')

{{-- Esta vista se usa para crear y para editar un producto --}}
@section('contenido')
<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tienda.productos.index') }}">Mis productos</a></li>
        <li class="breadcrumb-item active">Producto</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nuevo producto</h1>
    <a href="{{ route('tienda.productos.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">

            {{-- Imagen principal y galería de hasta 4 imágenes --}}
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="font-weight-bold">Imagen principal</label>
                    <div class="bg-light text-center py-5 mb-2"><i class="fas fa-image fa-3x text-gray-500"></i></div>
                    <input type="file" class="form-control-file">
                    <small class="text-muted">Recomendado: 800 x 600 px</small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Galería de imágenes (máximo 4)</label>
                    @for ($i = 1; $i <= 4; $i++)
                        <input type="file" class="form-control-file mb-2">
                    @endfor
                </div>
            </div>

            {{-- Datos del producto --}}
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="font-weight-bold">Nombre del producto</label>
                    <input type="text" class="form-control" placeholder="Nombre del producto">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Descripción</label>
                    <textarea class="form-control" rows="3" placeholder="Descripción del producto..."></textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Precio (₡)</label>
                    <input type="number" class="form-control" placeholder="0">
                </div>

                {{-- Categorías (se pueden marcar varias) --}}
                <div class="form-group">
                    <label class="font-weight-bold">Categorías (podés seleccionar varias)</label>
                    <div class="row">
                        @foreach (['Tecnología', 'Hogar', 'Moda', 'Belleza', 'Deportes', 'Juguetes', 'Alimentos', 'Mascotas'] as $i => $cat)
                        <div class="col-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="cat{{ $i }}">
                                <label class="custom-control-label" for="cat{{ $i }}">{{ $cat }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Por ahora vuelve al listado --}}
                <a href="{{ route('tienda.productos.index') }}" class="btn btn-dark float-right">
                    <i class="fas fa-save"></i> Guardar producto
                </a>
            </div>
        </div>
    </div>
</div>
@endsection