<?php

namespace Database\Factories;

use App\Models\Entidade;
use App\Models\Solicitante;
use App\Models\Solicitude;
use App\Models\UsuarioAdministrativo;
use App\Models\UsuarioTecnico;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudeFactory extends Factory
{

    protected $model = Solicitude::class;

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
                'presentada',
                'en_proceso',
                'desistida',
                'denegada',
                'emendar',
            ]),
            'id_usuario_admin' => fake()->boolean(70) ? UsuarioAdministrativo::factory() : null,
            'id_usuario_tecnico' => fake()->boolean(60) ? UsuarioTecnico::factory() : null,
        ];
    }

    public function aprobada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado_solicitude' => 'aprobada',
        ]);
    }
}
