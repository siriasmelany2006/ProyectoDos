<?php

namespace App\Http\Controllers;

class ControllerAdmin extends Controller
{
    // Lista de todos los pedidos
    public function pedidos()
    {
        return view('admin.pedidos.index');
    }

    // Detalle de un pedido
    public function pedidoDetalle($id)
    {
        return view('admin.pedidos.show');
    }

    // Lista de tiendas
    public function tiendas()
    {
        return view('admin.tiendas.index');
    }
}