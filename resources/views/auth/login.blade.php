@extends('layouts.web')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="container px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <h1 class="h4 mb-2">Iniciar sesión</h1>
                    <p class="text-muted mb-4">Entra con tu cuenta de Google para administrar tu tienda.</p>

                    <a href="{{ route('auth.google') }}" class="btn btn-dark w-100">
                        <i class="bi bi-google me-2"></i> Continuar con Google
                    </a>

                    <p class="small text-muted mt-3 mb-0">
                        Si es tu primera vez, se creará tu tienda automáticamente.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection