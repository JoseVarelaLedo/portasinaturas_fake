<dialog class="dialog_solicitude dialog_documentacion" id="detalle-documentacion-{{ $solicitude->id }}">
    <article class="tarxeta_solicitude tarxeta_documentacion">
        <header class="tarxeta_solicitude_header tarxeta_documentacion_header">
            <div>
                <h3>Documentación da solicitude #{{ $solicitude->id }}</h3>
                <p>Solicitante: {{ $solicitude->solicitante?->nome ?? ($solicitude->nome_solicitante ?? 'N/D') }}</p>
            </div>

            <div class="acciones_dialog">
                @if ($documentacionVm['requiereEmenda'])
                    <form class="form_xerar_emenda" method="POST" action="{{ route('emenda.store') }}"
                        data-has-admin="{{ $solicitude->id_usuario_admin ? '1' : '0' }}"
                        data-has-tecnico="{{ $solicitude->id_usuario_tecnico ? '1' : '0' }}">
                        @csrf
                        <input type="hidden" name="id_solicitude" value="{{ $solicitude->id }}">
                        <button class="boton_emendar" type="submit">XERAR EMENDA</button>
                    </form>
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
                <form method="POST" action="{{ route('solicitude.documentacion.update', ['solicitude' => $solicitude->id]) }}">
                    @csrf

                    <div class="tarxeta_solicitude_grid tarxeta_documentacion_grid">
                        @foreach ($documentacionVm['camposTecnicos'] as $campo)
                            <div class="campo_formulario">
                                <label for="{{ $campo['campo'] }}-{{ $solicitude->id }}">{{ $campo['etiqueta'] }}</label>
                                <select id="{{ $campo['campo'] }}-{{ $solicitude->id }}" name="{{ $campo['campo'] }}">
                                    <option value="">Sen rexistro</option>
                                    @foreach ($estadosDocumento as $estadoDocumento)
                                        <option value="{{ $estadoDocumento['value'] }}"
                                            @selected($campo['estado'] === $estadoDocumento['value'])>
                                            {{ $estadoDocumento['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div class="tarxeta_solicitude_footer">
                        <button class="boton_formulario" type="submit">Gardar técnica</button>
                    </div>
                </form>
            </section>

            <section class="tab_panel_documentacion" id="tab-administrativa-{{ $solicitude->id }}" role="tabpanel" hidden>
                <form method="POST" action="{{ route('solicitude.documentacion.update', ['solicitude' => $solicitude->id]) }}">
                    @csrf

                    <div class="tarxeta_solicitude_grid tarxeta_documentacion_grid">
                        @foreach ($documentacionVm['camposAdministrativos'] as $campo)
                            <div class="campo_formulario">
                                <label for="{{ $campo['campo'] }}-{{ $solicitude->id }}">{{ $campo['etiqueta'] }}</label>
                                <select id="{{ $campo['campo'] }}-{{ $solicitude->id }}" name="{{ $campo['campo'] }}">
                                    <option value="">Sen rexistro</option>
                                    @foreach ($estadosDocumento as $estadoDocumento)
                                        <option value="{{ $estadoDocumento['value'] }}"
                                            @selected($campo['estado'] === $estadoDocumento['value'])>
                                            {{ $estadoDocumento['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div class="tarxeta_solicitude_footer">
                        <button class="boton_formulario" type="submit">Gardar administrativa</button>
                    </div>
                </form>
            </section>
        </section>
    </article>
</dialog>
