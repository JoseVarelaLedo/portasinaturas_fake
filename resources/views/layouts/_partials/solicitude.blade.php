@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <ul class="lista_elementos">
                @forelse ($solicitudes as $solicitude)
                    <li class="fila_elemento fila_elemento_solicitude">
                        <button class="boton_detalle_solicitude" type="button" data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                            <span>#{{ $solicitude->id }}</span>
                            <span>{{ $solicitude->solicitante?->nome ?? $solicitude->nome_solicitante ?? 'Sen solicitante' }}</span>
                        </button>

                        <dialog class="dialog_solicitude" id="detalle-solicitude-{{ $solicitude->id }}">
                            <article class="tarxeta_solicitude">
                                <header class="tarxeta_solicitude_header">
                                    <h3>Solicitude #{{ $solicitude->id }}</h3>
                                    <button class="boton_peche_dialog" type="button" data-close-dialog>&times;</button>
                                </header>

                                <div class="tarxeta_solicitude_grid">
                                    <p><strong>Solicitante:</strong> {{ $solicitude->solicitante?->nome ?? $solicitude->nome_solicitante ?? 'N/D' }}</p>
                                    <p><strong>Nome solicitante (rexistrado):</strong> {{ $solicitude->nome_solicitante ?? 'N/D' }}</p>
                                    <p><strong>Entidade:</strong> {{ $solicitude->entidade?->nome ?? $solicitude->nome_entidade ?? 'N/D' }}</p>
                                    <p><strong>Nome entidade (rexistrado):</strong> {{ $solicitude->nome_entidade ?? 'N/D' }}</p>
                                    <p><strong>Usuario administrativo:</strong> {{ $solicitude->usuarioAdministrativo?->nome ?? 'Sen asignar' }}</p>
                                    <p><strong>Usuario técnico:</strong> {{ $solicitude->usuarioTecnico?->nome ?? 'Sen asignar' }}</p>
                                    <p><strong>Estado documentación:</strong> {{ $solicitude->estado_doc ?? 'Sen indicar' }}</p>
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
                            </article>
                        </dialog>
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-dialog-id]').forEach((button) => {
            button.addEventListener('click', () => {
                const dialogId = button.getAttribute('data-dialog-id');
                const dialog = document.getElementById(dialogId);

                if (dialog && typeof dialog.showModal === 'function') {
                    dialog.showModal();
                }
            });
        });

        document.querySelectorAll('[data-close-dialog]').forEach((button) => {
            button.addEventListener('click', () => {
                const dialog = button.closest('dialog');
                if (dialog) {
                    dialog.close();
                }
            });
        });

        document.querySelectorAll('.dialog_solicitude').forEach((dialog) => {
            dialog.addEventListener('click', (event) => {
                const rect = dialog.getBoundingClientRect();
                const clickedOutside =
                    event.clientX < rect.left ||
                    event.clientX > rect.right ||
                    event.clientY < rect.top ||
                    event.clientY > rect.bottom;

                if (clickedOutside) {
                    dialog.close();
                }
            });
        });
    </script>
@endsection
