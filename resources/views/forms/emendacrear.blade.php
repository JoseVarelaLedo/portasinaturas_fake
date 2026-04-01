@extends ('index')

@section ('form')
    <section class="contedor_decorado">
        <a class="enlace_decorado" href="{{ route('index') }}">Volver a inicio</a>

        <form class="contedor_contido_decorado">
            <div class="campo_formulario">
                <label for="nome_apelidos">Nome e apelidos</label>
                <input id="nome_apelidos" type="text" placeholder="Introduce o nome completo" />
            </div>

            <div class="campo_formulario">
                <label for="nif">Nif</label>
                <input id="nif" type="text" placeholder="Introduce o NIF" />
            </div>

            <input class="boton_formulario" type="submit" value="Crear solicitante" />
        </form>
    </section>
@endsection
