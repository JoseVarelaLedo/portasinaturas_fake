@extends ('index')

@section ('form')
    <section class="contedor_decorado">
        <a class="enlace_decorado" href="{{ route('index') }}">Volver a inicio</a>

        <form class="contedor_contido_decorado" method="POST" action="{{ route('solicitante.store') }}">
            @csrf
            <div class="campo_formulario">
                <label for="nome">Nome e apelidos</label>
                <input id="nome" name="nome" type="text" placeholder="Introduce o nome completo" />
            </div>

            <div class="campo_formulario">
                <label for="nif_cif">Nif</label>
                <input id="nif_cif" name="nif_cif" type="text" placeholder="Introduce o NIF" />
            </div>

            <input class="boton_formulario" type="submit" value="Crear solicitante" />
        </form>
    </section>
@endsection
