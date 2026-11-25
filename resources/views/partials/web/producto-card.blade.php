{{-- Tarjeta de producto. Recibe $p (Producto). Opcional: $mostrarTienda (por defecto true) --}}
<div class="card h-100 shadow-sm">
    @if ($p->imagen)
        <img src="{{ asset('storage/' . $p->imagen) }}" class="card-img-top" alt="{{ $p->nombre }}" style="height: 140px; object-fit: cover;">
    @else
        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
            <i class="bi bi-image fs-1 text-secondary"></i>
        </div>
    @endif
    <div class="card-body d-flex flex-column">
        <h3 class="h6 card-title">{{ $p->nombre }}</h3>
        @if ($mostrarTienda ?? true)
            <p class="small text-muted mb-1">{{ $p->tienda->nombre }}</p>
        @endif
        <p class="fw-bold">₡{{ number_format($p->precio, 0, ',', '.') }}</p>
        <a href="{{ route('productos.show', $p->id_producto) }}" class="btn btn-dark btn-sm mt-auto">Ver detalle</a>
    </div>
</div>
