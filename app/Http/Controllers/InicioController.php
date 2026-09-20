<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        $anunciosJovenes = Anuncio::where('estado', 1)->where('seccion', 'jovenes')->latest()->get();
        $anunciosEscuela = Anuncio::where('estado', 1)->where('seccion', 'escuela_dominical')->latest()->get();
        return view('inicio.index', compact('anunciosJovenes', 'anunciosEscuela'));
    }

    public function jovenes()
    {
        $anuncios = Anuncio::where('estado', 1)->where('seccion', 'jovenes')->latest()->get();
        return view('inicio.jovenes', compact('anuncios'));
    }

    public function escueladominical()
    {
        $anuncios = Anuncio::where('estado', 1)->where('seccion', 'escuela_dominical')->latest()->get();
        return view('inicio.escueladominical', compact('anuncios'));
    }
}