@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            <a class="enlace_decorado" href="{{ route('emenda.listado') }}">Volver ao listado de emendas</a>

            <button class="boton_detalle_solicitude" type="button" data-dialog-id="detalle-solicitude-{{ $solicitude->id }}">
                Abrir tarxeta da solicitude #{{ $solicitude->id }}
            </button>

            @include('layouts._partials.tarxeta_solicitude', [
                'solicitude' => $solicitude,
                'usuariosAdministrativos' => $usuariosAdministrativos,
                'usuariosTecnicos' => $usuariosTecnicos,
            ])
        </div>
    </section>

    <script src="{{ asset('js/solicitudes_dialog.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dialog = document.getElementById('detalle-solicitude-{{ $solicitude->id }}');
            if (dialog && !dialog.open) {
                dialog.showModal();
            }
        });
    </script>
@endsection
