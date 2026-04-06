<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emenda;
use App\Models\Solicitude;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmendaController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim((string) $request->query('search', ''));

        $emendas = Emenda::query()
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
            })
            ->orderByDesc('id')
            ->get();

        return view('layouts._partials.emendas', compact('emendas', 'busqueda'));
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
