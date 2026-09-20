<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnunciosController extends Controller
{
    public function index()
    {
        $anuncios = Anuncio::latest()->get();
        return view('modules/anuncios/index', compact('anuncios'));
    }

    public function create()
    {
        return view('modules/anuncios/create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'estado' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('anuncios', 'public');
        }

        $data['estado'] = $request->boolean('estado');
        Anuncio::create($data);

        return redirect()->route('anuncios.index')->with('success', 'Anuncio publicado correctamente.');
    }

    public function image(Anuncio $anuncio)
    {
        abort_unless($anuncio->imagen && Storage::disk('public')->exists($anuncio->imagen), 404);

        return response()->file(Storage::disk('public')->path($anuncio->imagen));
    }

    public function destroy(Anuncio $anuncio)
    {
        if ($anuncio->imagen) {
            Storage::disk('public')->delete($anuncio->imagen);
        }

        $anuncio->delete();
        return redirect()->route('anuncios.index')->with('success', 'Anuncio eliminado correctamente.');
    }
}