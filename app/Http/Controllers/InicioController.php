<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        $anuncios = Anuncio::where('estado', 1)->get();
        return view('inicio.index', compact('anuncios'));
    }

    public function jovenes()
    {
        $anuncios = Anuncio::where('estado', 1)->get();
        return view('inicio.jovenes', compact('anuncios'));
    }

    public function escueladominical()
    {
        $anuncios = Anuncio::where('estado', 1)->get();
        return view('inicio.escueladominical', compact('anuncios'));
    }
}