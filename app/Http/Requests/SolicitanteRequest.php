<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'nif_cif' => [
                'required',
                'string',
                'size:9',
                'regex:/^[A-Z0-9]{9}$/i',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (!is_string($value) || !$this->isValidNifOrCif($value)) {
                        $fail("O campo {$attribute} debe ser un NIF ou CIF valido.");
                    }
                },
            ],
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
