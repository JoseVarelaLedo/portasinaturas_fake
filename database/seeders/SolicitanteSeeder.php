<?php

namespace Database\Seeders;

use App\Models\Solicitante;
use Illuminate\Database\Seeder;

class SolicitanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Solicitante::factory()->count(150)->create();
    }
}
