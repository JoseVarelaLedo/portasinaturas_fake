<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitanteRequest;
use Illuminate\View\View;
use App\Models\Solicitante;

class SolicitanteController extends Controller
{
    public function index(): View
    {
        $solicitantes = Solicitante::all();
        return view ("layouts._partials.solicitante", compact("solicitantes"));
    }
    public function create(): View
    {
        return view('forms.solicitantecrear');
    }

    public function store(SolicitanteRequest $request)
    {
        $solicitante = new Solicitante();
        $solicitante->fill($request->all());
        $solicitante->save();
        return redirect()->route('solicitante.listado')->with('success','200');
    }
}
