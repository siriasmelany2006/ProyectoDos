<?php

namespace App\Http\Controllers;

use App\Mail\ContactoTienda;
use App\Mail\PedidoConfirmado;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Tienda;
use App\Services\CarritoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ControllerWeb extends Controller
{
    // ------------------------------------------------------------------
    // INICIO
    // ------------------------------------------------------------------
    public function inicio()
    {
        // Las estadísticas se calculan solo con pedidos ENTREGADOS
        $soloEntregados = fn ($q) => $q->whereHas('pedido', fn ($p) => $p->where('estado', 'Entregado'));

        // Slider: tiendas destacadas (y activas)
        $destacadas = Tienda::activas()->destacadas()->get();

        // Los 5 productos más vendidos (suma de unidades)
        $masVendidos = Producto::visibles()
            ->with('tienda')
            ->withSum(['detalles as total_vendido' => $soloEntregados], 'cantidad')
            ->having('total_vendido', '>', 0)
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        // Las 3 tiendas con mayores ventas (suma del monto)
        $topTiendas = Tienda::activas()
            ->withSum(['detalles as total_vendido' => $soloEntregados], 'subtotal')
            ->having('total_vendido', '>', 0)
            ->orderByDesc('total_vendido')
            ->take(3)
            ->get();

        return view('web.inicio', compact('destacadas', 'masVendidos', 'topTiendas'));
    }

    // ------------------------------------------------------------------
    // PRODUCTOS
    // ------------------------------------------------------------------
    public function productos(Request $request)
    {
        $query = Producto::visibles()->with('tienda');

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->whereHas('categorias', fn ($c) => $c->where('categorias.id_categoria', $request->categoria));
        }

        // Buscador (por nombre de producto o de tienda)
        if ($request->filled('q')) {
            $texto = $request->q;
            $query->where(function ($w) use ($texto) {
                $w->where('productos.nombre', 'like', "%{$texto}%")
                  ->orWhereHas('tienda', fn ($t) => $t->where('nombre', 'like', "%{$texto}%"));
            });
        }

        $productos = $query->orderByDesc('id_producto')->paginate(9)->withQueryString();

        // Panel lateral: categorías con cantidad de productos visibles
        $categorias = Categoria::withCount(['productos as productos_count' => fn ($p) => $p->visibles()])->get();
        $totalProductos = Producto::visibles()->count();
        $categoriaActual = $request->filled('categoria') ? $categorias->firstWhere('id_categoria', $request->categoria) : null;

        return view('web.productos.index', compact('productos', 'categorias', 'totalProductos', 'categoriaActual'));
    }

    public function productoDetalle($id)
    {
        $producto = Producto::visibles()->with(['tienda', 'imagenes', 'categorias'])->findOrFail($id);

        return view('web.productos.show', compact('producto'));
    }

    // ------------------------------------------------------------------
    // TIENDAS
    // ------------------------------------------------------------------
    public function tiendas(Request $request)
    {
        $tiendas = Tienda::activas()
            ->when($request->filled('q'), fn ($q) => $q->where('nombre', 'like', '%' . $request->q . '%'))
            ->orderBy('nombre')
            ->paginate(6)
            ->withQueryString();

        return view('web.tiendas.index', compact('tiendas'));
    }

    public function tiendaDetalle($id)
    {
        $tienda = Tienda::activas()->findOrFail($id);
        $productos = $tienda->productos()->visibles()->get();

        return view('web.tiendas.show', compact('tienda', 'productos'));
    }

    // Formulario de contacto: envía un correo a la tienda (Mailtrap)
    public function contactoTienda(Request $request, $id)
    {
        $tienda = Tienda::activas()->with('usuario')->findOrFail($id);

        $datos = $request->validate([
            'nombre'  => 'required|string|max:100',
            'correo'  => 'required|email|max:100',
            'mensaje' => 'required|string|max:1000',
        ], $this->mensajes(), $this->atributos());

        // Si la tienda no puso correo de contacto, se usa el del dueño
        $destino = $tienda->correo ?: optional($tienda->usuario)->correo;

        if (!$destino) {
            return back()->with('error', 'Esta tienda no tiene un correo de contacto configurado.');
        }

        Mail::to($destino)->send(new ContactoTienda($tienda, $datos));

        return back()->with('success', 'Tu mensaje fue enviado a la tienda.');
    }

    // ------------------------------------------------------------------
    // CARRITO (en sesión)
    // ------------------------------------------------------------------
    public function carrito()
    {
        $items = CarritoService::items();
        $total = $items->sum('subtotal');

        return view('web.carrito', compact('items', 'total'));
    }

    public function carritoAgregar(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer',
            'cantidad'    => 'required|integer|min:1|max:99',
        ], $this->mensajes(), $this->atributos());

        // visibles(): un producto inactivo o de tienda desactivada no se puede agregar
        $producto = Producto::visibles()->find($request->id_producto);

        if (!$producto) {
            return back()->with('error', 'Ese producto ya no está disponible.');
        }

        $carrito = session('carrito', []);
        $actual = $carrito[$producto->id_producto] ?? 0;
        $carrito[$producto->id_producto] = min(99, $actual + (int) $request->cantidad);
        session(['carrito' => $carrito]);

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function carritoActualizar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:99',
        ], $this->mensajes(), $this->atributos());

        $carrito = session('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id] = (int) $request->cantidad;
            session(['carrito' => $carrito]);
        }

        return redirect()->route('carrito');
    }

    public function carritoEliminar($id)
    {
        $carrito = session('carrito', []);
        unset($carrito[$id]);
        session(['carrito' => $carrito]);

        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito.');
    }

    // ------------------------------------------------------------------
    // FINALIZAR PEDIDO
    // ------------------------------------------------------------------
    public function finalizar()
    {
        $items = CarritoService::items();

        if ($items->isEmpty()) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío.');
        }

        $total = $items->sum('subtotal');

        return view('web.finalizar', compact('items', 'total'));
    }

    public function pedidoGuardar(Request $request)
    {
        $datos = $request->validate([
            'cliente'  => 'required|string|max:100',
            'correo'   => 'required|email|max:100',
            'telefono' => 'nullable|string|max:20',
        ], $this->mensajes(), $this->atributos());

        $items = CarritoService::items();

        if ($items->isEmpty()) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío.');
        }

        // Transacción: o se guarda todo el pedido, o no se guarda nada
        $pedido = DB::transaction(function () use ($datos, $items) {
            $pedido = Pedido::create([
                'fecha'    => now(),
                'cliente'  => $datos['cliente'],
                'correo'   => $datos['correo'],
                'telefono' => $datos['telefono'] ?? null,
                'total'    => $items->sum('subtotal'),
                'estado'   => 'En preparación',
            ]);

            foreach ($items as $item) {
                $p = $item['producto'];

                $pedido->detalles()->create([
                    'id_producto'     => $p->id_producto,
                    'id_tienda'       => $p->id_tienda,
                    'nombre_producto' => $p->nombre,        // copia (snapshot)
                    'nombre_tienda'   => $p->tienda->nombre, // copia (snapshot)
                    'precio'          => $p->precio,         // copia (snapshot)
                    'cantidad'        => $item['cantidad'],
                    'subtotal'        => $item['subtotal'],
                    'estado'          => 'En espera',
                ]);
            }

            return $pedido;
        });

        session()->forget('carrito');

        // El pedido ya está guardado: si el correo falla, no se pierde el pedido
        try {
            Mail::to($pedido->correo)->send(new PedidoConfirmado($pedido->load('detalles')));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('home')
            ->with('success', "¡Pedido #{$pedido->id_pedido} registrado! Te enviamos la confirmación por correo.");
    }

    // ------------------------------------------------------------------
    // Mensajes de validación en español
    // ------------------------------------------------------------------
    private function mensajes(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email'    => 'El campo :attribute debe ser un correo válido.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'min.numeric' => 'El campo :attribute debe ser al menos :min.',
            'max.numeric' => 'El campo :attribute no puede ser mayor que :max.',
            'max.string'  => 'El campo :attribute no puede tener más de :max caracteres.',
        ];
    }

    private function atributos(): array
    {
        return [
            'nombre'   => 'nombre',
            'correo'   => 'correo electrónico',
            'mensaje'  => 'mensaje',
            'cliente'  => 'nombre completo',
            'telefono' => 'teléfono',
            'cantidad' => 'cantidad',
        ];
    }
}
