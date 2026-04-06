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
            ->get(['id', 'estado_solicitude'])
            ->each(function (Solicitude $solicitude): void {
                $factory = DocumentacionTecnica::factory();

                if ($solicitude->estado_solicitude?->value === 'aprobada') {
                    $factory = $factory->aprobada();
                }

                $factory->create([
                    'solicitude_id' => $solicitude->id,
                ]);
            });
    }
}
