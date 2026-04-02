@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <ul class="lista_elementos">
                @forelse ($solicitudes as $solicitude)
                    <li class="fila_elemento fila_elemento_solicitude">
                        <button class="boton_detalle_solicitude" type="button" data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                            <span>#{{ $solicitude->id }}</span>
                            <span>Solicitante: {{ $solicitude->solicitante?->nome }}</span>
                            <span>CIF|NIF: {{ $solicitude->solicitante?->nif_cif }}</span>
                        </button>
                        @include('layouts._partials.tarxeta_solicitude', ['solicitude' => $solicitude])
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
        {{ $solicitudes->links() }}
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
