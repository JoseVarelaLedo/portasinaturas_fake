<?php

namespace Database\Seeders;

use App\Models\UsuarioAdministrativo;
use Illuminate\Database\Seeder;

class UsuarioAdministrativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsuarioAdministrativo::factory()->count(12)->create();
    }
}

