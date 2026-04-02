<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudeRequest;
use App\Models\Entidade;
use App\Models\Solicitante;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Solicitude;
use App\Models\UsuarioAdministrativo;
use App\Models\UsuarioTecnico;

class SolicitudeController extends Controller
{
    public function index(): View
    {
        // $solicitudes = Solicitude::with([
        //     'solicitante',
        //     'entidade',
        //     'usuarioAdministrativo',
        //     'usuarioTecnico',
        // ])->orderBy('id', 'desc')->get();
        $solicitudes = Solicitude::paginate(10);

        return view("layouts._partials.solicitude", compact("solicitudes"));
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
}
