@extends('index')

@section('list')
    <section class="contedor_decorado contedor_listado">
        <div class="contedor_contido_decorado">
            @if (session('success'))
                <div class="campo_formulario" style="color:#166534;">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <ul class="lista_elementos">
                @forelse ($remesasAgrupadas as $remesaAgrupada)
                    <li class="fila_elemento fila_elemento_remesa_agrupada" id="{{ $remesaAgrupada['anchor'] }}">
                        <strong>{{ $remesaAgrupada['codigo'] }}</strong>
                        | Emendas: {{ count($remesaAgrupada['remesas']) }}
                        | Xerada: {{ $remesaAgrupada['creadaEn']?->format('d/m/Y H:i') ?? 'N/D' }}

                        <div class="bloques_remesa_usuarios">
                            @foreach ($remesaAgrupada['bloquesUsuarios'] as $bloqueUsuarios)
                                <section class="bloque_remesa_usuario">
                                    <p>
                                        <strong>Usuario administrativo:</strong> {{ $bloqueUsuarios['admin'] }}
                                        | <strong>Usuario tecnico:</strong> {{ $bloqueUsuarios['tecnico'] }}
                                    </p>

                                    <ul>
                                        @foreach ($bloqueUsuarios['remesas'] as $remesa)
                                            <li>
                                                Emenda #{{ $remesa->id_emenda }}
                                                | Solicitude #{{ $remesa->emenda?->id_solicitude ?? 'N/D' }}
                                                | Solicitante: {{ $remesa->emenda?->solicitude?->solicitante?->nome ?? 'N/D' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </section>
                            @endforeach
                        </div>
                    </li>
                @empty
                    <p><em>Sen datos</em></p>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
