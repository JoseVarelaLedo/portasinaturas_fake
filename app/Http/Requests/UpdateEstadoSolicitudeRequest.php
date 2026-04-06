<?php

namespace App\Http\Requests;

use App\Enums\EstadoSolicitude;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoSolicitudeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $valoresEstados = collect(EstadoSolicitude::cases())
            ->map(fn (EstadoSolicitude $estado) => $estado->value)
            ->all();

        return [
            'estado_solicitude' => ['required', 'in:' . implode(',', $valoresEstados)],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('estado_solicitude') === EstadoSolicitude::APROBADA->value) {
                $solicitude = $this->route('solicitude');

                if (!$solicitude->canBeApproved()) {
                    $camposProblematicos = $solicitude->getBlockingDocumentationFields();
                    $mensaje = 'No se puede aprobar la solicitud mientras haya documentación en estado de revisión, emendar, pendiente o rexeitada. ';
                    $mensaje .= 'Campos problemáticos: ' . implode(', ', $camposProblematicos) . '.';

                    $validator->errors()->add(
                        'estado_solicitude',
                        $mensaje
                    );
                }
            }
        });
    }
}
