<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $solicitante = new Solicitante();
        $solicitante->nome = $request->nome;
        $solicitante->nif_cif = $request->nif_cif;
        $solicitante->save();
        return redirect()->route('solicitante.listado')->with('success','200');
    }
}
