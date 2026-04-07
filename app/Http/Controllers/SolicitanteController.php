<?php

namespace App\Http\Controllers;

use App\Enums\ProvinciaGalicia;
use App\Http\Requests\SolicitanteRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Solicitante;

class SolicitanteController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim((string) $request->query('search', ''));
        $camposOrdenables = [
            'nome' => 'Nome',
            'nif_cif' => 'NIF/CIF',
            'email' => 'Email',
            'direccion' => 'Dirección',
            'cidade' => 'Localidade',
            'provincia' => 'Provincia',
            'codigo_postal' => 'Código postal',
            'pais' => 'País',
        ];
        $ordenPor = (string) $request->query('sort_by', 'nome');
        if (!array_key_exists($ordenPor, $camposOrdenables)) {
            $ordenPor = 'nome';
        }

        $direccion = strtolower((string) $request->query('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $solicitantes = Solicitante::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $like = '%' . $busqueda . '%';

                $query->where(function ($subQuery) use ($like) {
                    $subQuery
                        ->where('nome', 'like', $like)
                        ->orWhere('nif_cif', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('direccion', 'like', $like)
                        ->orWhere('cidade', 'like', $like)
                        ->orWhere('provincia', 'like', $like)
                        ->orWhere('codigo_postal', 'like', $like)
                        ->orWhere('pais', 'like', $like);
                });
            })
            ->orderBy($ordenPor, $direccion)
            ->paginate(15)
            ->withQueryString();

        return view("layouts._partials.solicitante", compact('solicitantes', 'busqueda', 'camposOrdenables', 'ordenPor', 'direccion'));
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
