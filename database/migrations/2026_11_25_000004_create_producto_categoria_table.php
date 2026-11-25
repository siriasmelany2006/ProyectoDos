<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_categoria', function (Blueprint $table) {
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->cascadeOnDelete();
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->cascadeOnDelete();
            $table->primary(['id_producto', 'id_categoria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_categoria');
    }
};
