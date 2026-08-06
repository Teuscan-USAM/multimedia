<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        $anuncios = Anuncio::where('estado', 1)->get();
        return view('inicio', compact('anuncios'));
    }
}