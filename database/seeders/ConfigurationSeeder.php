<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create([
            'logo' => 'ruta/al/logo.png',
            'user_image' => 'ruta/a/la/imagen_del_usuario.png',
            'file_id' => 1 // Asegúrate de que el archivo con ID 1 existe en la tabla files
        ]);
    }
}
