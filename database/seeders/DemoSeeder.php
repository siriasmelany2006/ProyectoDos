<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Tienda;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Datos de prueba que pide el PDF:
 *  - 5 tiendas (3 destacadas), 15 productos en distintas categorías
 *  - 6 pedidos: 3 Entregado, 1 Listo y 2 En preparación
 *  - 3 pedidos mezclan productos de distintas tiendas
 *  - 1 producto inactivo que aparece en un pedido
 *
 * Las imágenes viven en storage/app/public/demo (se ven tras `php artisan storage:link`).
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Categoria::pluck('id_categoria', 'nombre');

        // ------------------------------------------------------------------
        // TIENDAS Y PRODUCTOS
        // El orden de los productos define su imagen: demo/prod-01.svg, 02, ...
        // ------------------------------------------------------------------
        $tiendas = [
            [
                'slug' => 'verde',
                'dueno' => ['nombre' => 'Laura Mora', 'correo' => 'laura.mora@crickostore.test'],
                'nombre' => 'Tienda Verde',
                'descripcion' => 'Artículos para el hogar y productos locales hechos con cariño en el Caribe sur.',
                'whatsapp' => '8888-1001',
                'telefono' => '2750-1001',
                'correo' => 'contacto@tiendaverde.test',
                'instagram' => '@tiendaverde',
                'facebook' => 'tiendaverde',
                'youtube' => 'https://youtube.com/@tiendaverde',
                'destacada' => true,
                'productos' => [
                    ['Set de macetas de barro', 'Tres macetas de barro cocido con plato, ideales para hierbas y suculentas.', 12500, ['Hogar'], true],
                    ['Café molido artesanal 500 g', 'Café de altura tostado en pequeños lotes, molido para filtro o greca.', 6800, ['Alimentos'], true],
                    ['Lámpara de mesa', 'Lámpara con base de madera y pantalla de tela, luz cálida.', 18900, ['Hogar'], true],
                ],
            ],
            [
                'slug' => 'tech',
                'dueno' => ['nombre' => 'Andrés Quirós', 'correo' => 'andres.quiros@crickostore.test'],
                'nombre' => 'Mundo Tech',
                'descripcion' => 'Tecnología y accesorios para el día a día, con garantía de tienda.',
                'whatsapp' => '8888-1002',
                'telefono' => '2750-1002',
                'correo' => 'ventas@mundotech.test',
                'instagram' => '@mundotechcr',
                'facebook' => 'mundotechcr',
                'youtube' => 'https://youtube.com/@mundotechcr',
                'destacada' => true,
                'productos' => [
                    ['Audífonos inalámbricos', 'Audífonos Bluetooth con estuche de carga y hasta 20 horas de batería.', 24900, ['Tecnología', 'Deportes'], true],
                    ['Cargador portátil 10 000 mAh', 'Batería externa compacta con dos puertos USB y carga rápida.', 14500, ['Tecnología'], true],
                    ['Teclado mecánico compacto', 'Teclado 65 % con switches táctiles e iluminación blanca.', 32000, ['Tecnología'], true],
                ],
            ],
            [
                'slug' => 'moda',
                'dueno' => ['nombre' => 'Daniela Soto', 'correo' => 'daniela.soto@crickostore.test'],
                'nombre' => 'Moda Express',
                'descripcion' => 'Ropa, accesorios y cuidado personal con estilo costarricense.',
                'whatsapp' => '8888-1003',
                'telefono' => '2750-1003',
                'correo' => 'hola@modaexpress.test',
                'instagram' => '@modaexpresscr',
                'facebook' => 'modaexpresscr',
                'youtube' => null,
                'destacada' => true,
                'productos' => [
                    ['Camiseta de algodón', 'Camiseta unisex de algodón peinado, disponible en varios colores.', 9500, ['Moda'], true],
                    ['Bolso de tela', 'Bolso resistente de lona con bolsillo interior y cierre.', 11000, ['Moda'], true],
                    ['Kit de cuidado facial', 'Limpiador, tónico y crema hidratante en presentación de viaje.', 15800, ['Belleza'], true],
                ],
            ],
            [
                'slug' => 'deportes',
                'dueno' => ['nombre' => 'Marco Jiménez', 'correo' => 'marco.jimenez@crickostore.test'],
                'nombre' => 'Deportes CR',
                'descripcion' => 'Todo para entrenar, jugar y mantenerte en movimiento.',
                'whatsapp' => '8888-1004',
                'telefono' => '2750-1004',
                'correo' => 'info@deportescr.test',
                'instagram' => '@deportescr',
                'facebook' => 'deportescr',
                'youtube' => 'https://youtube.com/@deportescr',
                'destacada' => false,
                'productos' => [
                    ['Balón de fútbol N.º 5', 'Balón cosido a máquina, tamaño oficial, apto para césped y cemento.', 13500, ['Deportes'], true],
                    ['Mancuernas ajustables', 'Par de mancuernas con discos intercambiables de 2 a 10 kg.', 27000, ['Deportes'], true],
                    ['Botella deportiva 750 ml', 'Botella libre de BPA con tapa antiderrames.', 5900, ['Deportes', 'Hogar'], true],
                ],
            ],
            [
                'slug' => 'peques',
                'dueno' => ['nombre' => 'Sofía Araya', 'correo' => 'sofia.araya@crickostore.test'],
                'nombre' => 'Peques y Patas',
                'descripcion' => 'Juguetes para los más pequeños y accesorios para tus mascotas.',
                'whatsapp' => '8888-1005',
                'telefono' => '2750-1005',
                'correo' => 'hola@pequesypatas.test',
                'instagram' => '@pequesypatas',
                'facebook' => 'pequesypatas',
                'youtube' => null,
                'destacada' => false,
                'productos' => [
                    ['Rompecabezas de 100 piezas', 'Rompecabezas ilustrado de cartón reciclado, para mayores de 5 años.', 7500, ['Juguetes'], true],
                    ['Comedero para perro', 'Comedero de acero inoxidable con base antideslizante.', 6200, ['Mascotas', 'Hogar'], true],
                    // Producto INACTIVO: no se ve en el catálogo, pero sigue en el historial de pedidos.
                    ['Juego de bloques de madera', 'Set de 50 bloques de madera de colores.', 10900, ['Juguetes'], false],
                ],
            ],
        ];

        $productos = []; // nombre => modelo, para armar los pedidos
        $contador = 1;

        foreach ($tiendas as $t) {
            $dueno = User::create([
                'nombre' => $t['dueno']['nombre'],
                'correo' => $t['dueno']['correo'],
                'rol'    => 'tienda',
            ]);

            $tienda = Tienda::create([
                'id_usuario'  => $dueno->id_usuario,
                'nombre'      => $t['nombre'],
                'descripcion' => $t['descripcion'],
                'logo'        => "demo/logo-{$t['slug']}.svg",
                'banner'      => "demo/banner-{$t['slug']}.svg",
                'whatsapp'    => $t['whatsapp'],
                'telefono'    => $t['telefono'],
                'correo'      => $t['correo'],
                'instagram'   => $t['instagram'],
                'facebook'    => $t['facebook'],
                'youtube'     => $t['youtube'],
                'destacada'   => $t['destacada'],
                'activa'      => true,
            ]);

            foreach ($t['productos'] as [$nombre, $descripcion, $precio, $cats, $activo]) {
                $codigo = sprintf('prod-%02d', $contador++);

                $producto = Producto::create([
                    'id_tienda'   => $tienda->id_tienda,
                    'nombre'      => $nombre,
                    'descripcion' => $descripcion,
                    'precio'      => $precio,
                    'imagen'      => "demo/{$codigo}.svg",
                    'activo'      => $activo,
                ]);

                $producto->categorias()->attach(array_map(fn ($c) => $categorias[$c], $cats));

                // Galería: dos imágenes adicionales por producto
                foreach (['b', 'c'] as $sufijo) {
                    $producto->imagenes()->create(['imagen' => "demo/{$codigo}-{$sufijo}.svg"]);
                }

                $productos[$nombre] = $producto;
            }
        }

        // ------------------------------------------------------------------
        // PEDIDOS  [producto, cantidad, estado de la línea]
        // 'entregado' => true  : lo confirmó el administrador (no se modifica más)
        // 'entregado' => false : el estado se calcula según sus líneas
        // ------------------------------------------------------------------
        $pedidos = [
            [
                'cliente' => 'María López', 'correo' => 'maria.lopez@mail.test', 'telefono' => '8811-2233',
                'dias' => 14, 'entregado' => true,
                'items' => [
                    ['Audífonos inalámbricos', 1, 'Listo'],
                    ['Café molido artesanal 500 g', 2, 'Listo'],
                ],
            ],
            [
                'cliente' => 'Juan Pérez', 'correo' => 'juan.perez@mail.test', 'telefono' => '8822-3344',
                'dias' => 11, 'entregado' => true,
                'items' => [
                    ['Balón de fútbol N.º 5', 2, 'Listo'],
                    ['Camiseta de algodón', 1, 'Listo'],
                ],
            ],
            [
                'cliente' => 'Ana Vargas', 'correo' => 'ana.vargas@mail.test', 'telefono' => '8833-4455',
                'dias' => 8, 'entregado' => true,
                'items' => [
                    ['Audífonos inalámbricos', 1, 'Listo'],
                    ['Cargador portátil 10 000 mAh', 2, 'Listo'],
                ],
            ],
            [
                // Todas sus líneas están listas -> queda en estado "Listo"
                'cliente' => 'Luis Mora', 'correo' => 'luis.mora@mail.test', 'telefono' => '8844-5566',
                'dias' => 4, 'entregado' => false,
                'items' => [
                    ['Rompecabezas de 100 piezas', 1, 'Listo'],
                    ['Comedero para perro', 1, 'Listo'],
                ],
            ],
            [
                // Tres tiendas, incluye el producto inactivo -> "En preparación"
                'cliente' => 'Carla Rojas', 'correo' => 'carla.rojas@mail.test', 'telefono' => '8855-6677',
                'dias' => 2, 'entregado' => false,
                'items' => [
                    ['Lámpara de mesa', 1, 'Listo'],
                    ['Kit de cuidado facial', 1, 'En espera'],
                    ['Juego de bloques de madera', 1, 'En espera'],
                ],
            ],
            [
                'cliente' => 'Diego Solís', 'correo' => 'diego.solis@mail.test', 'telefono' => null,
                'dias' => 1, 'entregado' => false,
                'items' => [
                    ['Teclado mecánico compacto', 1, 'En espera'],
                ],
            ],
        ];

        foreach ($pedidos as $i => $p) {
            $lineas = [];
            $total = 0;

            foreach ($p['items'] as [$nombre, $cantidad, $estadoLinea]) {
                $producto = $productos[$nombre];
                $subtotal = $producto->precio * $cantidad;
                $total += $subtotal;

                $lineas[] = [
                    'id_producto'     => $producto->id_producto,
                    'id_tienda'       => $producto->id_tienda,
                    'nombre_producto' => $producto->nombre,
                    'nombre_tienda'   => $producto->tienda->nombre,
                    'precio'          => $producto->precio,
                    'cantidad'        => $cantidad,
                    'subtotal'        => $subtotal,
                    'estado'          => $estadoLinea,
                ];
            }

            $pedido = Pedido::create([
                'fecha'    => now()->subDays($p['dias'])->setTime(9 + $i, 15),
                'cliente'  => $p['cliente'],
                'correo'   => $p['correo'],
                'telefono' => $p['telefono'],
                'total'    => $total,
                'estado'   => $p['entregado'] ? 'Entregado' : 'En preparación',
            ]);

            foreach ($lineas as $linea) {
                $pedido->detalles()->create($linea);
            }

            if (!$p['entregado']) {
                $pedido->recalcularEstado();
            }
        }
    }
}
