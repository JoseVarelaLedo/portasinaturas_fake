 <dialog class="dialog_solicitude" id="detalle-solicitude-{{ $solicitude->id }}">
     <article class="tarxeta_solicitude">
         <header class="tarxeta_solicitude_header">
             <h3>Solicitude #{{ $solicitude->id }}</h3>
             <button class="boton_peche_dialog" type="button" data-close-dialog>&times;</button>
         </header>

         <div class="tarxeta_solicitude_grid">
             <p><strong>Solicitante:</strong>
                 {{ $solicitude->solicitante?->nome ?? ($solicitude->nome_solicitante ?? 'N/D') }}</p>
             <p><strong>Nome solicitante (rexistrado):</strong> {{ $solicitude->nome_solicitante ?? 'N/D' }}</p>
             <p><strong>Entidade:</strong> {{ $solicitude->entidade?->nome ?? ($solicitude->nome_entidade ?? 'N/D') }}</p>
             <p><strong>Nome entidade (rexistrado):</strong> {{ $solicitude->nome_entidade ?? 'N/D' }}</p>
             <div class="campo_formulario">
                 <label for="id_usuario_admin-{{ $solicitude->id }}"><strong>Usuario administrativo</strong></label>
                 <select id="id_usuario_admin-{{ $solicitude->id }}" name="id_usuario_admin" form="form-usuarios-{{ $solicitude->id }}">
                     <option value="">Sen asignar</option>
                     @foreach ($usuariosAdministrativos as $usuarioAdministrativo)
                         <option value="{{ $usuarioAdministrativo->id }}"
                             @selected((int) $solicitude->id_usuario_admin === (int) $usuarioAdministrativo->id)>
                             {{ $usuarioAdministrativo->nome }}
                         </option>
                     @endforeach
                 </select>
             </div>
             <div class="campo_formulario">
                 <label for="id_usuario_tecnico-{{ $solicitude->id }}"><strong>Usuario técnico</strong></label>
                 <select id="id_usuario_tecnico-{{ $solicitude->id }}" name="id_usuario_tecnico" form="form-usuarios-{{ $solicitude->id }}">
                     <option value="">Sen asignar</option>
                     @foreach ($usuariosTecnicos as $usuarioTecnico)
                         <option value="{{ $usuarioTecnico->id }}"
                             @selected((int) $solicitude->id_usuario_tecnico === (int) $usuarioTecnico->id)>
                             {{ $usuarioTecnico->nome }}
                         </option>
                     @endforeach
                 </select>
             </div>
            <p><strong>Estado solicitude:</strong> {{ $solicitude->estado_solicitude ?? 'Sen indicar' }}</p>
             <p><strong>Contía C7:</strong> {{ $solicitude->contia_reservada_c7 ?? '0' }}</p>
             <p><strong>Contía C8:</strong> {{ $solicitude->contia_reservada_c8 ?? '0' }}</p>
             <p><strong>Contía C31:</strong> {{ $solicitude->contia_reservada_c31 ?? '0' }}</p>
             <p><strong>Enviado a sede:</strong>
                 @if (is_null($solicitude->enviado_sede))
                     Sen indicar
                 @elseif ($solicitude->enviado_sede)
                     Si
                 @else
                     Non
                 @endif
             </p>
             <p><strong>Lista espera:</strong>
                 @if (is_null($solicitude->lista_espera))
                     Sen indicar
                 @elseif ($solicitude->lista_espera)
                     Si
                 @else
                     Non
                 @endif
             </p>
             <p><strong>Data creación:</strong> {{ $solicitude->created_at?->format('d/m/Y H:i') ?? 'N/D' }}</p>
             <p><strong>Data actualización:</strong> {{ $solicitude->updated_at?->format('d/m/Y H:i') ?? 'N/D' }}</p>
         </div>

         <form id="form-usuarios-{{ $solicitude->id }}" method="POST"
             action="{{ route('solicitude.usuarios.update', ['solicitude' => $solicitude->id]) }}">
             @csrf
             <div class="tarxeta_solicitude_footer" style="margin-top: 0.75rem;">
                 <button class="boton_formulario" type="submit">Gardar usuarios</button>
             </div>
         </form>

         <footer class="tarxeta_solicitude_footer">
             <button class="boton_secundario_dialog" type="button"
                 data-switch-dialog="detalle-documentacion-{{ $solicitude->id }}">
                 Ver documentación
             </button>
         </footer>
     </article>
 </dialog>
