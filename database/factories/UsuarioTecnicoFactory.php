<?php

namespace Database\Factories;

use App\Models\UsuarioTecnico;
use Illuminate\Database\Eloquent\Factories\Factory;


class UsuarioTecnicoFactory extends Factory
{
    protected $model = UsuarioTecnico::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
        ];
    }
}
