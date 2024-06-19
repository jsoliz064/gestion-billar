<?php

namespace App\Http\Controllers;

use App\Models\Mesa;

class MesaController extends Controller
{
    public function index()
    {
        return view('cruds.mesa.index');
    }

    public function getAll()
    {
        $mesas = Mesa::all();
        return $mesas;
    }
}
