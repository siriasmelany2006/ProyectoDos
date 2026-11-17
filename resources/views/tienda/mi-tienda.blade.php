@extends('layouts.admin')

@section('titulo', 'Mi tienda')

@section('contenido')
<h1 class="h3 mb-1 text-gray-800">Mi tienda</h1>
<p class="text-muted mb-4">Administrá la información de tu tienda.</p>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">

            {{-- Logo y banner --}}
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="font-weight-bold">Logo de la tienda</label>
                    <div class="bg-light text-center py-4 mb-2"><i class="fas fa-image fa-3x text-gray-500"></i></div>
                    <input type="file" class="form-control-file">
                    <small class="text-muted">Recomendado: 300 x 300 px</small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Banner principal</label>
                    <div class="bg-light text-center py-4 mb-2"><i class="fas fa-image fa-3x text-gray-500"></i></div>
                    <input type="file" class="form-control-file">
                    <small class="text-muted">Recomendado: 1200 x 400 px</small>
                </div>
            </div>

            {{-- Datos de la tienda --}}
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="font-weight-bold">Nombre de la tienda</label>
                    <input type="text" class="form-control" value="Mundo Tech">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Descripción</label>
                    <textarea class="form-control" rows="3">Tecnología y accesorios al mejor precio.</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">WhatsApp</label>
                        <input type="text" class="form-control" value="8777-7777">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">Teléfono</label>
                        <input type="text" class="form-control" value="2222-2222">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">Correo electrónico</label>
                        <input type="email" class="form-control" value="tienda@mundotech.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">Instagram</label>
                        <input type="text" class="form-control" value="mundotech">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">Facebook</label>
                        <input type="text" class="form-control" value="mundotech">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">YouTube</label>
                        <input type="text" class="form-control" value="https://youtube.com/mundotech">
                    </div>
                </div>

                {{-- Por ahora recarga la misma página --}}
                <a href="{{ route('tienda.mi-tienda') }}" class="btn btn-dark float-right">
                    <i class="fas fa-save"></i> Guardar cambios
                </a>
            </div>
        </div>
    </div>
</div>
@endsection