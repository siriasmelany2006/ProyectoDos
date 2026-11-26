<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Tabla: usuarios (id_usuario, google_id, nombre, correo, foto, rol)
 * Roles: 'admin' y 'tienda'.
 */
class User extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    // La tabla no tiene columna remember_token
    protected $rememberTokenName = '';

    protected $fillable = [
        'google_id',
        'nombre',
        'correo',
        'foto',
        'rol',
    ];

    public function tienda(): HasOne
    {
        return $this->hasOne(Tienda::class, 'id_usuario', 'id_usuario');
    }

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function esTienda(): bool
    {
        return $this->rol === 'tienda';
    }
}
