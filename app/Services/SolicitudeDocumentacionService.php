<?php

namespace App\Services;

use App\Models\Solicitude;

class SolicitudeDocumentacionService
{
    private const ESTADO_EMENDAR = 'emendar';

    public function buildForSolicitude(Solicitude $solicitude): array
    {
        $camposTecnicos = $this->buildCamposTecnicos($solicitude);
        $camposAdministrativos = $this->buildCamposAdministrativos($solicitude);

        return [
            'camposTecnicos' => $camposTecnicos,
            'camposAdministrativos' => $camposAdministrativos,
            'requiereEmenda' => $this->hasEstadoEmendar(array_merge(
                array_column($camposTecnicos, 'estado'),
                array_column($camposAdministrativos, 'estado')
            )),
        ];
    }

    public function buildForCollection(iterable $solicitudes): array
    {
        $resultado = [];

        foreach ($solicitudes as $solicitude) {
            $resultado[$solicitude->id] = $this->buildForSolicitude($solicitude);
        }

        return $resultado;
    }

    private function buildCamposTecnicos(Solicitude $solicitude): array
    {
        $documentacionTecnica = $solicitude->documentacionTecnica;
        $motivosEmenda = is_array($documentacionTecnica?->motivos_emenda) ? $documentacionTecnica->motivos_emenda : [];

        return [
            ['campo' => 'estado_memoria_tecnica', 'etiqueta' => 'Memoria tecnica', 'estado' => $documentacionTecnica?->estado_memoria_tecnica, 'motivo' => $motivosEmenda['estado_memoria_tecnica'] ?? null],
            ['campo' => 'estado_presupuesto', 'etiqueta' => 'Presupuesto', 'estado' => $documentacionTecnica?->estado_presupuesto, 'motivo' => $motivosEmenda['estado_presupuesto'] ?? null],
            ['campo' => 'estado_ofertas_proveedores', 'etiqueta' => 'Ofertas de provedores', 'estado' => $documentacionTecnica?->estado_ofertas_proveedores, 'motivo' => $motivosEmenda['estado_ofertas_proveedores'] ?? null],
            ['campo' => 'estado_planos', 'etiqueta' => 'Planos', 'estado' => $documentacionTecnica?->estado_planos, 'motivo' => $motivosEmenda['estado_planos'] ?? null],
            ['campo' => 'estado_estudio_energetico', 'etiqueta' => 'Estudo enerxetico', 'estado' => $documentacionTecnica?->estado_estudio_energetico, 'motivo' => $motivosEmenda['estado_estudio_energetico'] ?? null],
            ['campo' => 'estado_fichas_tecnicas', 'etiqueta' => 'Fichas tecnicas', 'estado' => $documentacionTecnica?->estado_fichas_tecnicas, 'motivo' => $motivosEmenda['estado_fichas_tecnicas'] ?? null],
            ['campo' => 'estado_licencias', 'etiqueta' => 'Licenzas', 'estado' => $documentacionTecnica?->estado_licencias, 'motivo' => $motivosEmenda['estado_licencias'] ?? null],
            ['campo' => 'estado_cronograma', 'etiqueta' => 'Cronograma', 'estado' => $documentacionTecnica?->estado_cronograma, 'motivo' => $motivosEmenda['estado_cronograma'] ?? null],
        ];
    }
    private function buildCamposAdministrativos(Solicitude $solicitude): array
    {
        $documentacionAdministrativa = $solicitude->documentacionAdministrativa;
        $motivosEmenda = is_array($documentacionAdministrativa?->motivos_emenda) ? $documentacionAdministrativa->motivos_emenda : [];

        return [
            ['campo' => 'estado_formulario_solicitud', 'etiqueta' => 'Formulario de solicitude', 'estado' => $documentacionAdministrativa?->estado_formulario_solicitud, 'motivo' => $motivosEmenda['estado_formulario_solicitud'] ?? null],
            ['campo' => 'estado_documento_identificativo', 'etiqueta' => 'Documento identificativo', 'estado' => $documentacionAdministrativa?->estado_documento_identificativo, 'motivo' => $motivosEmenda['estado_documento_identificativo'] ?? null],
            ['campo' => 'estado_acreditacion_representacion', 'etiqueta' => 'Acreditacion de representacion', 'estado' => $documentacionAdministrativa?->estado_acreditacion_representacion, 'motivo' => $motivosEmenda['estado_acreditacion_representacion'] ?? null],
            ['campo' => 'estado_certificado_aeat', 'etiqueta' => 'Certificado AEAT', 'estado' => $documentacionAdministrativa?->estado_certificado_aeat, 'motivo' => $motivosEmenda['estado_certificado_aeat'] ?? null],
            ['campo' => 'estado_certificado_seguridad_social', 'etiqueta' => 'Certificado Seguridade Social', 'estado' => $documentacionAdministrativa?->estado_certificado_seguridad_social, 'motivo' => $motivosEmenda['estado_certificado_seguridad_social'] ?? null],
            ['campo' => 'estado_declaracion_responsable', 'etiqueta' => 'Declaracion responsable', 'estado' => $documentacionAdministrativa?->estado_declaracion_responsable, 'motivo' => $motivosEmenda['estado_declaracion_responsable'] ?? null],
            ['campo' => 'estado_datos_bancarios', 'etiqueta' => 'Datos bancarios', 'estado' => $documentacionAdministrativa?->estado_datos_bancarios, 'motivo' => $motivosEmenda['estado_datos_bancarios'] ?? null],
            ['campo' => 'estado_escritura_constitucion', 'etiqueta' => 'Escritura de constitucion', 'estado' => $documentacionAdministrativa?->estado_escritura_constitucion, 'motivo' => $motivosEmenda['estado_escritura_constitucion'] ?? null],
        ];
    }

    private function hasEstadoEmendar(array $estados): bool
    {
        foreach ($estados as $estado) {
            if (is_string($estado) && strtolower(trim($estado)) === self::ESTADO_EMENDAR) {
                return true;
            }
        }

        return false;
    }
}
