<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = [
            'Tecnología',
            'Hogar',
            'Moda',
            'Belleza',
            'Deportes',
            'Juguetes',
            'Alimentos',
            'Mascotas',
        ];

        foreach ($nombres as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
