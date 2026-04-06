<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDocumento;
use App\Http\Requests\SolicitudeRequest;
use App\Models\DocumentacionAdministrativa;
use App\Models\DocumentacionTecnica;
use App\Models\Entidade;
use App\Models\Solicitante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Solicitude;
use App\Models\UsuarioAdministrativo;
use App\Models\UsuarioTecnico;
use App\Services\SolicitudeDocumentacionService;
use Illuminate\Validation\ValidationException;

class SolicitudeController extends Controller
{
    public function index(SolicitudeDocumentacionService $documentacionService): View
    {
        $solicitudes = Solicitude::with([
            'solicitante',
            'entidade',
            'usuarioAdministrativo',
            'usuarioTecnico',
            'documentacionAdministrativa',
            'documentacionTecnica',
        ])->orderByDesc('id')->paginate(10);

        $documentacionPorSolicitude = $documentacionService->buildForCollection($solicitudes->getCollection());
        $usuariosAdministrativos = UsuarioAdministrativo::query()->orderBy('nome')->get(['id', 'nome']);
        $usuariosTecnicos = UsuarioTecnico::query()->orderBy('nome')->get(['id', 'nome']);
        $estadosDocumento = collect(EstadoDocumento::cases())
            ->map(fn (EstadoDocumento $estado): array => [
                'value' => $estado->value,
                'label' => $estado->label(),
            ])
            ->values()
            ->all();

        return view("layouts._partials.solicitude", compact("solicitudes", "documentacionPorSolicitude", "estadosDocumento", "usuariosAdministrativos", "usuariosTecnicos"));
    }

    public function create(): View|RedirectResponse
    {
        $solicitanteId = request()->integer('solicitante_id');

        if ($solicitanteId <= 0) {
            return redirect()->route('solicitante.listado');
        }

        $solicitante = Solicitante::findOrFail($solicitanteId);

        $entidades = Entidade::orderBy('nome')->get();
        $usuariosAdministrativos = UsuarioAdministrativo::orderBy('nome')->get();
        $usuariosTecnicos = UsuarioTecnico::orderBy('nome')->get();

        return view('forms.solicitudecrear', [
            'solicitante' => $solicitante,
            'entidades' => $entidades,
            'usuariosAdministrativos' => $usuariosAdministrativos,
            'usuariosTecnicos' => $usuariosTecnicos,
        ]);
    }

    public function store(SolicitudeRequest $request)
    {
        $solicitude = new Solicitude();
        $solicitude->fill($request->validated());
        $solicitude->save();

        return redirect()->route('solicitude.listado')->with('success', '200');
    }

    public function tarxeta(Solicitude $solicitude): View
    {
        $solicitude->load([
            'solicitante',
            'entidade',
            'usuarioAdministrativo',
            'usuarioTecnico',
        ]);

        $usuariosAdministrativos = UsuarioAdministrativo::query()->orderBy('nome')->get(['id', 'nome']);
        $usuariosTecnicos = UsuarioTecnico::query()->orderBy('nome')->get(['id', 'nome']);

        return view('layouts._partials.solicitude_tarxeta', compact('solicitude', 'usuariosAdministrativos', 'usuariosTecnicos'));
    }

    public function updateUsuarios(Request $request, Solicitude $solicitude): RedirectResponse
    {
        $validated = $request->validate([
            'id_usuario_admin' => ['nullable', 'integer', 'exists:usuario_administrativos,id'],
            'id_usuario_tecnico' => ['nullable', 'integer', 'exists:usuario_tecnicos,id'],
        ]);

        $solicitude->fill([
            'id_usuario_admin' => $validated['id_usuario_admin'] ?? null,
            'id_usuario_tecnico' => $validated['id_usuario_tecnico'] ?? null,
        ]);
        $solicitude->save();

        return redirect()
            ->route('solicitude.listado', ['open_dialog' => 'detalle-solicitude-' . $solicitude->id])
            ->with('success', 'Usuarios da solicitude actualizados correctamente.');
    }

    public function updateDocumentacion(Request $request, Solicitude $solicitude): RedirectResponse
    {
        $valoresEstados = collect(EstadoDocumento::cases())
            ->map(fn (EstadoDocumento $estado) => $estado->value)
            ->all();

        $camposTecnicos = $this->camposTecnicosDocumentacion();
        $camposAdministrativos = $this->camposAdministrativosDocumentacion();

        $rules = $this->buildDocumentacionRules(
            array_merge($camposTecnicos, $camposAdministrativos),
            $valoresEstados
        );

        $validated = $request->validate($rules);

        $motivosEmenda = $validated['motivos_emenda'] ?? [];

        $this->validateMotivosEmenda(
            $validated,
            $motivosEmenda,
            array_merge($camposTecnicos, $camposAdministrativos)
        );

        $datosTecnicos = array_intersect_key($validated, array_flip($camposTecnicos));
        $datosAdministrativos = array_intersect_key($validated, array_flip($camposAdministrativos));

        if ($datosTecnicos !== []) {
            $documentacionTecnica = DocumentacionTecnica::query()->firstOrNew([
                'solicitude_id' => $solicitude->id,
            ]);

            $motivosTecnicos = $this->buildMotivosEmendaForCampos($datosTecnicos, $motivosEmenda, $camposTecnicos);

            $documentacionTecnica->fill($datosTecnicos);
            $documentacionTecnica->motivos_emenda = $motivosTecnicos;
            $documentacionTecnica->solicitude_id = $solicitude->id;
            $documentacionTecnica->save();
        }

        if ($datosAdministrativos !== []) {
            $documentacionAdministrativa = DocumentacionAdministrativa::query()->firstOrNew([
                'solicitude_id' => $solicitude->id,
            ]);

            $motivosAdministrativos = $this->buildMotivosEmendaForCampos($datosAdministrativos, $motivosEmenda, $camposAdministrativos);

            $documentacionAdministrativa->fill($datosAdministrativos);
            $documentacionAdministrativa->motivos_emenda = $motivosAdministrativos;
            $documentacionAdministrativa->solicitude_id = $solicitude->id;
            $documentacionAdministrativa->save();
        }

        return redirect()->route('solicitude.listado')->with('success', 'Documentacion actualizada correctamente.');
    }

    /**
     * @return array<int, string>
     */
    private function camposTecnicosDocumentacion(): array
    {
        return [
            'estado_memoria_tecnica',
            'estado_presupuesto',
            'estado_ofertas_proveedores',
            'estado_planos',
            'estado_estudio_energetico',
            'estado_fichas_tecnicas',
            'estado_licencias',
            'estado_cronograma',
        ];
    }

    /**
     * @return array<int, string>
     */
    private function camposAdministrativosDocumentacion(): array
    {
        return [
            'estado_formulario_solicitud',
            'estado_documento_identificativo',
            'estado_acreditacion_representacion',
            'estado_certificado_aeat',
            'estado_certificado_seguridad_social',
            'estado_declaracion_responsable',
            'estado_datos_bancarios',
            'estado_escritura_constitucion',
        ];
    }

    /**
     * @param  array<int, string>  $camposDocumentacion
     * @param  array<int, string>  $valoresEstados
     * @return array<string, mixed>
     */
    private function buildDocumentacionRules(array $camposDocumentacion, array $valoresEstados): array
    {
        $rules = [];

        foreach ($camposDocumentacion as $campo) {
            $rules[$campo] = ['nullable', 'in:' . implode(',', $valoresEstados)];
        }

        $rules['motivos_emenda'] = ['nullable', 'array'];
        $rules['motivos_emenda.*'] = ['nullable', 'string', 'max:2000'];

        return $rules;
    }

    /**
     * @param  array<string, mixed>  $validated
     * @param  array<string, mixed>  $motivosEmenda
     * @param  array<int, string>  $camposDocumentacion
     */
    private function validateMotivosEmenda(array $validated, array $motivosEmenda, array $camposDocumentacion): void
    {
        $erroresMotivos = [];

        foreach ($camposDocumentacion as $campo) {
            if (($validated[$campo] ?? null) !== EstadoDocumento::EMENDAR->value) {
                continue;
            }

            $motivo = trim((string) ($motivosEmenda[$campo] ?? ''));
            if ($motivo === '') {
                $erroresMotivos['motivos_emenda.' . $campo] = 'Debes indicar o motivo da emenda para este campo.';
            }
        }

        if ($erroresMotivos !== []) {
            throw ValidationException::withMessages($erroresMotivos);
        }
    }

    /**
     * @param  array<string, mixed>  $datosDocumentacion
     * @param  array<string, mixed>  $motivosEmenda
     * @param  array<int, string>  $camposDocumentacion
     * @return array<string, string>
     */
    private function buildMotivosEmendaForCampos(array $datosDocumentacion, array $motivosEmenda, array $camposDocumentacion): array
    {
        $motivosPorCampo = [];

        foreach ($camposDocumentacion as $campo) {
            if (($datosDocumentacion[$campo] ?? null) !== EstadoDocumento::EMENDAR->value) {
                continue;
            }

            $motivo = trim((string) ($motivosEmenda[$campo] ?? ''));
            if ($motivo !== '') {
                $motivosPorCampo[$campo] = $motivo;
            }
        }

        return $motivosPorCampo;
    }
}
