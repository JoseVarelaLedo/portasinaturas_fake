<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_entidade' => 'required|integer|exists:entidades,id',
            'id_solicitante' => 'required|integer|exists:solicitantes,id',
            'nome_entidade' => 'required|string|min:3|max:100',
            'nome_solicitante' => 'required|string|min:3|max:100',
            'enviado_sede' => 'nullable|boolean',
            'contia_reservada_c7' => 'nullable|numeric|min:0',
            'contia_reservada_c8' => 'nullable|numeric|min:0',
            'contia_reservada_c31' => 'nullable|numeric|min:0',
            'lista_espera' => 'nullable|boolean',
            'estado_doc' => 'nullable|string|max:120',
            'id_usuario_admin' => 'nullable|integer|exists:usuario_administrativos,id',
            'id_usuario_tecnico' => 'nullable|integer|exists:usuario_tecnicos,id',
        ];
    }
}
