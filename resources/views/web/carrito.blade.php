@extends('layouts.web')

@section('titulo', 'Carrito')

@section('contenido')
<div class="container px-5 py-5">
    <h1 class="h3 mb-4">Carrito de compra</h1>

    @if ($items->isNotEmpty())
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th style="width: 150px;">Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                @php $p = $item['producto']; @endphp
                <tr>
                    <td>
                        <strong>{{ $p->nombre }}</strong><br>
                        <small class="text-muted">{{ $p->tienda->nombre }}</small>
                    </td>
                    <td>₡{{ number_format($p->precio, 0, ',', '.') }}</td>
                    <td>
                        {{-- Modificar cantidad: al cambiar el número se envía solo --}}
                        <form action="{{ route('carrito.actualizar', $p->id_producto) }}" method="POST" class="form-cantidad">
                            @csrf
                            @method('PATCH')
                            <div class="input-group input-group-sm">
                                <button type="button" class="btn btn-outline-secondary btn-menos">−</button>
                                <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="99" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary btn-mas">+</button>
                            </div>
                        </form>
                    </td>
                    <td>₡{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    <td>
                        {{-- Quitar producto --}}
                        <form action="{{ route('carrito.eliminar', $p->id_producto) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-start">
        <a href="{{ route('productos.index') }}" class="btn btn-outline-dark">Seguir comprando</a>
        <div class="text-end">
            <p class="h4">Total: ₡{{ number_format($total, 0, ',', '.') }}</p>
            <a href="{{ route('finalizar') }}" class="btn btn-dark">
                <i class="bi bi-cart-check"></i> Finalizar pedido
            </a>
        </div>
    </div>

    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-secondary"></i>
            <p class="lead mt-3">Tu carrito está vacío.</p>
            <a href="{{ route('productos.index') }}" class="btn btn-dark">Ver productos</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Botones + y −: cambian el número y envían el formulario
    $('.btn-mas').on('click', function () {
        var $f = $(this).closest('form'), $i = $f.find('input[name=cantidad]');
        $i.val(Math.min(99, (parseInt($i.val()) || 1) + 1));
        $f.submit();
    });
    $('.btn-menos').on('click', function () {
        var $f = $(this).closest('form'), $i = $f.find('input[name=cantidad]');
        $i.val(Math.max(1, (parseInt($i.val()) || 1) - 1));
        $f.submit();
    });
    // Si escribe el número a mano, se envía al salir del campo
    $('.form-cantidad input[name=cantidad]').on('change', function () {
        $(this).closest('form').submit();
    });
</script>
@endsection
