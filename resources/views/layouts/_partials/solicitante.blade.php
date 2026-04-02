@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('solicitante.crear') }}">Crear Solicitante</a>
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
