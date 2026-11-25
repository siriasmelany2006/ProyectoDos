@extends('layouts.web')

@section('titulo', 'Finalizar pedido')

@section('contenido')
<div class="container px-5 py-5">
    <h1 class="h3 mb-4">Finalizar pedido</h1>

    <div class="row">

        {{-- Datos del comprador --}}
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Información del cliente</div>
                <div class="card-body">
                    <form action="{{ route('pedido.guardar') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="cliente" value="{{ old('cliente') }}" class="form-control" placeholder="Tu nombre completo">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="correo" value="{{ old('correo') }}" class="form-control" placeholder="tu@correo.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono (opcional)</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="8888-8888">
                        </div>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="bi bi-cart-check"></i> Confirmar pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Resumen del pedido --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">Resumen del pedido</div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            @foreach ($items as $item)
                            @php $p = $item['producto']; @endphp
                            <tr>
                                <td>
                                    {{ $p->nombre }}<br>
                                    <small class="text-muted">{{ $p->tienda->nombre }}</small>
                                </td>
                                <td>₡{{ number_format($p->precio, 0, ',', '.') }} x {{ $item['cantidad'] }}</td>
                                <td class="text-end">₡{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="d-flex justify-content-between mb-1"><span>Subtotal:</span> <span>₡{{ number_format($total, 0, ',', '.') }}</span></p>
                    <p class="d-flex justify-content-between h5"><span>Total:</span> <span>₡{{ number_format($total, 0, ',', '.') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
