<?php

namespace Database\Seeders;

use App\Models\Entidade;
use App\Models\Solicitante;
use App\Models\Solicitude;
use App\Models\UsuarioAdministrativo;
use App\Models\UsuarioTecnico;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class SolicitudeSeeder extends Seeder
{
    public function run(): void
    {
        $entidades = Entidade::query()->get(['id', 'nome']);
        $solicitantes = Solicitante::query()->get(['id', 'nome']);
        $usuariosAdministrativos = UsuarioAdministrativo::query()->pluck('id');
        $usuariosTecnicos = UsuarioTecnico::query()->pluck('id');

        if ($entidades->isEmpty() || $solicitantes->isEmpty()) {
            return;
        }

        foreach (range(1, 180) as $index) {
            $entidade = $this->pickByIndex($entidades, $index);
            $solicitante = $this->pickByIndex($solicitantes, $index * 3);

            Solicitude::factory()->create([
                'id_entidade' => $entidade->id,
                'id_solicitante' => $solicitante->id,
                'nome_entidade' => $entidade->nome,
                'nome_solicitante' => $solicitante->nome,
                'id_usuario_admin' => $usuariosAdministrativos->isNotEmpty() && fake()->boolean(70)
                    ? $usuariosAdministrativos->random()
                    : null,
                'id_usuario_tecnico' => $usuariosTecnicos->isNotEmpty() && fake()->boolean(60)
                    ? $usuariosTecnicos->random()
                    : null,
            ]);
        }
    }

    private function pickByIndex(Collection $items, int $index): object
    {
        return $items[($index - 1) % $items->count()];
    }
}
