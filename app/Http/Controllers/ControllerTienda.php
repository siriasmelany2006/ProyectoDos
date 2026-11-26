<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Detalle;
use App\Models\Imagen;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ControllerTienda extends Controller
{
    // ------------------------------------------------------------------
    // AYUDAS
    // ------------------------------------------------------------------

    // La tienda del usuario que inició sesión
    private function tiendaActual()
    {
        $tienda = Auth::user()->tienda;

        if (!$tienda) {
            abort(404, 'No tienes una tienda asociada.');
        }

        return $tienda;
    }

    // Busca un producto SOLO dentro de mi tienda (si es de otra tienda, da 404)
    private function productoPropio($id): Producto
    {
        return $this->tiendaActual()->productos()->findOrFail($id);
    }

    // ------------------------------------------------------------------
    // MI TIENDA
    // ------------------------------------------------------------------

    // Muestra los datos de la tienda del usuario que inició sesión
    public function miTienda()
    {
        $tienda = $this->tiendaActual();

        return view('tienda.mi-tienda', compact('tienda'));
    }

    // Guarda los cambios de la tienda (datos, logo y banner)
    public function miTiendaActualizar(Request $request)
    {
        $tienda = $this->tiendaActual();

        $datos = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:1000',
            'whatsapp'    => 'nullable|string|max:30',
            'telefono'    => 'nullable|string|max:30',
            'correo'      => 'nullable|email|max:100',
            'instagram'   => 'nullable|string|max:255',
            'facebook'    => 'nullable|string|max:255',
            'youtube'     => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], $this->mensajes(), $this->atributos());

        // Los archivos no se guardan tal cual en la BD: se quitan y se tratan aparte
        unset($datos['logo'], $datos['banner']);

        // Si subió un logo nuevo: se borra el anterior y se guarda el nuevo en storage/app/public/logos
        if ($request->hasFile('logo')) {
            if ($tienda->logo) {
                Storage::disk('public')->delete($tienda->logo);
            }
            $datos['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Lo mismo con el banner (carpeta banners)
        if ($request->hasFile('banner')) {
            if ($tienda->banner) {
                Storage::disk('public')->delete($tienda->banner);
            }
            $datos['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $tienda->update($datos);

        return redirect()->route('tienda.mi-tienda')
            ->with('success', 'Los datos de tu tienda se guardaron correctamente.');
    }

    // ------------------------------------------------------------------
    // MIS PRODUCTOS
    // ------------------------------------------------------------------

    // Lista de productos de MI tienda (con buscador y paginación)
    public function productos(Request $request)
    {
        $productos = $this->tiendaActual()->productos()
            ->with('categorias')
            ->when($request->filled('q'), fn ($q) => $q->where('nombre', 'like', '%' . $request->q . '%'))
            ->orderByDesc('id_producto')
            ->paginate(10)
            ->withQueryString();

        return view('tienda.productos.index', compact('productos'));
    }

    // Formulario para crear un producto
    public function productoCrear()
    {
        $this->tiendaActual();

        $producto = null;
        $categorias = Categoria::orderBy('nombre')->get();

        return view('tienda.productos.form', compact('producto', 'categorias'));
    }

    // Guarda un producto nuevo (con su galería y categorías)
    public function productoGuardar(Request $request)
    {
        $tienda = $this->tiendaActual();

        $datos = $request->validate(
            $this->reglasProducto(true),
            $this->mensajes(),
            $this->atributos()
        );

        // La galería permite hasta 4 imágenes adicionales
        $galeria = array_filter($request->file('galeria', []));

        DB::transaction(function () use ($request, $tienda, $datos, $galeria) {
            $producto = $tienda->productos()->create([
                'nombre'      => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'precio'      => $datos['precio'],
                'imagen'      => $request->file('imagen')->store('productos', 'public'),
                'activo'      => true,
            ]);

            // Una o varias categorías (tabla producto_categoria)
            $producto->categorias()->sync($datos['categorias']);

            foreach ($galeria as $archivo) {
                $producto->imagenes()->create([
                    'imagen' => $archivo->store('galerias', 'public'),
                ]);
            }
        });

        return redirect()->route('tienda.productos.index')
            ->with('success', 'El producto se registró correctamente.');
    }

    // Formulario para editar un producto (usa la misma vista que crear)
    public function productoEditar($id)
    {
        $producto = $this->productoPropio($id);
        $producto->load(['categorias', 'imagenes']);
        $categorias = Categoria::orderBy('nombre')->get();

        return view('tienda.productos.form', compact('producto', 'categorias'));
    }

    // Guarda los cambios de un producto
    public function productoActualizar(Request $request, $id)
    {
        $producto = $this->productoPropio($id);

        $datos = $request->validate(
            $this->reglasProducto(false),
            $this->mensajes(),
            $this->atributos()
        );

        // Revisa que entre las imágenes actuales y las nuevas no pasen de 4
        $galeria = array_filter($request->file('galeria', []));

        if ($producto->imagenes()->count() + count($galeria) > 4) {
            return back()->withInput()
                ->with('error', 'La galería solo puede tener hasta 4 imágenes adicionales. Quita alguna antes de agregar más.');
        }

        DB::transaction(function () use ($request, $producto, $datos, $galeria) {
            $cambios = [
                'nombre'      => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'precio'      => $datos['precio'],
            ];

            // Si subió una imagen principal nueva: se borra la anterior
            if ($request->hasFile('imagen')) {
                if ($producto->imagen) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $cambios['imagen'] = $request->file('imagen')->store('productos', 'public');
            }

            $producto->update($cambios);
            $producto->categorias()->sync($datos['categorias']);

            foreach ($galeria as $archivo) {
                $producto->imagenes()->create([
                    'imagen' => $archivo->store('galerias', 'public'),
                ]);
            }
        });

        return redirect()->route('tienda.productos.index')
            ->with('success', 'El producto se actualizó correctamente.');
    }

    // Activar / desactivar un producto (no se borra: solo cambia el estado)
    public function productoActivo($id)
    {
        $producto = $this->productoPropio($id);
        $producto->update(['activo' => !$producto->activo]);

        $mensaje = $producto->activo
            ? "El producto {$producto->nombre} fue activado."
            : "El producto {$producto->nombre} fue desactivado y ya no se ve en el sitio público.";

        return back()->with('success', $mensaje);
    }

    // Quitar una imagen de la galería (solo si el producto es de mi tienda)
    public function imagenQuitar($id)
    {
        $imagen = Imagen::whereHas('producto', function ($q) {
            $q->where('id_tienda', $this->tiendaActual()->id_tienda);
        })->findOrFail($id);

        Storage::disk('public')->delete($imagen->imagen);
        $imagen->delete();

        return back()->with('success', 'La imagen se quitó de la galería.');
    }

    // ------------------------------------------------------------------
    // MIS PEDIDOS
    // ------------------------------------------------------------------

    // Pedidos que incluyen al menos un producto de MI tienda
    public function pedidos(Request $request)
    {
        $idTienda = $this->tiendaActual()->id_tienda;

        $pedidos = Pedido::query()
            ->whereHas('detalles', fn ($d) => $d->where('id_tienda', $idTienda))
            // Suma de MIS productos y cuántos de ellos siguen "En espera"
            ->withSum(['detalles as mi_total' => fn ($d) => $d->where('id_tienda', $idTienda)], 'subtotal')
            ->withCount(['detalles as mis_pendientes' => fn ($d) => $d->where('id_tienda', $idTienda)->where('estado', 'En espera')])
            ->when($request->filled('q'), function ($query) use ($request) {
                $texto = trim($request->q);
                $numero = ltrim($texto, '#');

                $query->where(function ($w) use ($texto, $numero) {
                    $w->where('cliente', 'like', "%{$texto}%")
                      ->orWhere('correo', 'like', "%{$texto}%");

                    if (ctype_digit($numero)) {
                        $w->orWhere('id_pedido', $numero);
                    }
                });
            })
            ->orderByDesc('id_pedido')
            ->paginate(10)
            ->withQueryString();

        return view('tienda.pedidos.index', compact('pedidos'));
    }

    // Detalle de un pedido: solo se muestran MIS productos
    public function pedidoDetalle($id)
    {
        $idTienda = $this->tiendaActual()->id_tienda;

        // Si el pedido no tiene productos de mi tienda, da 404
        $pedido = Pedido::whereHas('detalles', fn ($d) => $d->where('id_tienda', $idTienda))
            ->findOrFail($id);

        $misDetalles = $pedido->detalles()->where('id_tienda', $idTienda)->get();
        $miTotal = $misDetalles->sum('subtotal');

        return view('tienda.pedidos.show', compact('pedido', 'misDetalles', 'miTotal'));
    }

    // Marcar UNO de mis productos del pedido como "Listo"
    public function productoListo($id)
    {
        $idTienda = $this->tiendaActual()->id_tienda;

        // Solo se encuentra si la línea es de mi tienda
        $detalle = Detalle::where('id_tienda', $idTienda)->findOrFail($id);
        $pedido = $detalle->pedido;

        // Un pedido entregado no se puede modificar
        if ($pedido->estado === 'Entregado') {
            return back()->with('error', 'Este pedido ya fue entregado y no se puede modificar.');
        }

        if ($detalle->estado === 'Listo') {
            return back()->with('error', 'Ese producto ya estaba marcado como listo.');
        }

        // Aunque el producto esté desactivado, se puede marcar como listo
        // (el detalle guarda su propia copia del nombre y el precio)
        DB::transaction(function () use ($detalle, $pedido) {
            $detalle->update(['estado' => 'Listo']);

            // Si ya todos los productos del pedido están listos, el pedido pasa a "Listo"
            $pedido->recalcularEstado();
        });

        return back()->with('success', "El producto {$detalle->nombre_producto} se marcó como listo.");
    }

    // ------------------------------------------------------------------
    // Validaciones
    // ------------------------------------------------------------------

    // Reglas del formulario de producto (al crear la imagen principal es obligatoria)
    private function reglasProducto(bool $crear): array
    {
        return [
            'nombre'        => 'required|string|max:150',
            'descripcion'   => 'nullable|string|max:2000',
            'precio'        => 'required|numeric|min:1|max:99999999',
            'imagen'        => ($crear ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
            'galeria'       => 'nullable|array|max:4',
            'galeria.*'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categorias'    => 'required|array|min:1',
            'categorias.*'  => 'exists:categorias,id_categoria',
        ];
    }

    private function mensajes(): array
    {
        return [
            'required'     => 'El campo :attribute es obligatorio.',
            'email'        => 'El campo :attribute debe ser un correo válido.',
            'numeric'      => 'El campo :attribute debe ser un número.',
            'image'        => 'El archivo de :attribute debe ser una imagen.',
            'mimes'        => 'El archivo de :attribute debe ser JPG, PNG o WEBP.',
            'exists'       => 'La :attribute seleccionada no es válida.',
            'min.numeric'  => 'El campo :attribute debe ser al menos :min.',
            'max.numeric'  => 'El campo :attribute no puede ser mayor que :max.',
            'min.array'    => 'Debes seleccionar al menos una :attribute.',
            'max.array'    => 'Solo puedes subir hasta :max imágenes en la galería.',
            'max.file'     => 'La imagen de :attribute no puede pesar más de :max KB.',
            'max.string'   => 'El campo :attribute no puede tener más de :max caracteres.',
        ];
    }

    private function atributos(): array
    {
        return [
            'nombre'       => 'nombre',
            'descripcion'  => 'descripción',
            'precio'       => 'precio',
            'imagen'       => 'imagen principal',
            'galeria'      => 'galería',
            'galeria.*'    => 'galería',
            'categorias'   => 'categoría',
            'categorias.*' => 'categoría',
            'whatsapp'     => 'WhatsApp',
            'telefono'     => 'teléfono',
            'correo'       => 'correo electrónico',
            'instagram'    => 'Instagram',
            'facebook'     => 'Facebook',
            'youtube'      => 'YouTube',
            'logo'         => 'logo',
            'banner'       => 'banner',
        ];
    }
}