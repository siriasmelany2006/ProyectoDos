<?php

namespace App\Services;

use App\Models\Producto;

/**
 * El carrito vive en la sesión como: [ id_producto => cantidad ].
 * El precio y el nombre NUNCA se guardan en sesión: siempre se leen de la BD.
 */
class CarritoService
{
    /** Devuelve una colección de ['producto' => Producto, 'cantidad' => int, 'subtotal' => float]. */
    public static function items()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return collect();
        }

        // Solo productos que hoy siguen visibles (activos y de tienda activa)
        $productos = Producto::visibles()
            ->with('tienda')
            ->whereIn('id_producto', array_keys($carrito))
            ->get();

        // Si alguno dejó de estar disponible, se saca de la sesión
        $carrito = collect($carrito)->only($productos->pluck('id_producto')->all())->all();
        session(['carrito' => $carrito]);

        return $productos->map(function ($p) use ($carrito) {
            $cantidad = (int) $carrito[$p->id_producto];

            return [
                'producto' => $p,
                'cantidad' => $cantidad,
                'subtotal' => $p->precio * $cantidad,
            ];
        });
    }

    public static function total(): float
    {
        return (float) self::items()->sum('subtotal');
    }

    /** Cantidad total de unidades (para el numerito del navbar). */
    public static function cantidad(): int
    {
        return (int) array_sum(session('carrito', []));
    }
}
