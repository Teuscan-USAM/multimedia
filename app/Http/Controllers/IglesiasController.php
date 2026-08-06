<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\Http\Request;

class IglesiasController extends Controller
{
    public function index()
    {
        $titulo = 'Iglesias';
        $items = Iglesia::orderBy('nombre')->get();
        return view('modules.iglesias.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Crear iglesia';
        return view('modules.iglesias.create', compact('titulo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'ciudad' => 'nullable|string|max:100',
            'responsable' => 'nullable|string|max:255',
        ]);

        Iglesia::create($data);
        return to_route('iglesias.index')->with('success', 'Iglesia creada con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar iglesia';
        $item = Iglesia::findOrFail($id);
        return view('modules.iglesias.edit', compact('titulo', 'item'));
    }

    public function update(Request $request, string $id)
    {
        $item = Iglesia::findOrFail($id);
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'ciudad' => 'nullable|string|max:100',
            'responsable' => 'nullable|string|max:255',
        ]);

        $item->update($data);
        return to_route('iglesias.index')->with('success', 'Iglesia actualizada con éxito.');
    }

    public function destroy(string $id)
    {
        $item = Iglesia::findOrFail($id);
        $item->delete();
        return to_route('iglesias.index')->with('success', 'Iglesia eliminada con éxito.');
    }
}

