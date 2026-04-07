<?php

namespace App\Http\Requests;

use App\Enums\EstadoDocumento;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSolicitudeDocumentacionRequest extends FormRequest
{
    private const CAMPOS_TECNICOS = [
        'estado_memoria_tecnica',
        'estado_presupuesto',
        'estado_ofertas_proveedores',
        'estado_planos',
        'estado_estudio_energetico',
        'estado_fichas_tecnicas',
        'estado_licencias',
        'estado_cronograma',
    ];

    private const CAMPOS_ADMINISTRATIVOS = [
        'estado_formulario_solicitud',
        'estado_documento_identificativo',
        'estado_acreditacion_representacion',
        'estado_certificado_aeat',
        'estado_certificado_seguridad_social',
        'estado_declaracion_responsable',
        'estado_datos_bancarios',
        'estado_escritura_constitucion',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $valoresEstados = collect(EstadoDocumento::cases())
            ->map(fn (EstadoDocumento $estado) => $estado->value)
            ->all();

        $rules = [];

        foreach (self::camposDocumentacion() as $campo) {
            $rules[$campo] = ['nullable', 'in:' . implode(',', $valoresEstados)];
        }

        $rules['motivos_emenda'] = ['nullable', 'array'];
        $rules['motivos_emenda.*'] = ['nullable', 'string', 'max:2000'];

        return $rules;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $input = $this->all();

            foreach (self::camposDocumentacion() as $campo) {
                if (($input[$campo] ?? null) !== EstadoDocumento::EMENDAR->value) {
                    continue;
                }

                $motivo = trim((string) data_get($input, 'motivos_emenda.' . $campo, ''));

                if ($motivo === '') {
                    $validator->errors()->add(
                        'motivos_emenda.' . $campo,
                        'Debes indicar o motivo da emenda para este campo.'
                    );
                }
            }
        });
    }

    public static function camposTecnicos(): array
    {
        return self::CAMPOS_TECNICOS;
    }
    public static function camposAdministrativos(): array
    {
        return self::CAMPOS_ADMINISTRATIVOS;
    }
    public static function camposDocumentacion(): array
    {
        return array_merge(self::CAMPOS_TECNICOS, self::CAMPOS_ADMINISTRATIVOS);
    }
}
