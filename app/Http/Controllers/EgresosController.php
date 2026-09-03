<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanza;
use App\Models\Departamento;
use App\Models\Egreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EgresosController extends Controller
{
    public function index()
    {
        $titulo = 'Egresos';
        $departamento = Departamento::where('miembro_id', Auth::id())->with('iglesia')->first();

        $items = $departamento
            ? Egreso::where('departamento_id', $departamento->id)->with('categoria')->orderByDesc('fecha')->get()
            : collect();

        return view('modules.egresos.index', compact('titulo', 'departamento', 'items'));
    }

    public function create()
    {
        $titulo = 'Registrar egreso';
        $departamento = Departamento::where('miembro_id', Auth::id())->with('iglesia')->firstOrFail();

        $categorias = CategoriaFinanza::where('tipo', 'egreso')
            ->orderBy('nombre')
            ->get();

        return view('modules.egresos.create', compact('titulo', 'departamento', 'categorias'));
    }

    public function store(Request $request)
    {
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'categoria_id' => 'required|integer|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'monto' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
        ]);

        $ok = CategoriaFinanza::where('id', $data['categoria_id'])
            ->where('tipo', 'egreso')
            ->exists();
        if (!$ok) {
            return back()->with('error', 'Categoría inválida para egresos.')->withInput();
        }

        Egreso::create([
            'departamento_id' => $departamento->id,
            'categoria_id' => $data['categoria_id'],
            'user_id' => Auth::id(),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'monto' => $data['monto'],
            'fecha' => $data['fecha'],
        ]);

        return to_route('egresos.index')->with('success', 'Egreso registrado con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar egreso';
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();

        $item = Egreso::where('departamento_id', $departamento->id)->findOrFail($id);
        $categorias = CategoriaFinanza::where('tipo', 'egreso')
            ->orderBy('nombre')
            ->get();

        return view('modules.egresos.edit', compact('titulo', 'departamento', 'item', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();
        $item = Egreso::where('departamento_id', $departamento->id)->findOrFail($id);

        $data = $request->validate([
            'categoria_id' => 'required|integer|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'monto' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
        ]);

        $ok = CategoriaFinanza::where('id', $data['categoria_id'])
            ->where('tipo', 'egreso')
            ->exists();
        if (!$ok) {
            return back()->with('error', 'Categoría inválida para egresos.')->withInput();
        }

        $item->update($data);
        return to_route('egresos.index')->with('success', 'Egreso actualizado con éxito.');
    }

    public function destroy(string $id)
    {
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();
        $item = Egreso::where('departamento_id', $departamento->id)->findOrFail($id);
        $item->delete();
        return to_route('egresos.index')->with('success', 'Egreso eliminado con éxito.');
    }
}

