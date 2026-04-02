<?php

namespace Database\Factories;

use App\Models\Solicitante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Solicitante>
 */
class SolicitanteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Solicitante>
     */
    protected $model = Solicitante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email'         => fake()->email(),
            'telefono' => fake()->numerify(
                fake()->randomElement(['6########', '7########', '9########'])
            ),
            'direccion'     => fake()->streetAddress(),
            'cidade'        => fake()->city(),
            'provincia'     => fake()->state(),
            'codigo_postal' => fake()->numerify('#####'),
            'pais'          => fake()->country(),
            'nif_cif'       => fake()->boolean(75) ? $this->generateValidNif() : $this->generateValidCif(),
        ];
    }

    private function generateValidNif(): string
    {
        $number = (string) fake()->numberBetween(10000000, 99999999);
        $letter = 'TRWAGMYFPDXBNJZSQVHLCKE'[(int) $number % 23];

        return $number . $letter;
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
