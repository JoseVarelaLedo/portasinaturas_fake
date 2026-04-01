@extends('index')

@section('list')
    <section class="contedor_decorado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('solicitante.crear') }}">Crear Solicitante</a>
            <ul>
                @forelse ($solicitantes as $solicitante)
                    <li> Nome: {{ $solicitante->nome }}, NIF: {{ $solicitante->nif_cif }}</li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
