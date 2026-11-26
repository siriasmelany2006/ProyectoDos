<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Reemplaza la migración por defecto de Laravel (tabla "users").
// Crea "usuarios" según el PDF y la tabla "sessions" que usa Laravel.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('google_id')->nullable()->unique();
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->text('foto')->nullable(); // la URL de la foto de Google puede ser muy larga
            $table->string('rol', 20)->default('tienda'); // 'admin' | 'tienda'
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('usuarios');
    }
};  