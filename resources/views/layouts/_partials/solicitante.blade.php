@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('solicitante.crear') }}">Crear Solicitante</a>
            <form method="GET" action="{{ route('solicitante.listado') }}" style="margin: 1rem 0; display: flex; gap: .75rem; flex-wrap: wrap; align-items: center;">
                <input
                    type="search"
                    name="search"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar por nome, NIF, email ou enderezo"
                    style="flex: 1 1 20rem; min-width: 16rem; padding: .7rem .9rem; border: 1px solid #d1d5db; border-radius: .5rem;"
                >
                <input type="hidden" name="sort_by" value="{{ $ordenPor ?? 'nome' }}">
                <input type="hidden" name="sort_dir" value="{{ $direccion ?? 'asc' }}">
                <button class="boton_formulario" type="submit">Buscar</button>
                @if (!empty($busqueda))
                    <a class="boton_secundario_dialog" href="{{ route('solicitante.listado') }}" style="text-decoration:none;">Limpar</a>
                @endif
            </form>

            <div style="display:flex; flex-wrap:wrap; gap:.45rem; margin: .35rem 0 1rem 0;">
                @foreach ($camposOrdenables as $campo => $etiqueta)
                    @php
                        $activo = ($ordenPor ?? 'nome') === $campo;
                        $novaDireccion = $activo && ($direccion ?? 'asc') === 'asc' ? 'desc' : 'asc';
                        $query = array_merge(request()->except(['page']), ['sort_by' => $campo, 'sort_dir' => $novaDireccion]);
                    @endphp
                    <a class="boton_secundario_dialog"
                        href="{{ route('solicitante.listado', $query) }}"
                        style="text-decoration:none; {{ $activo ? 'font-weight:700; border-color:#0f766e;' : '' }}">
                        {{ $etiqueta }}{{ $activo ? ' (' . strtoupper($direccion ?? 'asc') . ')' : '' }}
                    </a>
                @endforeach
            </div>
            <ul class="lista_elementos">
                @forelse ($solicitantes as $solicitante)
                    <li class="fila_elemento">
                        <div class="fila_superior">
                            <details class="desplegable_solicitante">
                                <summary class="resumen_solicitante">
                                    <span>
                                        <b>Nome:</b> {{ $solicitante->nome }},
                                        <b>NIF:</b> {{ $solicitante->nif_cif }}
                                    </span>
                                    <span class="flecha"></span>
                                </summary>

                                <div class="contenido_desplegable">
                                    <div class="fila_elemento_datos">
                                        <span><b>Dirección:</b> {{ $solicitante->direccion }}, <b>Localidade:</b>
                                            {{ $solicitante->cidade }}</span>
                                        <span><b>Provincia:</b> {{ $solicitante->provincia }}, <b>Código Postal:</b>
                                            {{ $solicitante->codigo_postal }} <b>País:</b> {{ $solicitante->pais }}</span>
                                    </div>
                                </div>
                            </details>

                            <a class="boton_crearsolicitude"
                                href="{{ route('solicitude.crear', ['solicitante_id' => $solicitante->id]) }}">
                                Nova Solicitude
                            </a>
                        </div>
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
        {{ $solicitantes->links() }}
    </section>
@endsection
