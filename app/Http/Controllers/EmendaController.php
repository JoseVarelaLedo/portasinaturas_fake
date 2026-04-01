<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emenda;
use Illuminate\View\View;

class EmendaController extends Controller
{
    public function index(): View
    {
        $emendas = Emenda::all();
        return view('layouts._partials.emendas', compact('emendas'));
    }
    public function create()
    {
         return view('forms.emendacrear');
    }
    public function store()
    {
        //TODO
    }
}
