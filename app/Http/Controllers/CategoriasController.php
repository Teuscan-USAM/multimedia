<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanza;
use App\Models\Iglesia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriasController extends Controller
{
    public function index()
    {
        $titulo = 'Categorías';

        $query = CategoriaFinanza::query()->with('iglesia')->orderBy('tipo')->orderBy('nombre');

        // Pastor: solo categorías de sus iglesias
        if (Auth::user()->rol === 'pastor') {
            $ids = Auth::user()->iglesiasPastor()->pluck('iglesias.id');
            $query->whereIn('iglesia_id', $ids);
        }

        $items = $query->get();
        return view('modules.categorias_finanzas.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Crear categoría';
        $iglesias = $this->iglesiasDisponibles();
        return view('modules.categorias_finanzas.create', compact('titulo', 'iglesias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'iglesia_id' => 'required|integer|exists:iglesias,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ingreso,egreso',
        ]);

        $this->autorizarIglesia($data['iglesia_id']);

        CategoriaFinanza::create($data);
        return to_route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar categoría';
        $item = CategoriaFinanza::findOrFail($id);
        $this->autorizarIglesia($item->iglesia_id);
        $iglesias = $this->iglesiasDisponibles();
        return view('modules.categorias_finanzas.edit', compact('titulo', 'item', 'iglesias'));
    }

    public function update(Request $request, string $id)
    {
        $item = CategoriaFinanza::findOrFail($id);
        $this->autorizarIglesia($item->iglesia_id);

        $data = $request->validate([
            'iglesia_id' => 'required|integer|exists:iglesias,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ingreso,egreso',
        ]);

        $this->autorizarIglesia($data['iglesia_id']);

        $item->update($data);
        return to_route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    public function destroy(string $id)
    {
        $item = CategoriaFinanza::findOrFail($id);
        $this->autorizarIglesia($item->iglesia_id);
        $item->delete();
        return to_route('categorias.index')->with('success', 'Categoría eliminada con éxito.');
    }

    private function iglesiasDisponibles()
    {
        if (Auth::user()->rol === 'admin') {
            return Iglesia::orderBy('nombre')->get();
        }

        return Auth::user()->iglesiasPastor()->orderBy('nombre')->get();
    }

    private function autorizarIglesia(?int $iglesiaId): void
    {
        if (Auth::user()->rol === 'admin') {
            return;
        }

        $ok = Auth::user()->iglesiasPastor()->where('iglesias.id', $iglesiaId)->exists();
        if (!$ok) {
            abort(403, 'No tienes acceso a esta iglesia.');
        }
    }
}

