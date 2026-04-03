<?php

namespace Database\Seeders;

use App\Models\DocumentacionAdministrativa;
use App\Models\Solicitude;
use Illuminate\Database\Seeder;

class DocumentacionAdministrativaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Solicitude::query()
            ->doesntHave('documentacionAdministrativa')
            ->get(['id'])
            ->each(function (Solicitude $solicitude): void {
                DocumentacionAdministrativa::factory()->create([
                    'solicitude_id' => $solicitude->id,
                ]);
            });
    }
}
