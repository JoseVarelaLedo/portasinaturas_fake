@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <ul class="lista_elementos">
                @forelse ($solicitudes as $solicitude)
                    <li class="fila_elemento fila_elemento_solicitude">
                        <button class="boton_detalle_solicitude" type="button"
                            data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                            <span>#{{ $solicitude->id }}</span>
                            <span>Solicitante: {{ $solicitude->solicitante?->nome }}</span>
                            <span>CIF|NIF: {{ $solicitude->solicitante?->nif_cif }}</span>
                        </button>
                        @include('layouts._partials.tarxeta_solicitude', ['solicitude' => $solicitude])
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

