<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id('id_imagen');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->cascadeOnDelete();
            $table->string('imagen');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
