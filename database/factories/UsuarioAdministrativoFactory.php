<?php

namespace Database\Factories;

use App\Models\UsuarioAdministrativo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UsuarioAdministrativo>
 */
class UsuarioAdministrativoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<UsuarioAdministrativo>
     */
    protected $model = UsuarioAdministrativo::class;

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
