@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            @if (session('success'))
                <div class="campo_formulario" style="color:#166534;" data-solicitude-success="{{ session('success') }}">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="GET" action="{{ route('solicitude.listado') }}" style="margin: 1rem 0; display: flex; gap: .75rem; flex-wrap: wrap; align-items: center;">
                <input
                    type="search"
                    name="search"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar por ID, solicitante, entidade, estado ou responsables"
                    style="flex: 1 1 24rem; min-width: 16rem; padding: .7rem .9rem; border: 1px solid #d1d5db; border-radius: .5rem;"
                >
                <input type="hidden" name="sort_by" value="{{ $ordenPor ?? 'id' }}">
                <input type="hidden" name="sort_dir" value="{{ $direccion ?? 'desc' }}">
                <button class="boton_formulario" type="submit">Buscar</button>
                @if (!empty($busqueda))
                    <a class="boton_secundario_dialog" href="{{ route('solicitude.listado') }}" style="text-decoration:none;">Limpar</a>
                @endif
            </form>

            <div style="display:flex; flex-wrap:wrap; gap:.45rem; margin: .35rem 0 1rem 0;">
                @foreach ($camposOrdenables as $campo => $etiqueta)
                    @php
                        $activo = ($ordenPor ?? 'id') === $campo;
                        $novaDireccion = $activo && ($direccion ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $query = array_merge(request()->except(['page']), ['sort_by' => $campo, 'sort_dir' => $novaDireccion]);
                    @endphp
                    <a class="boton_secundario_dialog"
                        href="{{ route('solicitude.listado', $query) }}"
                        style="text-decoration:none; {{ $activo ? 'font-weight:700; border-color:#0f766e;' : '' }}">
                        {{ $etiqueta }}{{ $activo ? ' (' . strtoupper($direccion ?? 'desc') . ')' : '' }}
                    </a>
                @endforeach
            </div>

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
                        @php
                            $clasesBoton = 'boton_detalle_solicitude';
                            if ($solicitude->estado_solicitude?->isNoEmendable()) {
                                if ($solicitude->estado_solicitude->value === 'aprobada') {
                                    $clasesBoton .= ' boton_detalle_solicitude_aprobada';
                                } else {
                                    $clasesBoton .= ' boton_detalle_solicitude_denegada_desistida';
                                }
                            } elseif ($documentacionVm['requiereEmenda']) {
                                $clasesBoton .= ' boton_detalle_solicitude_emendable';
                            }
                        @endphp
                        <button class="{{ $clasesBoton }}" type="button"
                            data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                            <span>#{{ $solicitude->id }}</span>
                            <span>Solicitante: </span>
                            <span style="font-weight: normal"><em>{{ $solicitude->solicitante?->nome }}</em></span>
                            <span>CIF|NIF: </span>
                            <span style="font-weight: normal"><em>{{ $solicitude->solicitante?->nif_cif }}</em></span>
                            @if ($solicitude->estado_solicitude?->isNoEmendable())
                                @if ($solicitude->estado_solicitude->value === 'aprobada')
                                    <span class="etiqueta_aprobada">{{ $solicitude->estado_solicitude->label() }}</span>
                                @else
                                    <span class="etiqueta_denegada_desistida">{{ $solicitude->estado_solicitude->label() }}</span>
                                @endif
                            @elseif ($documentacionVm['requiereEmenda'])
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
    <script src="{{ asset('js/solicitude_form.js') }}"></script>

@endsection

