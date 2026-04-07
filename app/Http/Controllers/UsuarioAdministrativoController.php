<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\UsuarioAdministrativo;

class UsuarioAdministrativoController extends Controller
{
    public function index(): View
    {
        $usuariosAdministrativos = UsuarioAdministrativo::all();
        return view("layouts._partials.usuarioadministrativo", compact("usuariosAdministrativos"));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
}
