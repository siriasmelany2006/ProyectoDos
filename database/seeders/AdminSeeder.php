<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    // CAMBIA ESTE CORREO por tu Gmail real: el inicio de sesión con Google
    // reconoce al administrador por su correo.
    private const CORREO_ADMIN = 'judithsirias2006@gmail.com';

    public function run(): void
    {
        // El administrador se registra de forma manual y no tiene tienda.
        User::firstOrCreate(
            ['correo' => self::CORREO_ADMIN],
            ['nombre' => 'Administrador', 'rol' => 'admin']
        );
    }
}
