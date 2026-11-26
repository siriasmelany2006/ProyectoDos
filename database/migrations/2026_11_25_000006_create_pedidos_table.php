<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->dateTime('fecha');
            $table->string('cliente', 100);
            $table->string('correo', 100);
            $table->string('telefono', 20)->nullable();
            $table->decimal('total', 12, 2);
            $table->string('estado', 20)->default('En preparación'); // En preparación | Listo | Entregado
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
