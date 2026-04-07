<?php

namespace Database\Seeders;

use App\Models\UsuarioAdministrativo;
use Illuminate\Database\Seeder;

class UsuarioAdministrativoSeeder extends Seeder
{
    public function run(): void
    {
        UsuarioAdministrativo::factory()->count(12)->create();
    }
}

