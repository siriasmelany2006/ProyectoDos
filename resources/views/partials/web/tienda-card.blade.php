{{-- Tarjeta de tienda. Recibe $t (Tienda) --}}
<div class="card h-100 shadow-sm text-center">
    {{-- Banner --}}
    @if ($t->banner)
        <img src="{{ asset('storage/' . $t->banner) }}" class="card-img-top" alt="Banner de {{ $t->nombre }}" style="height: 100px; object-fit: cover;">
    @else
        <div class="bg-secondary" style="height: 100px;"></div>
    @endif
    {{-- Logo --}}
    <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden" style="width: 70px; height: 70px; margin-top: -35px;">
        @if ($t->logo)
            <img src="{{ asset('storage/' . $t->logo) }}" alt="Logo de {{ $t->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <i class="bi bi-shop fs-3"></i>
        @endif
    </div>
    <div class="card-body">
        <h3 class="h6">{{ $t->nombre }}</h3>
        <p class="small text-muted">{{ \Illuminate\Support\Str::limit($t->descripcion, 70) }}</p>
        <a href="{{ route('tiendas.show', $t->id_tienda) }}" class="btn btn-dark btn-sm">Ver tienda</a>
    </div>
</div>
