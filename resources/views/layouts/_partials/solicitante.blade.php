@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('solicitante.crear') }}">Crear Solicitante</a>
            <ul class="lista_elementos">
                @forelse ($solicitantes as $solicitante)
                    <li class="fila_elemento">
                        <span><b>Nome:</b> {{ $solicitante->nome }}, <b>NIF:</b> {{ $solicitante->nif_cif }}</span>
                        <a class="boton_crearsolicitude"
                            href="{{ route('solicitude.crear', ['solicitante_id' => $solicitante->id]) }}">Nova Solicitude</a>
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
