<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entidade;

class EntidadeController extends Controller
{
    public function index(): View
    {
        $entidades = Entidade::all();
        return view("layouts._partials.entidades", compact("entidades"));
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
