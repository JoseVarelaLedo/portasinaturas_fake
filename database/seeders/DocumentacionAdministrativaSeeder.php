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
            ->get(['id', 'estado_solicitude'])
            ->each(function (Solicitude $solicitude): void {
                $factory = DocumentacionAdministrativa::factory();

                if ($solicitude->estado_solicitude?->value === 'aprobada') {
                    $factory = $factory->aprobada();
                }

                $factory->create([
                    'solicitude_id' => $solicitude->id,
                ]);
            });
    }
}
