<?php

namespace Database\Seeders;

use App\Models\DocumentacionTecnica;
use App\Models\Solicitude;
use Illuminate\Database\Seeder;

class DocumentacionTecnicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Solicitude::query()
            ->doesntHave('documentacionTecnica')
            ->get(['id'])
            ->each(function (Solicitude $solicitude): void {
                DocumentacionTecnica::factory()->create([
                    'solicitude_id' => $solicitude->id,
                ]);
            });
    }
}
