<?php

namespace App\Http\Requests;

use App\Enums\ProvinciaGalicia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:100|min:5',
            'email' => 'required|email:rfc,dns|max:150|unique:solicitantes,email',
            'telefono' => 'required|string|max:15|min:9',
            'direccion' => 'required|string|max:200',
            'cidade' => 'required|string|max:100',
            'provincia' => ['required', Rule::in(ProvinciaGalicia::values())],
            'codigo_postal' => 'required|string|size:5',
            'pais' => 'required|string|max:100',
            'nif_cif' => [
                'required',
                'string',
                'size:9',
                'unique:solicitantes,nif_cif',
                'regex:/^[A-Z0-9]{9}$/i',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (!is_string($value) || !$this->isValidNifOrCif($value)) {
                        $fail("O campo {$attribute} debe ser un NIF ou CIF valido.");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatorio.',
            'email.required' => 'O email é obrigatorio.',
            'email.email' => 'Introduce un email valido.',
            'email.unique' => 'Xa existe un solicitante con ese email.',
            'telefono.required' => 'O telefono é obrigatorio.',
            'direccion.required' => 'A direccion é obrigatoria.',
            'cidade.required' => 'A cidade é obrigatoria.',
            'provincia.required' => 'A provincia é obrigatoria.',
            'provincia.in' => 'A provincia debe ser unha das de Galicia.',
            'codigo_postal.required' => 'O codigo postal é obrigatorio.',
            'codigo_postal.size' => 'O codigo postal debe ter 5 caracteres.',
            'pais.required' => 'O pais é obrigatorio.',
            'nif_cif.required' => 'O NIF/CIF é obrigatorio.',
            'nif_cif.unique' => 'Xa existe un solicitante con ese NIF/CIF.',
        ];
    }

    private function isValidNifOrCif(string $value): bool
    {
        $normalized = strtoupper(trim($value));

        return $this->isValidNif($normalized) || $this->isValidCif($normalized);
    }

    private function isValidNif(string $value): bool
    {
        if (!preg_match('/^\d{8}[A-Z]$/', $value)) {
            return false;
        }

        $number = (int) substr($value, 0, 8);
        $letter = $value[8];
        $expected = 'TRWAGMYFPDXBNJZSQVHLCKE'[$number % 23];

        return $letter === $expected;
    }

    private function isValidCif(string $value): bool
    {
        $isValid = true;

        if (!preg_match('/^[ABCDEFGHJNPQRSUVW]\d{7}[0-9A-J]$/', $value)) {
            $isValid = false;
        } else {
            $initial = $value[0];
            $digits = substr($value, 1, 7);
            $control = $value[8];

            $sumEven = 0;
            $sumOdd = 0;

            for ($i = 0; $i < 7; $i++) {
                $digit = (int) $digits[$i];

                if ($i % 2 === 0) {
                    $product = $digit * 2;
                    $sumOdd += intdiv($product, 10) + ($product % 10);
                } else {
                    $sumEven += $digit;
                }
            }

            $total = $sumEven + $sumOdd;
            $controlDigit = (10 - ($total % 10)) % 10;
            $controlLetter = 'JABCDEFGHI'[$controlDigit];

            if (in_array($initial, ['P', 'Q', 'R', 'S', 'N', 'W'], true)) {
                $isValid = $control === $controlLetter;
            } elseif (in_array($initial, ['A', 'B', 'E', 'H'], true)) {
                $isValid = $control === (string) $controlDigit;
            } else {
                $isValid = $control === (string) $controlDigit || $control === $controlLetter;
            }
        }

        return $isValid;
    }
}
