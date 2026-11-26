<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->cascadeOnDelete();
            // restrictOnDelete: un producto o tienda con pedidos no se puede borrar
            // (se desactiva), así el historial siempre se conserva.
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->restrictOnDelete();
            $table->foreignId('id_tienda')->constrained('tiendas', 'id_tienda')->restrictOnDelete();
            $table->string('nombre_producto');
            $table->string('nombre_tienda');
            $table->decimal('precio', 12, 2);
            $table->unsignedInteger('cantidad');
            $table->decimal('subtotal', 12, 2);
            $table->string('estado', 20)->default('En espera'); // En espera | Listo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
