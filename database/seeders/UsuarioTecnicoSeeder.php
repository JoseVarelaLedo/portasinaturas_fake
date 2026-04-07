<?php

namespace Database\Seeders;

use App\Models\UsuarioTecnico;
use Illuminate\Database\Seeder;

class UsuarioTecnicoSeeder extends Seeder
{

    public function run(): void
    {
        UsuarioTecnico::factory()->count(17)->create();
    }
}

