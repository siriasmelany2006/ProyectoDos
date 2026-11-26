<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Tabla: productos
 */
class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'id_tienda',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    // ---- Scopes -------------------------------------------------------
    /**
     * Productos que se muestran en el sitio público y se pueden comprar:
     * el producto está activo Y su tienda está activa.
     */
    public function scopeVisibles(Builder $query): Builder
    {
        return $query->where('productos.activo', true)
            ->whereHas('tienda', fn ($t) => $t->where('tiendas.activa', true));
    }

    // ---- Relaciones ---------------------------------------------------
    public function tienda(): BelongsTo
    {
        return $this->belongsTo(Tienda::class, 'id_tienda', 'id_tienda');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'producto_categoria',
            'id_producto',
            'id_categoria'
        );
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(Imagen::class, 'id_producto', 'id_producto');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(Detalle::class, 'id_producto', 'id_producto');
    }

    // ---- URL de la imagen principal (con imagen de reserva) -------------
    public function getImagenUrlAttribute(): string
    {
        return asset('storage/' . ($this->imagen ?: 'demo/sin-imagen.svg'));
    }
}
