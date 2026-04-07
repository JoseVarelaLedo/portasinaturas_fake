<?php

namespace Database\Factories;

use App\Models\UsuarioAdministrativo;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioAdministrativoFactory extends Factory
{

    protected $model = UsuarioAdministrativo::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
        ];
    }
}
