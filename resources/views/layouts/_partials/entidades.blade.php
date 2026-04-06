@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href=" {{ route('entidade.crear') }}">Crear Entidade</a>
            <form method="GET" action="{{ route('entidade.listado') }}" style="margin: 1rem 0; display: flex; gap: .75rem; flex-wrap: wrap; align-items: center;">
                <input
                    type="search"
                    name="search"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar por nome ou CIF"
                    style="flex: 1 1 20rem; min-width: 16rem; padding: .7rem .9rem; border: 1px solid #d1d5db; border-radius: .5rem;"
                >
                <button class="boton_formulario" type="submit">Buscar</button>
                @if (!empty($busqueda))
                    <a class="boton_secundario_dialog" href="{{ route('entidade.listado') }}" style="text-decoration:none;">Limpar</a>
                @endif
            </form>
            <ul class="lista_elementos">
                @forelse ($entidades as $entidade)
                    <li class="fila_elemento"> <b> Nome:</b> {{ $entidade->nome }}, <b>CIF:</b> {{ $entidade->cif }}</li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
        {{ $entidades->links() }}
    </section>
@endsection
