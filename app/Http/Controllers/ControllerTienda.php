<?php

namespace App\Http\Controllers;

class ControllerTienda extends Controller
{
    // Datos de la tienda
    public function miTienda()
    {
        return view('tienda.mi-tienda');
    }

    // Lista de productos de la tienda
    public function productos()
    {
        return view('tienda.productos.index');
    }

    // Formulario para crear un producto
    public function productoCrear()
    {
        return view('tienda.productos.form');
    }

    // Formulario para editar un producto (usa la misma vista que crear)
    public function productoEditar($id)
    {
        return view('tienda.productos.form');
    }

    // Pedidos que incluyen productos de la tienda
    public function pedidos()
    {
        return view('tienda.pedidos.index');
    }

    // Detalle de un pedido de la tienda
    public function pedidoDetalle($id)
    {
        return view('tienda.pedidos.show');
    }
}