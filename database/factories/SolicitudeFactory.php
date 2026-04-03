<?php

namespace Database\Factories;

use App\Models\Entidade;
use App\Models\Solicitante;
use App\Models\Solicitude;
use App\Models\UsuarioAdministrativo;
use App\Models\UsuarioTecnico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Solicitude>
 */
class SolicitudeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Solicitude>
     */
    protected $model = Solicitude::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_entidade' => Entidade::factory(),
            'id_solicitante' => Solicitante::factory(),
            'nome_entidade' => fn (array $attributes) => Entidade::query()
                ->find($attributes['id_entidade'])?->nome ?? fake()->company(),
            'nome_solicitante' => fn (array $attributes) => Solicitante::query()
                ->find($attributes['id_solicitante'])?->nome ?? fake()->name(),
            'enviado_sede' => fake()->boolean(),
            'contia_reservada_c7' => fake()->optional()->randomFloat(2, 0, 50000),
            'contia_reservada_c8' => fake()->optional()->randomFloat(2, 0, 50000),
            'contia_reservada_c31' => fake()->optional()->randomFloat(2, 0, 50000),
            'lista_espera' => fake()->boolean(25),
            'estado_solicitude' => fake()->randomElement([
                'pendiente',
                'en_revision',
                'subsanacion',
                'aprobada',
                'denegada',
            ]),
            'id_usuario_admin' => fake()->boolean(70) ? UsuarioAdministrativo::factory() : null,
            'id_usuario_tecnico' => fake()->boolean(60) ? UsuarioTecnico::factory() : null,
        ];
    }
}
