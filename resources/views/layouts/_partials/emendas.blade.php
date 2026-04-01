@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('emenda.crear') }}">Crear emenda</a>
            <ul>
                @forelse ($emendas as $emenda)
                    <li> #{{ $emenda->id_solicitude }}, Solicitante {{ $emenda->id_solicitante }}</li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
