<?php

namespace Database\Factories;

use App\Enums\EstadoDocumento;
use App\Models\DocumentacionAdministrativa;
use App\Models\Solicitude;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentacionAdministrativa>
 */
class DocumentacionAdministrativaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<DocumentacionAdministrativa>
     */
    protected $model = DocumentacionAdministrativa::class;

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
            'estado_formulario_solicitud' => $estado(),
            'estado_documento_identificativo' => $estado(),
            'estado_acreditacion_representacion' => $estado(),
            'estado_certificado_aeat' => $estado(),
            'estado_certificado_seguridad_social' => $estado(),
            'estado_declaracion_responsable' => $estado(),
            'estado_datos_bancarios' => $estado(),
            'estado_escritura_constitucion' => $estado(),
        ];
    }
}
