<?php

namespace Tests\Feature;

use App\Models\Emenda;
use App\Models\Entidade;
use App\Models\Remesa;
use App\Models\Solicitante;
use App\Models\Solicitude;
use App\Models\UsuarioAdministrativo;
use App\Models\UsuarioTecnico;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_relations_support_eager_loading_with_expected_foreign_keys(): void
    {
        $solicitante = Solicitante::create([
            'nome' => 'Solicitante Test',
            'nif_cif' => 'A12345678',
        ]);

        $entidade = Entidade::create([
            'nome' => 'Entidade Test',
            'cif' => 'B12345678',
        ]);

        $usuarioAdministrativo = UsuarioAdministrativo::create([
            'nome' => 'Admin Test',
        ]);

        $usuarioTecnico = UsuarioTecnico::create([
            'nome' => 'Tecnico Test',
        ]);

        $solicitude = Solicitude::create([
            'id_entidade' => $entidade->id,
            'id_solicitante' => $solicitante->id,
            'nome_entidade' => $entidade->nome,
            'nome_solicitante' => $solicitante->nome,
            'id_usuario_admin' => $usuarioAdministrativo->id,
            'id_usuario_tecnico' => $usuarioTecnico->id,
        ]);

        $emenda = Emenda::create([
            'id_solicitude' => $solicitude->id,
            'id_solicitante' => $solicitante->id,
        ]);

        $remesa = Remesa::create([
            'id_emenda' => $emenda->id,
            'id_usuario_admin' => $usuarioAdministrativo->id,
            'id_usuario_tecnico' => $usuarioTecnico->id,
        ]);

        $loadedSolicitude = Solicitude::with([
            'solicitante',
            'entidade',
            'usuarioAdministrativo',
            'usuarioTecnico',
        ])->findOrFail($solicitude->id);

        $this->assertTrue($loadedSolicitude->relationLoaded('solicitante'));
        $this->assertTrue($loadedSolicitude->relationLoaded('entidade'));
        $this->assertTrue($loadedSolicitude->relationLoaded('usuarioAdministrativo'));
        $this->assertTrue($loadedSolicitude->relationLoaded('usuarioTecnico'));
        $this->assertSame($solicitante->id, $loadedSolicitude->solicitante->id);
        $this->assertSame($entidade->id, $loadedSolicitude->entidade->id);
        $this->assertSame($usuarioAdministrativo->id, $loadedSolicitude->usuarioAdministrativo->id);
        $this->assertSame($usuarioTecnico->id, $loadedSolicitude->usuarioTecnico->id);

        $loadedEmenda = Emenda::with('remesas')->findOrFail($emenda->id);
        $this->assertTrue($loadedEmenda->relationLoaded('remesas'));
        $this->assertCount(1, $loadedEmenda->remesas);
        $this->assertSame($remesa->id, $loadedEmenda->remesas->first()->id);

        $loadedRemesa = Remesa::with('emenda')->findOrFail($remesa->id);
        $this->assertTrue($loadedRemesa->relationLoaded('emenda'));
        $this->assertSame($emenda->id, $loadedRemesa->emenda->id);

        $this->assertSame('id_solicitante', (new Solicitude())->solicitante()->getForeignKeyName());
        $this->assertSame('id_entidade', (new Solicitude())->entidade()->getForeignKeyName());
        $this->assertSame('id_usuario_admin', (new Solicitude())->usuarioAdministrativo()->getForeignKeyName());
        $this->assertSame('id_usuario_tecnico', (new Solicitude())->usuarioTecnico()->getForeignKeyName());
        $this->assertSame('id_solicitude', (new Emenda())->solicitude()->getForeignKeyName());
        $this->assertSame('id_emenda', (new Emenda())->remesas()->getForeignKeyName());
        $this->assertSame('id_solicitante', (new Solicitante())->solicitudes()->getForeignKeyName());
        $this->assertSame('id_entidade', (new Entidade())->solicitudes()->getForeignKeyName());
        $this->assertSame('id_usuario_admin', (new UsuarioAdministrativo())->solicitudes()->getForeignKeyName());
        $this->assertSame('id_usuario_tecnico', (new UsuarioTecnico())->solicitudes()->getForeignKeyName());
    }

}
