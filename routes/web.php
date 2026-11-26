<?php

use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerTienda;
use App\Http\Controllers\ControllerWeb;
use Illuminate\Support\Facades\Route;


Route::get('/', [ControllerWeb::class, 'inicio'])->name('home');
Route::get('/productos', [ControllerWeb::class, 'productos'])->name('productos.index');
Route::get('/productos/{id}', [ControllerWeb::class, 'productoDetalle'])->name('productos.show');
Route::get('/tiendas', [ControllerWeb::class, 'tiendas'])->name('tiendas.index');
Route::get('/tiendas/{id}', [ControllerWeb::class, 'tiendaDetalle'])->name('tiendas.show');
Route::get('/carrito', [ControllerWeb::class, 'carrito'])->name('carrito');
Route::get('/finalizar', [ControllerWeb::class, 'finalizar'])->name('finalizar');


Route::prefix('admin')->name('admin.')->group(function () {
    // La primera pantalla del panel es el listado de pedidos
    Route::redirect('/', '/admin/pedidos');
    Route::get('/pedidos', [ControllerAdmin::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ControllerAdmin::class, 'pedidoDetalle'])->name('pedidos.show');
    Route::get('/tiendas', [ControllerAdmin::class, 'tiendas'])->name('tiendas.index');
});


Route::prefix('tienda')->name('tienda.')->group(function () {
    Route::redirect('/', '/tienda/mi-tienda');
    Route::get('/mi-tienda', [ControllerTienda::class, 'miTienda'])->name('mi-tienda');
    Route::get('/productos', [ControllerTienda::class, 'productos'])->name('productos.index');
    Route::get('/productos/crear', [ControllerTienda::class, 'productoCrear'])->name('productos.crear');
    Route::get('/productos/{id}/editar', [ControllerTienda::class, 'productoEditar'])->name('productos.editar');
    Route::get('/pedidos', [ControllerTienda::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [ControllerTienda::class, 'pedidoDetalle'])->name('pedidos.show');
});