<?php

namespace Database\Factories;

use App\Enums\EstadoDocumento;
use App\Models\DocumentacionTecnica;
use App\Models\Solicitude;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentacionTecnica>
 */
class DocumentacionTecnicaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<DocumentacionTecnica>
     */
    protected $model = DocumentacionTecnica::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estado = fn () => fake()->randomElement(EstadoDocumento::cases())->value;

        return [
            'solicitude_id' => Solicitude::factory(),
            'estado_memoria_tecnica' => $estado(),
            'estado_presupuesto' => $estado(),
            'estado_ofertas_proveedores' => $estado(),
            'estado_planos' => $estado(),
            'estado_estudio_energetico' => $estado(),
            'estado_fichas_tecnicas' => $estado(),
            'estado_licencias' => $estado(),
            'estado_cronograma' => $estado(),
        ];
    }

    public function aprobada(): static
    {
        $estadosPermitidos = [
            EstadoDocumento::APORTADO,
            EstadoDocumento::VALIDADO,
            EstadoDocumento::NON_PROCEDE,
            EstadoDocumento::EMENDADO,
        ];
        $estado = fn () => fake()->randomElement($estadosPermitidos)->value;

        return $this->state(fn (array $attributes) => [
            'estado_memoria_tecnica' => $estado(),
            'estado_presupuesto' => $estado(),
            'estado_ofertas_proveedores' => $estado(),
            'estado_planos' => $estado(),
            'estado_estudio_energetico' => $estado(),
            'estado_fichas_tecnicas' => $estado(),
            'estado_licencias' => $estado(),
            'estado_cronograma' => $estado(),
        ]);
    }
}
