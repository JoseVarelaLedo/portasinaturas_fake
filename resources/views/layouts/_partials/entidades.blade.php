@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('entidade.crear') }}">Crear Entidade</a>
            <ul class="lista_elementos">
                @forelse ($entidades as $entidade)
                    <li class="fila_elemento"> <b> Nome:</b> {{ $entidade->nome }}, <b>CIF:</b> {{ $entidade->cif }}</li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
