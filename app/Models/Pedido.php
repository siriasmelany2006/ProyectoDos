<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Tabla: pedidos
 * Estados del pedido: 'En preparación' -> 'Listo' -> 'Entregado'
 */
class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'cliente',
        'correo',
        'telefono',
        'total',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(Detalle::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Actualización automática del estado: el pedido pasa a 'Listo' cuando
     * todos sus productos están 'Listo', y vuelve a 'En preparación' si no.
     * Un pedido 'Entregado' nunca se modifica.
     */
    public function recalcularEstado(): void
    {
        if ($this->estado === 'Entregado') {
            return;
        }

        $todosListos = $this->detalles()->exists()
            && $this->detalles()->where('estado', '!=', 'Listo')->doesntExist();

        $this->estado = $todosListos ? 'Listo' : 'En preparación';
        $this->save();
    }
}
