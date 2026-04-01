<?php

namespace Database\Factories;

use App\Models\UsuarioTecnico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UsuarioTecnico>
 */
class UsuarioTecnicoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<UsuarioTecnico>
     */
    protected $model = UsuarioTecnico::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
        ];
    }
}
