<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\UsuarioTecnico;

class UsuarioTecnicoController extends Controller
{
    public function index(): View
    {
        $usuariosTecnicos = UsuarioTecnico::all();
        return view ("layouts._partials.usuariotecnico", compact("usuariosTecnicos"));
    }
    public function create()
    {
        //TODO
    }

    public function store(Request $request)
    {
        //TODO
    }
}
