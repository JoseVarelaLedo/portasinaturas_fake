<?php

namespace Database\Seeders;

use App\Models\Entidade;
use Illuminate\Database\Seeder;

class EntidadeSeeder extends Seeder
{
    public function run(): void
    {
        Entidade::factory()->count(150)->create();
    }
}
