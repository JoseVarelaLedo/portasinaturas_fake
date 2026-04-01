@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <ul class="lista_elementos">
                @forelse ($remesas as $remesa)
                    <li class="fila_elemento"> #{{ $remesa->id }}</li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>
@endsection