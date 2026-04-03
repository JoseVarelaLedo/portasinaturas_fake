@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            @if (session('success'))
                <div class="campo_formulario" style="color:#166534;">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <ul class="lista_elementos">
                @forelse ($solicitudes as $solicitude)
                    @php
                        $documentacionVm = $documentacionPorSolicitude[$solicitude->id] ?? [
                            'requiereEmenda' => false,
                            'camposTecnicos' => [],
                            'camposAdministrativos' => [],
                        ];
                    @endphp

                    <li class="fila_elemento fila_elemento_solicitude">
                        <button class="boton_detalle_solicitude {{ $documentacionVm['requiereEmenda'] ? 'boton_detalle_solicitude_emendable' : '' }}" type="button"
                            data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                            <span>#{{ $solicitude->id }}</span>
                            <span>Solicitante: </span>
                            <span style="font-weight: normal"><em>{{ $solicitude->solicitante?->nome }}</em></span>
                            <span>CIF|NIF: </span>
                            <span style="font-weight: normal"><em>{{ $solicitude->solicitante?->nif_cif }}</em></span>
                            @if ($documentacionVm['requiereEmenda'])
                                <span class="etiqueta_emendable">EMENDAR</span>
                            @endif
                        </button>
                        @include('layouts._partials.tarxeta_solicitude', [
                            'solicitude' => $solicitude,
                            'usuariosAdministrativos' => $usuariosAdministrativos,
                            'usuariosTecnicos' => $usuariosTecnicos,
                        ])
                        @include('layouts._partials.tarxeta_documentacion', [
                            'solicitude' => $solicitude,
                            'documentacionVm' => $documentacionVm,
                            'estadosDocumento' => $estadosDocumento,
                        ])
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
        {{ $solicitudes->links() }}
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/solicitudes_dialog.js') }}"></script>
    <script src="{{ asset('js/emenda_actions.js') }}"></script>

@endsection

