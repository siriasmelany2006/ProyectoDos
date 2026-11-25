<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Tabla: tiendas
 */
class Tienda extends Model
{
    protected $table = 'tiendas';
    protected $primaryKey = 'id_tienda';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre',
        'descripcion',
        'logo',
        'banner',
        'whatsapp',
        'telefono',
        'correo',
        'instagram',
        'facebook',
        'youtube',
        'destacada',
        'activa',
    ];

    protected $casts = [
        'destacada' => 'boolean',
        'activa'    => 'boolean',
    ];

    // ---- Scopes -------------------------------------------------------
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('tiendas.activa', true);
    }

    public function scopeDestacadas(Builder $query): Builder
    {
        return $query->where('tiendas.destacada', true);
    }

    // ---- Relaciones ---------------------------------------------------
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_tienda', 'id_tienda');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(Detalle::class, 'id_tienda', 'id_tienda');
    }

    // ---- URLs de imágenes (con imagen de reserva) ----------------------
    public function getLogoUrlAttribute(): string
    {
        return asset('storage/' . ($this->logo ?: 'demo/sin-imagen.svg'));
    }

    public function getBannerUrlAttribute(): string
    {
        return asset('storage/' . ($this->banner ?: 'demo/sin-imagen.svg'));
    }
}
