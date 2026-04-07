<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emenda;
use App\Models\Remesa;
use App\Models\Solicitude;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmendaController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim((string) $request->query('search', ''));
        $camposOrdenables = [
            'id' => 'ID emenda',
            'id_solicitude' => 'ID solicitude',
            'solicitante_nome' => 'Solicitante',
            'admin_nome' => 'Admin',
            'tecnico_nome' => 'Tecnico',
            'remesa_grupo' => 'Remesa',
        ];
        $ordenPor = (string) $request->query('sort_by', 'id');
        if (!array_key_exists($ordenPor, $camposOrdenables)) {
            $ordenPor = 'id';
        }

        $direccionSolicitada = strtolower((string) $request->query('sort_dir', 'desc'));
        $direccion = in_array($direccionSolicitada, ['asc', 'desc'], true) ? $direccionSolicitada : 'desc';

        $emendasQuery = Emenda::query()
            ->with([
                'solicitude.solicitante',
                'solicitude.usuarioAdministrativo',
                'solicitude.usuarioTecnico',
                'remesaActual',
            ])
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $like = '%' . $busqueda . '%';

                $query->where(function ($subQuery) use ($like, $busqueda) {
                    $subQuery
                        ->where('id', $busqueda)
                        ->orWhere('id_solicitude', 'like', $like)
                        ->orWhere('id_solicitante', 'like', $like)
                        ->orWhereHas('solicitude', function ($solicitudeQuery) use ($like, $busqueda) {
                            $solicitudeQuery
                                ->where('id', $busqueda)
                                ->orWhere('nome_entidade', 'like', $like)
                                ->orWhere('nome_solicitante', 'like', $like)
                                ->orWhere('estado_solicitude', 'like', $like)
                                ->orWhereHas('solicitante', function ($solicitanteQuery) use ($like) {
                                    $solicitanteQuery
                                        ->where('nome', 'like', $like)
                                        ->orWhere('nif_cif', 'like', $like)
                                        ->orWhere('email', 'like', $like);
                                })
                                ->orWhereHas('usuarioAdministrativo', function ($usuarioAdminQuery) use ($like) {
                                    $usuarioAdminQuery->where('nome', 'like', $like);
                                })
                                ->orWhereHas('usuarioTecnico', function ($usuarioTecnicoQuery) use ($like) {
                                    $usuarioTecnicoQuery->where('nome', 'like', $like);
                                });
                        })
                        ->orWhereHas('remesaActual', function ($remesaQuery) use ($like) {
                            $remesaQuery->where('remesa_grupo', 'like', $like);
                        });
                });
            });

        if ($ordenPor === 'solicitante_nome') {
            $emendasQuery->orderBy(
                Solicitude::select('nome_solicitante')
                    ->whereColumn('solicitudes.id', 'emendas.id_solicitude')
                    ->limit(1),
                $direccion
            );
        } elseif ($ordenPor === 'admin_nome') {
            $emendasQuery->orderBy(
                Solicitude::select('usuario_administrativos.nome')
                    ->leftJoin('usuario_administrativos', 'usuario_administrativos.id', '=', 'solicitudes.id_usuario_admin')
                    ->whereColumn('solicitudes.id', 'emendas.id_solicitude')
                    ->limit(1),
                $direccion
            );
        } elseif ($ordenPor === 'tecnico_nome') {
            $emendasQuery->orderBy(
                Solicitude::select('usuario_tecnicos.nome')
                    ->leftJoin('usuario_tecnicos', 'usuario_tecnicos.id', '=', 'solicitudes.id_usuario_tecnico')
                    ->whereColumn('solicitudes.id', 'emendas.id_solicitude')
                    ->limit(1),
                $direccion
            );
        } elseif ($ordenPor === 'remesa_grupo') {
            $emendasQuery->orderBy(
                Remesa::select('remesa_grupo')
                    ->whereColumn('remesas.id_emenda', 'emendas.id')
                    ->orderByDesc('remesas.id')
                    ->limit(1),
                $direccion
            );
        } else {
            $emendasQuery->orderBy($ordenPor, $direccion);
        }

        $emendas = $emendasQuery->get();

        return view('layouts._partials.emendas', compact('emendas', 'busqueda', 'camposOrdenables', 'ordenPor', 'direccion'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_solicitude' => ['required', 'integer', 'exists:solicitudes,id'],
        ]);

        $solicitude = Solicitude::query()->findOrFail($data['id_solicitude']);

        if (!$solicitude->id_usuario_admin || !$solicitude->id_usuario_tecnico) {
            return back()->withErrors([
                'emenda' => 'A solicitude debe ter usuario administrativo e tecnico para xerar emenda.',
            ]);
        }

        Emenda::query()->create([
            'id_solicitude' => $solicitude->id,
            'id_solicitante' => $solicitude->id_solicitante,
        ]);

        return redirect()->route('emenda.listado')->with('success', 'Emenda xerada correctamente.');
    }
}
