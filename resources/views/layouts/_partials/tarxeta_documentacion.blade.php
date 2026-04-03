@php
    $documentacionTecnica = $solicitude->documentacionTecnica;
    $documentacionAdministrativa = $solicitude->documentacionAdministrativa;

    $camposTecnicos = [
        'Memoria técnica' => $documentacionTecnica?->estado_memoria_tecnica,
        'Presupuesto' => $documentacionTecnica?->estado_presupuesto,
        'Ofertas de provedores' => $documentacionTecnica?->estado_ofertas_proveedores,
        'Planos' => $documentacionTecnica?->estado_planos,
        'Estudo enerxético' => $documentacionTecnica?->estado_estudio_energetico,
        'Fichas técnicas' => $documentacionTecnica?->estado_fichas_tecnicas,
        'Licenzas' => $documentacionTecnica?->estado_licencias,
        'Cronograma' => $documentacionTecnica?->estado_cronograma,
    ];

    $camposAdministrativos = [
        'Formulario de solicitude' => $documentacionAdministrativa?->estado_formulario_solicitud,
        'Documento identificativo' => $documentacionAdministrativa?->estado_documento_identificativo,
        'Acreditación de representación' => $documentacionAdministrativa?->estado_acreditacion_representacion,
        'Certificado AEAT' => $documentacionAdministrativa?->estado_certificado_aeat,
        'Certificado Seguridade Social' => $documentacionAdministrativa?->estado_certificado_seguridad_social,
        'Declaración responsable' => $documentacionAdministrativa?->estado_declaracion_responsable,
        'Datos bancarios' => $documentacionAdministrativa?->estado_datos_bancarios,
        'Escritura de constitución' => $documentacionAdministrativa?->estado_escritura_constitucion,
    ];

    $formatEstado = static fn (?string $estado): string => $estado
        ? ucfirst(str_replace('_', ' ', $estado))
        : 'Sen rexistro';

    $requiereEmenda = collect(array_merge(array_values($camposTecnicos), array_values($camposAdministrativos)))
        ->contains(static fn ($estado): bool => is_string($estado) && strtolower(trim($estado)) === 'emendar');
@endphp

<dialog class="dialog_solicitude dialog_documentacion" id="detalle-documentacion-{{ $solicitude->id }}">
    <article class="tarxeta_solicitude tarxeta_documentacion">
        <header class="tarxeta_solicitude_header tarxeta_documentacion_header">
            <div>
                <h3>Documentación da solicitude #{{ $solicitude->id }}</h3>
                <p>Solicitante: {{ $solicitude->solicitante?->nome ?? ($solicitude->nome_solicitante ?? 'N/D') }}</p>
            </div>

            <div class="acciones_dialog">
                @if ($requiereEmenda)
                    <a class="boton_emendar" href="{{ route('emenda.crear', ['solicitude_id' => $solicitude->id]) }}">
                        EMENDAR
                    </a>
                @endif
                <button class="boton_secundario_dialog" type="button"
                    data-switch-dialog="detalle-solicitude-{{ $solicitude->id }}">
                    Volver á solicitude
                </button>
                <button class="boton_peche_dialog" type="button" data-close-dialog>&times;</button>
            </div>
        </header>

        <section class="tabs_documentacion" data-tabs>
            <div class="tabs_documentacion_header" role="tablist" aria-label="Documentación da solicitude {{ $solicitude->id }}">
                <button class="tab_documentacion is-active" type="button" role="tab"
                    aria-selected="true" aria-controls="tab-tecnica-{{ $solicitude->id }}"
                    data-tab-target="tab-tecnica-{{ $solicitude->id }}">
                    Técnica
                </button>
                <button class="tab_documentacion" type="button" role="tab"
                    aria-selected="false" aria-controls="tab-administrativa-{{ $solicitude->id }}"
                    data-tab-target="tab-administrativa-{{ $solicitude->id }}">
                    Administrativa
                </button>
            </div>

            <section class="tab_panel_documentacion" id="tab-tecnica-{{ $solicitude->id }}" role="tabpanel">
                <div class="tarxeta_solicitude_grid tarxeta_documentacion_grid">
                    @foreach ($camposTecnicos as $etiqueta => $estado)
                        <p>
                            <strong>{{ $etiqueta }}:</strong>
                            <span>{{ $formatEstado($estado) }}</span>
                        </p>
                    @endforeach
                </div>
            </section>

            <section class="tab_panel_documentacion" id="tab-administrativa-{{ $solicitude->id }}" role="tabpanel" hidden>
                <div class="tarxeta_solicitude_grid tarxeta_documentacion_grid">
                    @foreach ($camposAdministrativos as $etiqueta => $estado)
                        <p>
                            <strong>{{ $etiqueta }}:</strong>
                            <span>{{ $formatEstado($estado) }}</span>
                        </p>
                    @endforeach
                </div>
            </section>
        </section>
    </article>
</dialog>
