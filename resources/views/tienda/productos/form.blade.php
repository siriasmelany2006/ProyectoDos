@extends('layouts.admin')

@section('titulo', 'Producto')

{{-- Esta vista se usa para crear ($producto es null) y para editar --}}
@section('contenido')
@php
    $editando = $producto !== null;
    $seleccionadas = old('categorias', $editando ? $producto->categorias->pluck('id_categoria')->all() : []);
    $existentes = $editando ? $producto->imagenes : collect();
    $espacios = 4 - $existentes->count();
@endphp

<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tienda.productos.index') }}">Mis productos</a></li>
        <li class="breadcrumb-item active">{{ $editando ? 'Editar producto' : 'Nuevo producto' }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $editando ? 'Editar producto' : 'Nuevo producto' }}</h1>
    <a href="{{ route('tienda.productos.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ $editando ? route('tienda.productos.actualizar', $producto->id_producto) : route('tienda.productos.guardar') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if ($editando)
                @method('PUT')
            @endif

            <div class="row">

                {{-- Imagen principal y galería de hasta 4 imágenes --}}
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Imagen principal {{ $editando ? '' : '*' }}</label>

                        {{-- Vista previa: al crear queda oculta hasta que se elige una imagen --}}
                        <div id="caja-vista" class="bg-light text-center p-2 mb-2 {{ $editando ? '' : 'd-none' }}">
                            <img id="vista-imagen" src="{{ $editando ? $producto->imagen_url : '' }}"
                                 alt="Imagen principal" class="img-fluid" style="max-height: 180px;">
                        </div>

                        <input type="file" name="imagen" id="input-imagen" class="form-control-file" accept="image/*">
                        <small class="text-muted">JPG, PNG o WEBP, máximo 2 MB. Recomendado: 800 x 600 px</small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Galería de imágenes (máximo 4)</label>

                        {{-- Imágenes que ya tiene (solo al editar) --}}
                        @foreach ($existentes as $img)
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $img->url }}" alt="Galería" style="width: 70px; height: 50px; object-fit: cover;" class="mr-2">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-quitar"
                                        data-url="{{ route('tienda.productos.imagen.quitar', $img->id_imagen) }}">
                                    <i class="fas fa-times"></i> Quitar
                                </button>
                            </div>
                        @endforeach

                        {{-- Espacios libres para subir imágenes nuevas --}}
                        @for ($i = 0; $i < $espacios; $i++)
                            <input type="file" name="galeria[]" class="form-control-file mb-2" accept="image/*">
                        @endfor

                        @if ($espacios <= 0)
                            <small class="text-muted">La galería está completa. Quita una imagen para subir otra.</small>
                        @else
                            <small class="text-muted">Puedes agregar {{ $espacios }} imagen(es) más.</small>
                        @endif
                    </div>
                </div>

                {{-- Datos del producto --}}
                <div class="col-lg-8">
                    <div class="form-group">
                        <label class="font-weight-bold">Nombre del producto</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto"
                               value="{{ old('nombre', $editando ? $producto->nombre : '') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"
                                  placeholder="Descripción del producto...">{{ old('descripcion', $editando ? $producto->descripcion : '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Precio (₡)</label>
                        <input type="number" name="precio" class="form-control" placeholder="0" min="1" step="0.01"
                               value="{{ old('precio', $editando ? $producto->precio : '') }}" required>
                    </div>

                    {{-- Categorías (se pueden marcar varias) --}}
                    <div class="form-group">
                        <label class="font-weight-bold">Categorías (puedes seleccionar varias)</label>
                        <div class="row">
                            @foreach ($categorias as $cat)
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categorias[]" value="{{ $cat->id_categoria }}"
                                           class="custom-control-input" id="cat{{ $cat->id_categoria }}"
                                           {{ in_array($cat->id_categoria, $seleccionadas) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="cat{{ $cat->id_categoria }}">{{ $cat->nombre }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark float-right">
                        <i class="fas fa-save"></i> Guardar producto
                    </button>
                </div>
            </div>
        </form>

        {{-- Formulario oculto para quitar una imagen de la galería (no puede ir dentro del otro formulario) --}}
        <form id="form-quitar" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Vista previa de la imagen principal: al elegir un archivo se muestra la caja y la foto
    $('#input-imagen').on('change', function () {
        if (this.files && this.files[0]) {
            $('#vista-imagen').attr('src', URL.createObjectURL(this.files[0]));
            $('#caja-vista').removeClass('d-none');
        }
    });

    // Quitar una imagen de la galería: se manda el formulario oculto a su dirección
    $('.btn-quitar').on('click', function () {
        if (confirm('¿Quitar esta imagen de la galería?')) {
            $('#form-quitar').attr('action', $(this).data('url')).submit();
        }
    });
</script>
@endsection