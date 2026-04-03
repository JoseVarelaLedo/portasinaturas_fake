@extends ('index')

@section ('form')
    <section class="contedor_decorado">
        <a class="enlace_decorado" href="{{ route('index') }}">Volver a inicio</a>

        @if ($errors->any())
            <div class="campo_formulario" style="color:#b91c1c;">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <form class="contedor_contido_decorado" method="POST" action="{{ route('solicitante.store') }}">
            @csrf
            <div class="campo_formulario">
                <label for="nome">Nome e apelidos</label>
                <input id="nome" name="nome" type="text" value="{{ old('nome') }}"
                    placeholder="Introduce o nome completo" />
            </div>

            <div class="campo_formulario">
                <label for="nif_cif">NIF/CIF</label>
                <input id="nif_cif" name="nif_cif" type="text" value="{{ old('nif_cif') }}"
                    placeholder="Introduce o NIF/CIF" />
            </div>

            <div class="campo_formulario">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                    placeholder="nome@exemplo.com" />
            </div>

            <div class="campo_formulario">
                <label for="telefono">Teléfono</label>
                <input id="telefono" name="telefono" type="text" value="{{ old('telefono') }}"
                    placeholder="Ex: 612345678" />
            </div>

            <div class="campo_formulario">
                <label for="direccion">Dirección</label>
                <input id="direccion" name="direccion" type="text" value="{{ old('direccion') }}"
                    placeholder="Rúa, número..." />
            </div>

            <div class="campo_formulario">
                <label for="cidade">Cidade</label>
                <input id="cidade" name="cidade" type="text" value="{{ old('cidade') }}" placeholder="Cidade" />
            </div>

            <div class="campo_formulario">
                <label for="provincia">Provincia</label>
                <input id="provincia" name="provincia" type="text" value="{{ old('provincia') }}"
                    placeholder="Provincia" />
            </div>

            <div class="campo_formulario">
                <label for="codigo_postal">Código postal</label>
                <input id="codigo_postal" name="codigo_postal" type="text" maxlength="5"
                    value="{{ old('codigo_postal') }}" placeholder="Ex: 15001" />
            </div>

            <div class="campo_formulario">
                <label for="pais">País</label>
                <input id="pais" name="pais" type="text" value="{{ old('pais') }}" placeholder="País" />
            </div>

            <input class="boton_formulario" type="submit" value="Crear solicitante" />
        </form>
    </section>
@endsection
