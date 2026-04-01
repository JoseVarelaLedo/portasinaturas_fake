<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Remesa;

class RemesaController extends Controller
{
    public function index(): View
    {
        $remesas = Remesa::all();
        return view("layouts._partials.remesa", compact("remesas"));
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
