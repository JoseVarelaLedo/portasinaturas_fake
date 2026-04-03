<?php

namespace App\Services;

use App\Models\Solicitude;

class SolicitudeDocumentacionService
{
    private const ESTADO_EMENDAR = 'emendar';

    /**
     * @return array<string, mixed>
     */
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public function buildForCollection(iterable $solicitudes): array
    {
        $resultado = [];

        foreach ($solicitudes as $solicitude) {
            $resultado[$solicitude->id] = $this->buildForSolicitude($solicitude);
        }

        return $resultado;
    }

    /**
     * @return array<int, array{campo:string,etiqueta:string,estado:?string}>
     */
    private function buildCamposTecnicos(Solicitude $solicitude): array
    {
        $documentacionTecnica = $solicitude->documentacionTecnica;

        return [
            ['campo' => 'estado_memoria_tecnica', 'etiqueta' => 'Memoria tecnica', 'estado' => $documentacionTecnica?->estado_memoria_tecnica],
            ['campo' => 'estado_presupuesto', 'etiqueta' => 'Presupuesto', 'estado' => $documentacionTecnica?->estado_presupuesto],
            ['campo' => 'estado_ofertas_proveedores', 'etiqueta' => 'Ofertas de provedores', 'estado' => $documentacionTecnica?->estado_ofertas_proveedores],
            ['campo' => 'estado_planos', 'etiqueta' => 'Planos', 'estado' => $documentacionTecnica?->estado_planos],
            ['campo' => 'estado_estudio_energetico', 'etiqueta' => 'Estudo enerxetico', 'estado' => $documentacionTecnica?->estado_estudio_energetico],
            ['campo' => 'estado_fichas_tecnicas', 'etiqueta' => 'Fichas tecnicas', 'estado' => $documentacionTecnica?->estado_fichas_tecnicas],
            ['campo' => 'estado_licencias', 'etiqueta' => 'Licenzas', 'estado' => $documentacionTecnica?->estado_licencias],
            ['campo' => 'estado_cronograma', 'etiqueta' => 'Cronograma', 'estado' => $documentacionTecnica?->estado_cronograma],
        ];
    }

    /**
     * @return array<int, array{campo:string,etiqueta:string,estado:?string}>
     */
    private function buildCamposAdministrativos(Solicitude $solicitude): array
    {
        $documentacionAdministrativa = $solicitude->documentacionAdministrativa;

        return [
            ['campo' => 'estado_formulario_solicitud', 'etiqueta' => 'Formulario de solicitude', 'estado' => $documentacionAdministrativa?->estado_formulario_solicitud],
            ['campo' => 'estado_documento_identificativo', 'etiqueta' => 'Documento identificativo', 'estado' => $documentacionAdministrativa?->estado_documento_identificativo],
            ['campo' => 'estado_acreditacion_representacion', 'etiqueta' => 'Acreditacion de representacion', 'estado' => $documentacionAdministrativa?->estado_acreditacion_representacion],
            ['campo' => 'estado_certificado_aeat', 'etiqueta' => 'Certificado AEAT', 'estado' => $documentacionAdministrativa?->estado_certificado_aeat],
            ['campo' => 'estado_certificado_seguridad_social', 'etiqueta' => 'Certificado Seguridade Social', 'estado' => $documentacionAdministrativa?->estado_certificado_seguridad_social],
            ['campo' => 'estado_declaracion_responsable', 'etiqueta' => 'Declaracion responsable', 'estado' => $documentacionAdministrativa?->estado_declaracion_responsable],
            ['campo' => 'estado_datos_bancarios', 'etiqueta' => 'Datos bancarios', 'estado' => $documentacionAdministrativa?->estado_datos_bancarios],
            ['campo' => 'estado_escritura_constitucion', 'etiqueta' => 'Escritura de constitucion', 'estado' => $documentacionAdministrativa?->estado_escritura_constitucion],
        ];
    }

    /**
     * @param  array<int, mixed>  $estados
     */
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
