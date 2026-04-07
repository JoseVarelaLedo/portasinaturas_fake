<?php

namespace Database\Factories;

use App\Models\Entidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntidadeFactory extends Factory
{
    protected $model = Entidade::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->company(),
            'cif' => $this->generateValidCif(),
        ];
    }

    private function generateValidCif(): string
    {
        $initial = fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'N', 'P', 'Q', 'R', 'S', 'U', 'V', 'W']);
        $digits = str_pad((string) fake()->numberBetween(0, 9999999), 7, '0', STR_PAD_LEFT);

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
            $control = $controlLetter;
        } elseif (in_array($initial, ['A', 'B', 'E', 'H'], true)) {
            $control = (string) $controlDigit;
        } else {
            $control = fake()->boolean() ? (string) $controlDigit : $controlLetter;
        }

        return $initial . $digits . $control;
    }
}
