<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Tabla: imagenes (galería adicional de un producto)
 */
class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'imagen',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . ($this->imagen ?: 'demo/sin-imagen.svg'));
    }
}
