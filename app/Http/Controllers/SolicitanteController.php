<?php

namespace App\Http\Controllers;

use App\Enums\ProvinciaGalicia;
use App\Http\Requests\SolicitanteRequest;
use Illuminate\View\View;
use App\Models\Solicitante;

class SolicitanteController extends Controller
{
    public function index(): View
    {
        $solicitantes = Solicitante::paginate(15);
        return view ("layouts._partials.solicitante", compact("solicitantes"));
    }
    public function create(): View
    {
        $provinciasGalicia = ProvinciaGalicia::values();

        return view('forms.solicitantecrear', compact('provinciasGalicia'));
    }

    public function store(SolicitanteRequest $request)
    {
        $solicitante = new Solicitante();
        $solicitante->fill($request->validated());
        $solicitante->save();
        return redirect()->route('solicitante.listado')->with('success','200');
    }
}
