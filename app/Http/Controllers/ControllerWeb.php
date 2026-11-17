<?php

namespace App\Http\Controllers;

class ControllerWeb extends Controller
{
    // Página de inicio
    public function inicio()
    {
        return view('web.inicio');
    }

    // Lista de productos
    public function productos()
    {
        return view('web.productos.index');
    }

    // Detalle de un producto ($id todavía no se usa)
    public function productoDetalle($id)
    {
        return view('web.productos.show');
    }

    // Lista de tiendas
    public function tiendas()
    {
        return view('web.tiendas.index');
    }

    // Detalle de una tienda
    public function tiendaDetalle($id)
    {
        return view('web.tiendas.show');
    }

    // Carrito de compras
    public function carrito()
    {
        return view('web.carrito');
    }

    // Finalizar pedido
    public function finalizar()
    {
        return view('web.finalizar');
    }
}