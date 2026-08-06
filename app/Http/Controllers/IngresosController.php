<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanza;
use App\Models\Departamento;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngresosController extends Controller
{
    public function index()
    {
        $titulo = 'Ingresos';
        $departamento = Departamento::where('miembro_id', Auth::id())->with('iglesia')->first();

        $items = $departamento
            ? Ingreso::where('departamento_id', $departamento->id)->with('categoria')->orderByDesc('fecha')->get()
            : collect();

        return view('modules.ingresos.index', compact('titulo', 'departamento', 'items'));
    }

    public function create()
    {
        $titulo = 'Registrar ingreso';
        $departamento = Departamento::where('miembro_id', Auth::id())->with('iglesia')->firstOrFail();

        $categorias = CategoriaFinanza::where('tipo', 'ingreso')
            ->where('iglesia_id', $departamento->iglesia_id)
            ->orderBy('nombre')
            ->get();

        return view('modules.ingresos.create', compact('titulo', 'departamento', 'categorias'));
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

        // Validar que la categoría pertenezca a la iglesia del departamento y sea de tipo ingreso
        $ok = CategoriaFinanza::where('id', $data['categoria_id'])
            ->where('tipo', 'ingreso')
            ->where('iglesia_id', $departamento->iglesia_id)
            ->exists();
        if (!$ok) {
            return back()->with('error', 'Categoría inválida para tu iglesia.')->withInput();
        }

        Ingreso::create([
            'departamento_id' => $departamento->id,
            'categoria_id' => $data['categoria_id'],
            'user_id' => Auth::id(),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'monto' => $data['monto'],
            'fecha' => $data['fecha'],
        ]);

        return to_route('ingresos.index')->with('success', 'Ingreso registrado con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar ingreso';
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();

        $item = Ingreso::where('departamento_id', $departamento->id)->findOrFail($id);
        $categorias = CategoriaFinanza::where('tipo', 'ingreso')
            ->where('iglesia_id', $departamento->iglesia_id)
            ->orderBy('nombre')
            ->get();

        return view('modules.ingresos.edit', compact('titulo', 'departamento', 'item', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();
        $item = Ingreso::where('departamento_id', $departamento->id)->findOrFail($id);

        $data = $request->validate([
            'categoria_id' => 'required|integer|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'monto' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
        ]);

        $ok = CategoriaFinanza::where('id', $data['categoria_id'])
            ->where('tipo', 'ingreso')
            ->where('iglesia_id', $departamento->iglesia_id)
            ->exists();
        if (!$ok) {
            return back()->with('error', 'Categoría inválida para tu iglesia.')->withInput();
        }

        $item->update($data);
        return to_route('ingresos.index')->with('success', 'Ingreso actualizado con éxito.');
    }

    public function destroy(string $id)
    {
        $departamento = Departamento::where('miembro_id', Auth::id())->firstOrFail();
        $item = Ingreso::where('departamento_id', $departamento->id)->findOrFail($id);
        $item->delete();
        return to_route('ingresos.index')->with('success', 'Ingreso eliminado con éxito.');
    }
}

