@extends ('index')

@section ('form')
    <section class="contedor_decorado contedor_listado">
        <a class="enlace_decorado" href="{{ route('solicitante.listado') }}">Volver ao listado de solicitantes</a>

        @if ($errors->any())
            <div class="campo_formulario" style="color:#b91c1c;">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <form class="contedor_contido_decorado" method="POST" action="{{ route('solicitude.store') }}">
            @csrf

            <input type="hidden" id="id_solicitante" name="id_solicitante" value="{{ old('id_solicitante', $solicitante->id) }}" />

            <div class="campo_formulario">
                <label for="solicitante_nome">Solicitante (autorrecheo)</label>
                <input id="solicitante_nome" type="text" value="{{ old('nome_solicitante', $solicitante->nome) }}" readonly />
                <input type="hidden" id="nome_solicitante" name="nome_solicitante"
                    value="{{ old('nome_solicitante', $solicitante->nome) }}" />
            </div>

            <div class="campo_formulario">
                <label for="solicitante_nif_cif">NIF/CIF (autorrecheo)</label>
                <input id="solicitante_nif_cif" type="text" value="{{ $solicitante->nif_cif }}" readonly />
            </div>

            <div class="campo_formulario">
                <label for="id_entidade">Entidade</label>
                <select id="id_entidade" name="id_entidade">
                    <option value="">Selecciona unha entidade</option>
                    @foreach ($entidades as $entidade)
                        <option value="{{ $entidade->id }}" data-nome="{{ $entidade->nome }}"
                            @selected((int) old('id_entidade') === $entidade->id)>
                            {{ $entidade->nome }} ({{ $entidade->cif }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="campo_formulario">
                <label for="nome_entidade">Nome da entidade</label>
                <input id="nome_entidade" name="nome_entidade" type="text"
                    value="{{ old('nome_entidade') }}" placeholder="Rexistrase xunto coa solicitude" />
            </div>

            <div class="campo_formulario">
                <label for="id_usuario_admin">Usuario administrativo</label>
                <select id="id_usuario_admin" name="id_usuario_admin">
                    <option value="">Sen asignar</option>
                    @foreach ($usuariosAdministrativos as $usuarioAdministrativo)
                        <option value="{{ $usuarioAdministrativo->id }}"
                            @selected((int) old('id_usuario_admin') === $usuarioAdministrativo->id)>
                            {{ $usuarioAdministrativo->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="campo_formulario">
                <label for="id_usuario_tecnico">Usuario técnico</label>
                <select id="id_usuario_tecnico" name="id_usuario_tecnico">
                    <option value="">Sen asignar</option>
                    @foreach ($usuariosTecnicos as $usuarioTecnico)
                        <option value="{{ $usuarioTecnico->id }}"
                            @selected((int) old('id_usuario_tecnico') === $usuarioTecnico->id)>
                            {{ $usuarioTecnico->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="campo_formulario">
                <label for="estado_doc">Estado da documentación</label>
                <input id="estado_doc" name="estado_doc" type="text" value="{{ old('estado_doc') }}"
                    placeholder="Ex: Pendiente, Completa..." />
            </div> --}}

            <div class="campo_formulario">
                <label for="contia_reservada_c7">Contía reservada C7</label>
                <input id="contia_reservada_c7" name="contia_reservada_c7" type="number" min="0" step="0.01"
                    value="{{ old('contia_reservada_c7') }}" />
            </div>

            <div class="campo_formulario">
                <label for="contia_reservada_c8">Contía reservada C8</label>
                <input id="contia_reservada_c8" name="contia_reservada_c8" type="number" min="0" step="0.01"
                    value="{{ old('contia_reservada_c8') }}" />
            </div>

            <div class="campo_formulario">
                <label for="contia_reservada_c31">Contía reservada C31</label>
                <input id="contia_reservada_c31" name="contia_reservada_c31" type="number" min="0" step="0.01"
                    value="{{ old('contia_reservada_c31') }}" />
            </div>

            <div class="campo_formulario">
                <label for="enviado_sede">Enviado á sede</label>
                <select id="enviado_sede" name="enviado_sede">
                    <option value="">Sen indicar</option>
                    <option value="1" @selected(old('enviado_sede') === '1')>Si</option>
                    <option value="0" @selected(old('enviado_sede') === '0')>Non</option>
                </select>
            </div>

            <div class="campo_formulario">
                <label for="lista_espera">Lista de espera</label>
                <select id="lista_espera" name="lista_espera">
                    <option value="">Sen indicar</option>
                    <option value="1" @selected(old('lista_espera') === '1')>Si</option>
                    <option value="0" @selected(old('lista_espera') === '0')>Non</option>
                </select>
            </div>

            <input class="boton_formulario" type="submit" value="Crear solicitude" />
        </form>
    </section>

    <script src="{{ asset('js/solicitude_form.js') }}"></script>
@endsection

