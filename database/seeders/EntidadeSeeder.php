<?php

namespace Database\Seeders;

use App\Models\Entidade;
use Illuminate\Database\Seeder;

class EntidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Entidade::factory()->count(150)->create();
    }
}
