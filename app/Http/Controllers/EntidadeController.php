<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntidadeRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entidade;

class EntidadeController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim((string) $request->query('search', ''));

        $entidades = Entidade::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $like = '%' . $busqueda . '%';

                $query->where(function ($subQuery) use ($like) {
                    $subQuery
                        ->where('nome', 'like', $like)
                        ->orWhere('cif', 'like', $like);
                });
            })
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view("layouts._partials.entidades", compact('entidades', 'busqueda'));
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
