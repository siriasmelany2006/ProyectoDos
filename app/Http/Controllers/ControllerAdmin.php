<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Tienda;
use Illuminate\Http\Request;

class ControllerAdmin extends Controller
{
    // ------------------------------------------------------------------
    // PEDIDOS
    // ------------------------------------------------------------------

    // Lista de TODOS los pedidos (primera pantalla del panel)
    public function pedidos(Request $request)
    {
        $pedidos = Pedido::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $texto = trim($request->q);
                $numero = ltrim($texto, '#');

                $query->where(function ($w) use ($texto, $numero) {
                    $w->where('cliente', 'like', "%{$texto}%")
                      ->orWhere('correo', 'like', "%{$texto}%");

                    // Si escribió un número (o #105), también busca por ID de pedido
                    if (ctype_digit($numero)) {
                        $w->orWhere('id_pedido', $numero);
                    }
                });
            })
            ->orderByDesc('id_pedido')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    // Detalle de un pedido: productos, tiendas, cantidades, subtotales y estado de cada línea
    public function pedidoDetalle($id)
    {
        $pedido = Pedido::with('detalles')->findOrFail($id);

        // La entrega solo se puede confirmar si TODOS los productos están en "Listo"
        $todosListos = $pedido->detalles->isNotEmpty()
            && $pedido->detalles->every(fn ($d) => $d->estado === 'Listo');

        return view('admin.pedidos.show', compact('pedido', 'todosListos'));
    }

    // Confirmar la entrega: el pedido pasa a "Entregado" y ya no se modifica
    public function confirmarEntrega($id)
    {
        $pedido = Pedido::with('detalles')->findOrFail($id);

        if ($pedido->estado === 'Entregado') {
            return back()->with('error', 'Este pedido ya fue entregado y no se puede modificar.');
        }

        $todosListos = $pedido->detalles->isNotEmpty()
            && $pedido->detalles->every(fn ($d) => $d->estado === 'Listo');

        if (!$todosListos) {
            return back()->with('error', 'No se puede confirmar la entrega: todavía hay productos que no están listos.');
        }

        $pedido->update(['estado' => 'Entregado']);

        return redirect()->route('admin.pedidos.show', $pedido->id_pedido)
            ->with('success', "El pedido #{$pedido->id_pedido} fue marcado como Entregado.");
    }

    // ------------------------------------------------------------------
    // TIENDAS
    // ------------------------------------------------------------------

    // Lista de todas las tiendas registradas
    public function tiendas(Request $request)
    {
        $tiendas = Tienda::query()
            ->when($request->filled('q'), fn ($q) => $q->where('nombre', 'like', '%' . $request->q . '%'))
            ->orderBy('id_tienda')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tiendas.index', compact('tiendas'));
    }

    // Activar / desactivar una tienda (no se borra nada: solo cambia el estado)
    public function tiendaActiva(Request $request, $id)
    {
        $request->validate(['valor' => 'required|in:0,1']);

        $tienda = Tienda::findOrFail($id);
        $activa = (bool) $request->valor;
        $tienda->update(['activa' => $activa]);

        $mensaje = $activa
            ? "La tienda {$tienda->nombre} fue activada."
            : "La tienda {$tienda->nombre} fue desactivada: ella y sus productos ya no se ven en el sitio público.";

        return back()->with('success', $mensaje);
    }

    // Marcar / quitar una tienda del slider del inicio
    public function tiendaDestacada(Request $request, $id)
    {
        $request->validate(['valor' => 'required|in:0,1']);

        $tienda = Tienda::findOrFail($id);
        $destacada = (bool) $request->valor;
        $tienda->update(['destacada' => $destacada]);

        $mensaje = $destacada
            ? "La tienda {$tienda->nombre} ahora aparece en el slider del inicio."
            : "La tienda {$tienda->nombre} ya no aparece en el slider del inicio.";

        return back()->with('success', $mensaje);
    }
}