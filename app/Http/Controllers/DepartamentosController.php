<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    public function index()
    {
        $titulo = 'Departamentos';
        $items = Departamento::where('pastor_id', Auth::id())
            ->with('iglesia', 'miembro')
            ->orderBy('nombre')
            ->get();

        return view('modules.departamentos.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Crear departamento';
        $iglesias = Auth::user()->iglesiasPastor()->orderBy('nombre')->get();
        $miembros = User::where('rol', 'miembro')->where('activo', true)->orderBy('name')->get();
        return view('modules.departamentos.create', compact('titulo', 'iglesias', 'miembros'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'iglesia_id' => 'required|integer|exists:iglesias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'miembro_id' => 'nullable|integer|exists:users,id',
        ]);

        // Asegurar que el pastor tenga asignada esa iglesia
        $permitida = Auth::user()->iglesiasPastor()->where('iglesias.id', $data['iglesia_id'])->exists();
        if (!$permitida) {
            abort(403, 'No puedes crear departamentos en una iglesia no asignada.');
        }

        Departamento::create([
            'iglesia_id' => $data['iglesia_id'],
            'pastor_id' => Auth::id(),
            'miembro_id' => $data['miembro_id'] ?? null,
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
        ]);

        return to_route('departamentos.index')->with('success', 'Departamento creado con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar departamento';
        $item = Departamento::where('pastor_id', Auth::id())->findOrFail($id);
        $iglesias = Auth::user()->iglesiasPastor()->orderBy('nombre')->get();
        $miembros = User::where('rol', 'miembro')->where('activo', true)->orderBy('name')->get();
        return view('modules.departamentos.edit', compact('titulo', 'item', 'iglesias', 'miembros'));
    }

    public function update(Request $request, string $id)
    {
        $item = Departamento::where('pastor_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'iglesia_id' => 'required|integer|exists:iglesias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'miembro_id' => 'nullable|integer|exists:users,id',
        ]);

        $permitida = Auth::user()->iglesiasPastor()->where('iglesias.id', $data['iglesia_id'])->exists();
        if (!$permitida) {
            abort(403, 'No puedes mover el departamento a una iglesia no asignada.');
        }

        $item->update([
            'iglesia_id' => $data['iglesia_id'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'miembro_id' => $data['miembro_id'] ?? null,
        ]);

        return to_route('departamentos.index')->with('success', 'Departamento actualizado con éxito.');
    }

    public function destroy(string $id)
    {
        $item = Departamento::where('pastor_id', Auth::id())->findOrFail($id);
        $item->delete();
        return to_route('departamentos.index')->with('success', 'Departamento eliminado con éxito.');
    }

    public function asignarMiembro(Request $request, string $id)
    {
        $item = Departamento::where('pastor_id', Auth::id())->findOrFail($id);
        $data = $request->validate([
            'miembro_id' => 'required|integer|exists:users,id',
        ]);

        $miembro = User::where('rol', 'miembro')->findOrFail($data['miembro_id']);
        $item->miembro_id = $miembro->id;
        $item->save();

        return back()->with('success', 'Miembro asignado con éxito.');
    }
}

