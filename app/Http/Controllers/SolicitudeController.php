<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDocumento;
use App\Http\Requests\SolicitudeRequest;
use App\Http\Requests\UpdateEstadoSolicitudeRequest;
use App\Http\Requests\UpdateSolicitudeDocumentacionRequest;
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

class SolicitudeController extends Controller
{
    public function index(Request $request, SolicitudeDocumentacionService $documentacionService): View
    {
        $busqueda = trim((string) $request->query('search', ''));
        $camposOrdenables = [
            'id' => 'ID',
            'nome_solicitante' => 'Nome solicitante',
            'solicitante_nif' => 'NIF/CIF',
            'nome_entidade' => 'Entidade',
            'estado_solicitude' => 'Estado',
            'admin_nome' => 'Admin',
            'tecnico_nome' => 'Tecnico',
        ];
        $ordenPor = (string) $request->query('sort_by', 'id');
        if (!array_key_exists($ordenPor, $camposOrdenables)) {
            $ordenPor = 'id';
        }

        $direccionSolicitada = strtolower((string) $request->query('sort_dir', 'desc'));
        $direccion = in_array($direccionSolicitada, ['asc', 'desc'], true) ? $direccionSolicitada : 'desc';

        $solicitudes = Solicitude::query()
            ->with([
                'solicitante',
                'entidade',
                'usuarioAdministrativo',
                'usuarioTecnico',
                'documentacionAdministrativa',
                'documentacionTecnica',
            ])
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $like = '%' . $busqueda . '%';

                $query->where(function ($subQuery) use ($like, $busqueda) {
                    $subQuery
                        ->where('id', $busqueda)
                        ->orWhere('nome_entidade', 'like', $like)
                        ->orWhere('nome_solicitante', 'like', $like)
                        ->orWhere('estado_solicitude', 'like', $like)
                        ->orWhere('contia_reservada_c7', 'like', $like)
                        ->orWhere('contia_reservada_c8', 'like', $like)
                        ->orWhere('contia_reservada_c31', 'like', $like)
                        ->orWhereHas('solicitante', function ($solicitanteQuery) use ($like) {
                            $solicitanteQuery
                                ->where('nome', 'like', $like)
                                ->orWhere('nif_cif', 'like', $like)
                                ->orWhere('email', 'like', $like)
                                ->orWhere('cidade', 'like', $like)
                                ->orWhere('provincia', 'like', $like);
                        })
                        ->orWhereHas('entidade', function ($entidadeQuery) use ($like) {
                            $entidadeQuery
                                ->where('nome', 'like', $like)
                                ->orWhere('cif', 'like', $like);
                        })
                        ->orWhereHas('usuarioAdministrativo', function ($usuarioAdminQuery) use ($like) {
                            $usuarioAdminQuery->where('nome', 'like', $like);
                        })
                        ->orWhereHas('usuarioTecnico', function ($usuarioTecnicoQuery) use ($like) {
                            $usuarioTecnicoQuery->where('nome', 'like', $like);
                        })
                        ->orWhereHas('documentacionAdministrativa', function ($documentacionAdministrativaQuery) use ($like) {
                            $documentacionAdministrativaQuery
                                ->where('estado_formulario_solicitud', 'like', $like)
                                ->orWhere('estado_documento_identificativo', 'like', $like)
                                ->orWhere('estado_acreditacion_representacion', 'like', $like)
                                ->orWhere('estado_certificado_aeat', 'like', $like)
                                ->orWhere('estado_certificado_seguridad_social', 'like', $like)
                                ->orWhere('estado_declaracion_responsable', 'like', $like)
                                ->orWhere('estado_datos_bancarios', 'like', $like)
                                ->orWhere('estado_escritura_constitucion', 'like', $like);
                        })
                        ->orWhereHas('documentacionTecnica', function ($documentacionTecnicaQuery) use ($like) {
                            $documentacionTecnicaQuery
                                ->where('estado_memoria_tecnica', 'like', $like)
                                ->orWhere('estado_presupuesto', 'like', $like)
                                ->orWhere('estado_ofertas_proveedores', 'like', $like)
                                ->orWhere('estado_planos', 'like', $like)
                                ->orWhere('estado_estudio_energetico', 'like', $like)
                                ->orWhere('estado_fichas_tecnicas', 'like', $like)
                                ->orWhere('estado_licencias', 'like', $like)
                                ->orWhere('estado_cronograma', 'like', $like);
                        });
                });
            });

        if ($ordenPor === 'solicitante_nif') {
            $solicitudes->orderBy(
                Solicitante::select('nif_cif')
                    ->whereColumn('solicitantes.id', 'solicitudes.id_solicitante')
                    ->limit(1),
                $direccion
            );
        } elseif ($ordenPor === 'admin_nome') {
            $solicitudes->orderBy(
                UsuarioAdministrativo::select('nome')
                    ->whereColumn('usuario_administrativos.id', 'solicitudes.id_usuario_admin')
                    ->limit(1),
                $direccion
            );
        } elseif ($ordenPor === 'tecnico_nome') {
            $solicitudes->orderBy(
                UsuarioTecnico::select('nome')
                    ->whereColumn('usuario_tecnicos.id', 'solicitudes.id_usuario_tecnico')
                    ->limit(1),
                $direccion
            );
        } else {
            $solicitudes->orderBy($ordenPor, $direccion);
        }

        $solicitudes = $solicitudes
            ->paginate(10)
            ->withQueryString();

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

        return view("layouts._partials.solicitude", compact("solicitudes", "documentacionPorSolicitude", "estadosDocumento", "usuariosAdministrativos", "usuariosTecnicos", 'busqueda', 'camposOrdenables', 'ordenPor', 'direccion'));
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

    public function updateDocumentacion(UpdateSolicitudeDocumentacionRequest $request, Solicitude $solicitude): RedirectResponse
    {
        $camposTecnicos = UpdateSolicitudeDocumentacionRequest::camposTecnicos();
        $camposAdministrativos = UpdateSolicitudeDocumentacionRequest::camposAdministrativos();

        $validated = $request->validated();

        $motivosEmenda = $validated['motivos_emenda'] ?? [];

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

    public function updateEstado(UpdateEstadoSolicitudeRequest $request, Solicitude $solicitude): RedirectResponse
    {
        $solicitude->estado_solicitude = $request->input('estado_solicitude');
        $solicitude->save();

        return redirect()
            ->route('solicitude.listado', ['open_dialog' => 'detalle-solicitude-' . $solicitude->id])
            ->with('success', 'Estado da solicitude actualizado correctamente.');
    }
}
