@extends('layouts.admin')

@section('titulo', 'Mi tienda')

@section('contenido')
<h1 class="h3 mb-1 text-gray-800">Mi tienda</h1>
<p class="text-muted mb-4">Administra la información de tu tienda.</p>

<div class="card shadow mb-4">
    <div class="card-body">
        {{-- enctype multipart es necesario para subir archivos --}}
        <form action="{{ route('tienda.mi-tienda.actualizar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- Logo y banner --}}
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Logo de la tienda</label>
                        <div class="bg-light text-center p-2 mb-2">
                            <img id="vista-logo" src="{{ $tienda->logo_url }}" alt="Logo" class="img-fluid" style="max-height: 150px;">
                        </div>
                        <input type="file" name="logo" id="input-logo" class="form-control-file" accept="image/*">
                        <small class="text-muted">JPG, PNG o WEBP, máximo 2 MB. Recomendado: 300 x 300 px</small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Banner principal</label>
                        <div class="bg-light text-center p-2 mb-2">
                            <img id="vista-banner" src="{{ $tienda->banner_url }}" alt="Banner" class="img-fluid" style="max-height: 150px;">
                        </div>
                        <input type="file" name="banner" id="input-banner" class="form-control-file" accept="image/*">
                        <small class="text-muted">JPG, PNG o WEBP, máximo 4 MB. Recomendado: 1200 x 400 px</small>
                    </div>
                </div>

                {{-- Datos de la tienda --}}
                <div class="col-lg-8">
                    <div class="form-group">
                        <label class="font-weight-bold">Nombre de la tienda</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tienda->nombre) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $tienda->descripcion) }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $tienda->whatsapp) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $tienda->telefono) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control" value="{{ old('correo', $tienda->correo) }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Instagram</label>
                            <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $tienda->instagram) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Facebook</label>
                            <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $tienda->facebook) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">YouTube</label>
                            <input type="text" name="youtube" class="form-control" value="{{ old('youtube', $tienda->youtube) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark float-right">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Vista previa: al elegir una imagen se muestra antes de guardar
    function vistaPrevia(input, imagen) {
        $(input).on('change', function () {
            if (this.files && this.files[0]) {
                $(imagen).attr('src', URL.createObjectURL(this.files[0]));
            }
        });
    }

    vistaPrevia('#input-logo', '#vista-logo');
    vistaPrevia('#input-banner', '#vista-banner');
</script>
@endsection