<?php

use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerTienda;
use App\Http\Controllers\ControllerWeb;
use Illuminate\Support\Facades\Route;

// SITIO PÚBLICO
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

// PANEL DEL ADMINISTRADOR (todas sus rutas empiezan con /admin)
Route::prefix('admin')->name('admin.')->group(function () {
    // La primera pantalla del panel es el listado de pedidos
    Route::redirect('/', '/admin/pedidos');
    Route::get('/pedidos', [ControllerAdmin::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ControllerAdmin::class, 'pedidoDetalle'])->name('pedidos.show');
    Route::get('/tiendas', [ControllerAdmin::class, 'tiendas'])->name('tiendas.index');
});

// PANEL DE LA TIENDA (todas sus rutas empiezan con /tienda)
Route::prefix('tienda')->name('tienda.')->group(function () {
    Route::redirect('/', '/tienda/mi-tienda');
    Route::get('/mi-tienda', [ControllerTienda::class, 'miTienda'])->name('mi-tienda');
    Route::get('/productos', [ControllerTienda::class, 'productos'])->name('productos.index');
    Route::get('/productos/crear', [ControllerTienda::class, 'productoCrear'])->name('productos.crear');
    Route::get('/productos/{id}/editar', [ControllerTienda::class, 'productoEditar'])->name('productos.editar');
    Route::get('/pedidos', [ControllerTienda::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ControllerTienda::class, 'pedidoDetalle'])->name('pedidos.show');
});