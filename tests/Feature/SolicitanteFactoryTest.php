<?php

namespace Tests\Feature;

use App\Models\Solicitante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolicitanteFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_solicitantes_with_email(): void
    {
        $solicitantes = Solicitante::factory()->count(25)->create();

        foreach ($solicitantes as $solicitante) {
            $this->assertNotNull($solicitante->email);
            $this->assertNotSame('', trim((string) $solicitante->email));
            $this->assertMatchesRegularExpression('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', (string) $solicitante->email);
        }
    }

    public function test_factory_creates_unique_emails_for_solicitantes(): void
    {
        $solicitantes = Solicitante::factory()->count(50)->create();

        $emails = $solicitantes
            ->pluck('email')
            ->filter(fn ($email) => is_string($email) && $email !== '')
            ->values();

        $this->assertCount(50, $emails);
        $this->assertCount(50, $emails->unique());
    }
}
