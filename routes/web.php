<?php

use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerAuth;
use App\Http\Controllers\ControllerTienda;
use App\Http\Controllers\ControllerWeb;
use Illuminate\Support\Facades\Route;


Route::get('/', [ControllerWeb::class, 'inicio'])->name('home');
Route::get('/productos', [ControllerWeb::class, 'productos'])->name('productos.index');
Route::get('/productos/{id}', [ControllerWeb::class, 'productoDetalle'])->name('productos.show');
Route::get('/tiendas', [ControllerWeb::class, 'tiendas'])->name('tiendas.index');
Route::get('/tiendas/{id}', [ControllerWeb::class, 'tiendaDetalle'])->name('tiendas.show');
Route::post('/tiendas/{id}/contacto', [ControllerWeb::class, 'contactoTienda'])->name('tiendas.contacto');

// Carrito (en sesión)
Route::get('/carrito', [ControllerWeb::class, 'carrito'])->name('carrito');
Route::post('/carrito', [ControllerWeb::class, 'carritoAgregar'])->name('carrito.agregar');
Route::patch('/carrito/{id}', [ControllerWeb::class, 'carritoActualizar'])->name('carrito.actualizar');
Route::delete('/carrito/{id}', [ControllerWeb::class, 'carritoEliminar'])->name('carrito.eliminar');

// Finalizar pedido
Route::get('/finalizar', [ControllerWeb::class, 'finalizar'])->name('finalizar');
Route::post('/finalizar', [ControllerWeb::class, 'pedidoGuardar'])->name('pedido.guardar');


// Login con Google
Route::get('/login', [ControllerAuth::class, 'login'])->name('login');
Route::get('/auth/google', [ControllerAuth::class, 'redirigirGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [ControllerAuth::class, 'callbackGoogle'])->name('auth.google.callback');
Route::post('/logout', [ControllerAuth::class, 'logout'])->name('logout');


// Panel del administrador (solo rol admin)
Route::prefix('admin')->name('admin.')->middleware('rol:admin')->group(function () {
    // La primera pantalla del panel es el listado de pedidos
    Route::redirect('/', '/admin/pedidos');
    Route::get('/pedidos', [ControllerAdmin::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ControllerAdmin::class, 'pedidoDetalle'])->name('pedidos.show');
    Route::post('/pedidos/{id}/entregar', [ControllerAdmin::class, 'confirmarEntrega'])->name('pedidos.entregar');
    Route::get('/tiendas', [ControllerAdmin::class, 'tiendas'])->name('tiendas.index');
    Route::patch('/tiendas/{id}/activa', [ControllerAdmin::class, 'tiendaActiva'])->name('tiendas.activa');
    Route::patch('/tiendas/{id}/destacada', [ControllerAdmin::class, 'tiendaDestacada'])->name('tiendas.destacada');
});


// Panel de la tienda (solo rol tienda)
Route::prefix('tienda')->name('tienda.')->middleware('rol:tienda')->group(function () {
    Route::redirect('/', '/tienda/mi-tienda');

    // Mi tienda
    Route::get('/mi-tienda', [ControllerTienda::class, 'miTienda'])->name('mi-tienda');
    Route::put('/mi-tienda', [ControllerTienda::class, 'miTiendaActualizar'])->name('mi-tienda.actualizar');

    // Mis productos
    Route::get('/productos', [ControllerTienda::class, 'productos'])->name('productos.index');
    Route::get('/productos/crear', [ControllerTienda::class, 'productoCrear'])->name('productos.crear');
    Route::post('/productos', [ControllerTienda::class, 'productoGuardar'])->name('productos.guardar');
    Route::get('/productos/{id}/editar', [ControllerTienda::class, 'productoEditar'])->name('productos.editar');
    Route::put('/productos/{id}', [ControllerTienda::class, 'productoActualizar'])->name('productos.actualizar');
    Route::patch('/productos/{id}/activo', [ControllerTienda::class, 'productoActivo'])->name('productos.activo');
    Route::delete('/productos/imagen/{id}', [ControllerTienda::class, 'imagenQuitar'])->name('productos.imagen.quitar');

    // Mis pedidos
    Route::get('/pedidos', [ControllerTienda::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ControllerTienda::class, 'pedidoDetalle'])->name('pedidos.show');
    Route::patch('/pedidos/detalle/{id}/listo', [ControllerTienda::class, 'productoListo'])->name('pedidos.listo');
});