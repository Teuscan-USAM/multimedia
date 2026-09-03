<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanza;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        $titulo = 'Categorías';

        $items = CategoriaFinanza::query()->orderBy('tipo')->orderBy('nombre')->get();
        return view('modules.categorias_finanzas.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Crear categoría';
        return view('modules.categorias_finanzas.create', compact('titulo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ingreso,egreso',
        ]);

        CategoriaFinanza::create($data);
        return to_route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar categoría';
        $item = CategoriaFinanza::findOrFail($id);
        return view('modules.categorias_finanzas.edit', compact('titulo', 'item'));
    }

    public function update(Request $request, string $id)
    {
        $item = CategoriaFinanza::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ingreso,egreso',
        ]);

        $item->update($data);
        return to_route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    public function destroy(string $id)
    {
        $item = CategoriaFinanza::findOrFail($id);
        $item->delete();
        return to_route('categorias.index')->with('success', 'Categoría eliminada con éxito.');
    }
}

