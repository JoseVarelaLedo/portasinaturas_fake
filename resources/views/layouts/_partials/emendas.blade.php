@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            @if (session('success'))
                <div class="campo_formulario" style="color:#166534;">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="campo_formulario" style="color:#b91c1c;">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="GET" action="{{ route('emenda.listado') }}" style="margin: 1rem 0; display: flex; gap: .75rem; flex-wrap: wrap; align-items: center;">
                <input
                    type="search"
                    name="search"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar por emenda, solicitude, solicitante, usuarios ou remesa"
                    style="flex: 1 1 24rem; min-width: 16rem; padding: .7rem .9rem; border: 1px solid #d1d5db; border-radius: .5rem;"
                >
                <input type="hidden" name="sort_by" value="{{ $ordenPor ?? 'id' }}">
                <input type="hidden" name="sort_dir" value="{{ $direccion ?? 'desc' }}">
                <button class="boton_formulario" type="submit">Buscar</button>
                @if (!empty($busqueda))
                    <a class="boton_secundario_dialog" href="{{ route('emenda.listado') }}" style="text-decoration:none;">Limpar</a>
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
                        href="{{ route('emenda.listado', $query) }}"
                        style="text-decoration:none; {{ $activo ? 'font-weight:700; border-color:#0f766e;' : '' }}">
                        {{ $etiqueta }}{{ $activo ? ' (' . strtoupper($direccion ?? 'desc') . ')' : '' }}
                    </a>
                @endforeach
            </div>

            <form method="POST" action="{{ route('remesa.store') }}" id="form-remesa">
                @csrf

                <button class="boton_formulario" type="submit" id="boton-xerar-remesa" hidden disabled>
                    Xerar Remesa
                    <!--TODO implementar lóxica de chamada a servizos de NOTIFICACIÓN a destinatarios remesa -->
                </button>

                <ul class="lista_elementos">
                @forelse ($emendas as $emenda)
                    <li class="fila_elemento {{ $emenda->remesaActual ? 'fila_elemento_remitida' : '' }}">
                        <label style="display:flex; align-items:center; gap:.65rem; width:100%;">
                            @if ($emenda->remesaActual)
                                <a class="boton_secundario_dialog" href="{{ route('remesa.listado') }}#{{ $emenda->remesaActual->anchorGrupo() }}"
                                    style="white-space:nowrap; text-decoration:none;">
                                    En {{ $emenda->remesaActual->codigoGrupo() }}
                                </a>
                            @else
                                <input type="checkbox" name="emenda_ids[]" value="{{ $emenda->id }}" class="check-emenda">
                            @endif

                            <a href="{{ route('solicitude.tarxeta', ['solicitude' => $emenda->id_solicitude]) }}"
                                style="text-decoration:none; color:inherit; width:100%;">
                                <strong>Emenda #{{ $emenda->id }}</strong>
                                @if ($emenda->remesaActual)
                                    <span class="etiqueta_remitida">REMITIDA</span>
                                @endif
                                | Solicitude #{{ $emenda->id_solicitude }}
                                | Solicitante: {{ $emenda->solicitude?->solicitante?->nome ?? $emenda->id_solicitante }}
                                | Admin: {{ $emenda->solicitude?->usuarioAdministrativo?->nome ?? 'Sen asignar' }}
                                | Técnico: {{ $emenda->solicitude?->usuarioTecnico?->nome ?? 'Sen asignar' }}
                            </a>
                        </label>
                        <a href="{{ route('emenda.xerarPDF', ['emenda' => $emenda->id]) }}" class="etiqueta_emendable">
                            Descargar PDF
                        </a>

                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
                </ul>
            </form>
        </div>
    </section>

    <script src="{{ asset('js/remesa_actions.js') }}"></script>
@endsection
