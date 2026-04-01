<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Solicitude;

class SolicitudeController extends Controller
{
    public function index(): View
    {
        $solicitudes = Solicitude::all();
        return view("layouts._partials.solicitude", compact("solicitudes"));
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
