@extends ('index')

@section ('form')
    <section class="contedor_decorado">
        <a class="enlace_decorado" href="{{ route('index') }}">Volver a inicio</a>

        <form class="contedor_contido_decorado" method="POST" action="{{ route('entidade.store') }}">
            @csrf
            <div class="campo_formulario">
                <label for="nome">Nome da entidade</label>
                <input id="nome" name="nome" type="text" placeholder="Introduce o nome da entidade" />
            </div>

            <div class="campo_formulario">
                <label for="cif">Cif</label>
                <input id="cif" name="cif" type="text" placeholder="Introduce o CIF" />
            </div>

            <input class="boton_formulario" type="submit" value="Crear entidade" />
        </form>
    </section>
@endsection
