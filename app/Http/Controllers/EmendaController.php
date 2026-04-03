<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emenda;
use App\Models\Solicitude;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmendaController extends Controller
{
    public function index(): View
    {
        $emendas = Emenda::with([
            'solicitude.solicitante',
            'solicitude.usuarioAdministrativo',
            'solicitude.usuarioTecnico',
            'remesaActual',
        ])->orderByDesc('id')->get();

        return view('layouts._partials.emendas', compact('emendas'));
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
