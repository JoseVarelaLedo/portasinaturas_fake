@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <ul class="lista_elementos">
                @forelse ($solicitudes as $solicitude)
                    @php
                        $estadosDocumentacion = [
                            $solicitude->documentacionTecnica?->estado_memoria_tecnica,
                            $solicitude->documentacionTecnica?->estado_presupuesto,
                            $solicitude->documentacionTecnica?->estado_ofertas_proveedores,
                            $solicitude->documentacionTecnica?->estado_planos,
                            $solicitude->documentacionTecnica?->estado_estudio_energetico,
                            $solicitude->documentacionTecnica?->estado_fichas_tecnicas,
                            $solicitude->documentacionTecnica?->estado_licencias,
                            $solicitude->documentacionTecnica?->estado_cronograma,
                            $solicitude->documentacionAdministrativa?->estado_formulario_solicitud,
                            $solicitude->documentacionAdministrativa?->estado_documento_identificativo,
                            $solicitude->documentacionAdministrativa?->estado_acreditacion_representacion,
                            $solicitude->documentacionAdministrativa?->estado_certificado_aeat,
                            $solicitude->documentacionAdministrativa?->estado_certificado_seguridad_social,
                            $solicitude->documentacionAdministrativa?->estado_declaracion_responsable,
                            $solicitude->documentacionAdministrativa?->estado_datos_bancarios,
                            $solicitude->documentacionAdministrativa?->estado_escritura_constitucion,
                        ];

                        $solicitudeEmendable = collect($estadosDocumentacion)
                            ->contains(static fn ($estado): bool => is_string($estado) && strtolower(trim($estado)) === 'emendar');
                    @endphp

                    <li class="fila_elemento fila_elemento_solicitude">
                        <button class="boton_detalle_solicitude {{ $solicitudeEmendable ? 'boton_detalle_solicitude_emendable' : '' }}" type="button"
                            data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                            <span>#{{ $solicitude->id }}</span>
                            <span>Solicitante: </span>
                            <span style="font-weight: normal"><em>{{ $solicitude->solicitante?->nome }}</em></span>
                            <span>CIF|NIF: </span>
                            <span style="font-weight: normal"><em>{{ $solicitude->solicitante?->nif_cif }}</em></span>
                            @if ($solicitudeEmendable)
                                <span class="etiqueta_emendable">EMENDAR</span>
                            @endif
                        </button>
                        @include('layouts._partials.tarxeta_solicitude', ['solicitude' => $solicitude])
                        @include('layouts._partials.tarxeta_documentacion', ['solicitude' => $solicitude])
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
        {{ $solicitudes->links() }}
    </section>

    <script src="{{ asset('js/solicitudes_dialog.js') }}"></script>
    
@endsection

