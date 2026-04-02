<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntidadeRequest;
use Illuminate\View\View;
use App\Models\Entidade;

class EntidadeController extends Controller
{
    public function index(): View
    {
        $entidades = Entidade::paginate(15);
        return view("layouts._partials.entidades", compact("entidades"));
    }

    public function create(): View
    {
        return view("forms.entidadecrear");
    }

    public function store(EntidadeRequest $request)
    {
        $entidade = new Entidade();
        $entidade->fill($request->all());
        $entidade->save();
        return redirect()->route("entidade.listado")->with("success","200");
    }
}
