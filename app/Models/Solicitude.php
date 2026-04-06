<?php

namespace App\Models;

use App\Enums\EstadoDocumento;
use App\Enums\EstadoSolicitude;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'estado_solicitude' => EstadoSolicitude::class,
    ];

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante');
    }

    public function usuarioAdministrativo(): BelongsTo
    {
        return $this->belongsTo(UsuarioAdministrativo::class, 'id_usuario_admin');
    }

    public function usuarioTecnico(): BelongsTo
    {
        return $this->belongsTo(UsuarioTecnico::class, 'id_usuario_tecnico');
    }

    public function entidade(): BelongsTo
    {
        return $this->belongsTo(Entidade::class, 'id_entidade');
    }
    public function documentacionAdministrativa()
    {
        return $this->hasOne(DocumentacionAdministrativa::class);
    }

    public function documentacionTecnica()
    {
        return $this->hasOne(DocumentacionTecnica::class);
    }

    /**
     * Valida si la solicitud puede ser aprobada.
     * No se puede aprobar si hay documentación en estados: en_revision, emendar, pendente o rexeitado
     */
    public function canBeApproved(): bool
    {
        $estadosNoPermitidos = [
            EstadoDocumento::EN_REVISION->value,
            EstadoDocumento::EMENDAR->value,
            EstadoDocumento::PENDENTE->value,
            EstadoDocumento::REXEITADO->value,
        ];

        $documentacionTecnica = $this->documentacionTecnica;
        $documentacionAdministrativa = $this->documentacionAdministrativa;

        // Verificar documentación técnica
        if ($documentacionTecnica) {
            $camposTecnicos = [
                'estado_memoria_tecnica',
                'estado_presupuesto',
                'estado_ofertas_proveedores',
                'estado_planos',
                'estado_estudio_energetico',
                'estado_fichas_tecnicas',
                'estado_licencias',
                'estado_cronograma',
            ];

            foreach ($camposTecnicos as $campo) {
                if (in_array($documentacionTecnica->$campo, $estadosNoPermitidos)) {
                    return false;
                }
            }
        }

        // Verificar documentación administrativa
        if ($documentacionAdministrativa) {
            $camposAdministrativos = [
                'estado_formulario_solicitud',
                'estado_documento_identificativo',
                'estado_acreditacion_representacion',
                'estado_certificado_aeat',
                'estado_certificado_seguridad_social',
                'estado_declaracion_responsable',
                'estado_datos_bancarios',
                'estado_escritura_constitucion',
            ];

            foreach ($camposAdministrativos as $campo) {
                if (in_array($documentacionAdministrativa->$campo, $estadosNoPermitidos)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Obtiene los campos que impiden la aprobación de la solicitud
     */
    public function getBlockingDocumentationFields(): array
    {
        $estadosNoPermitidos = [
            EstadoDocumento::EN_REVISION->value,
            EstadoDocumento::EMENDAR->value,
            EstadoDocumento::PENDENTE->value,
            EstadoDocumento::REXEITADO->value,
        ];

        $camposProblematicos = [];

        $documentacionTecnica = $this->documentacionTecnica;
        $documentacionAdministrativa = $this->documentacionAdministrativa;

        // Verificar documentación técnica
        if ($documentacionTecnica) {
            $camposTecnicos = [
                'estado_memoria_tecnica' => 'Memoria técnica',
                'estado_presupuesto' => 'Presupuesto',
                'estado_ofertas_proveedores' => 'Ofertas de proveedores',
                'estado_planos' => 'Planos',
                'estado_estudio_energetico' => 'Estudio energético',
                'estado_fichas_tecnicas' => 'Fichas técnicas',
                'estado_licencias' => 'Licencias',
                'estado_cronograma' => 'Cronograma',
            ];

            foreach ($camposTecnicos as $campo => $etiqueta) {
                if (in_array($documentacionTecnica->$campo, $estadosNoPermitidos)) {
                    $camposProblematicos[] = $etiqueta;
                }
            }
        }

        // Verificar documentación administrativa
        if ($documentacionAdministrativa) {
            $camposAdministrativos = [
                'estado_formulario_solicitud' => 'Formulario de solicitud',
                'estado_documento_identificativo' => 'Documento identificativo',
                'estado_acreditacion_representacion' => 'Acreditación de representación',
                'estado_certificado_aeat' => 'Certificado AEAT',
                'estado_certificado_seguridad_social' => 'Certificado Seguridad Social',
                'estado_declaracion_responsable' => 'Declaración responsable',
                'estado_datos_bancarios' => 'Datos bancarios',
                'estado_escritura_constitucion' => 'Escritura de constitución',
            ];

            foreach ($camposAdministrativos as $campo => $etiqueta) {
                if (in_array($documentacionAdministrativa->$campo, $estadosNoPermitidos)) {
                    $camposProblematicos[] = $etiqueta;
                }
            }
        }

        return $camposProblematicos;
    }
}
