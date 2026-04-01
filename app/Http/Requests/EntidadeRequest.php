<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EntidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:100|min:5',
            'cif' => 'required|string|size:9|regex:/^[ABCDEFGHJNPQRSUVW]\d{7}[0-9A-J]$/i',
        ];
    }
}
