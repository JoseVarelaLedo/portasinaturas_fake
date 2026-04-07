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
        $camposOrdenables = [
            'nome' => 'Nome',
            'cif' => 'CIF',
        ];
        $ordenPor = (string) $request->query('sort_by', 'nome');
        if (!array_key_exists($ordenPor, $camposOrdenables)) {
            $ordenPor = 'nome';
        }

        $direccion = strtolower((string) $request->query('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $entidades = Entidade::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $like = '%' . $busqueda . '%';

                $query->where(function ($subQuery) use ($like) {
                    $subQuery
                        ->where('nome', 'like', $like)
                        ->orWhere('cif', 'like', $like);
                });
            })
            ->orderBy($ordenPor, $direccion)
            ->paginate(15)
            ->withQueryString();

        return view("layouts._partials.entidades", compact('entidades', 'busqueda', 'camposOrdenables', 'ordenPor', 'direccion'));
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
