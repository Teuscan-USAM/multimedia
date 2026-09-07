<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\DepartamentoCatalogo;
use App\Models\Iglesia;
use Illuminate\Http\Request;

class CatalogoDepartamentosController extends Controller
{
    public function index()
    {
        $titulo = 'Catálogo de departamentos';
        $items = DepartamentoCatalogo::query()
            ->withCount(['departamentos as iglesias_habilitadas_count' => function ($query) {
                $query->where('habilitado', true);
            }])
            ->orderBy('nombre')
            ->get();

        return view('modules.catalogo_departamentos.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Nuevo departamento';
        return view('modules.catalogo_departamentos.create', compact('titulo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:departamento_catalogo,nombre',
            'descripcion' => 'nullable|string|max:500',
        ]);

        DepartamentoCatalogo::create($data);

        return to_route('catalogo-departamentos.index')->with('success', 'Departamento del catálogo creado con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar departamento';
        $item = DepartamentoCatalogo::findOrFail($id);
        $iglesias = Iglesia::orderBy('nombre')->get();
        $habilitadas = Departamento::query()
            ->where('catalogo_id', $item->id)
            ->where('habilitado', true)
            ->pluck('iglesia_id')
            ->all();

        return view('modules.catalogo_departamentos.edit', compact('titulo', 'item', 'iglesias', 'habilitadas'));
    }

    public function update(Request $request, string $id)
    {
        $item = DepartamentoCatalogo::findOrFail($id);
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:departamento_catalogo,nombre,'.$item->id,
            'descripcion' => 'nullable|string|max:500',
            'iglesia_ids' => 'nullable|array',
            'iglesia_ids.*' => 'integer|exists:iglesias,id',
        ]);

        $item->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
        ]);

        $seleccionadas = collect($data['iglesia_ids'] ?? [])->map(fn ($id) => (int) $id);

        foreach (Iglesia::all() as $iglesia) {
            $actuales = Departamento::query()
                ->where('iglesia_id', $iglesia->id)
                ->where('habilitado', true)
                ->pluck('catalogo_id');

            $nuevos = $seleccionadas->contains($iglesia->id)
                ? $actuales->push($item->id)->unique()->all()
                : $actuales->reject(fn ($catalogoId) => (int) $catalogoId === (int) $item->id)->values()->all();

            Departamento::syncHabilitadosParaIglesia($iglesia, $nuevos);
        }

        return to_route('catalogo-departamentos.index')->with('success', 'Departamento actualizado y habilitaciones guardadas.');
    }

    public function destroy(string $id)
    {
        $item = DepartamentoCatalogo::findOrFail($id);

        if ($item->departamentos()->exists()) {
            return back()->with('error', 'No se puede eliminar: ya está habilitado o tiene historial en alguna iglesia.');
        }

        $item->delete();

        return to_route('catalogo-departamentos.index')->with('success', 'Departamento eliminado del catálogo.');
    }

    public function habilitaciones()
    {
        $titulo = 'Habilitar departamentos';
        $catalogo = DepartamentoCatalogo::orderBy('nombre')->get();
        $iglesias = Iglesia::with(['departamentos' => function ($query) {
            $query->where('habilitado', true);
        }])->orderBy('nombre')->get();

        return view('modules.catalogo_departamentos.habilitaciones', compact('titulo', 'catalogo', 'iglesias'));
    }

    public function guardarHabilitaciones(Request $request)
    {
        $data = $request->validate([
            'habilitados' => 'nullable|array',
            'habilitados.*' => 'array',
            'habilitados.*.*' => 'integer|exists:departamento_catalogo,id',
        ]);

        $porIglesia = $data['habilitados'] ?? [];

        foreach (Iglesia::all() as $iglesia) {
            Departamento::syncHabilitadosParaIglesia(
                $iglesia,
                $porIglesia[$iglesia->id] ?? []
            );
        }

        return to_route('catalogo-departamentos.habilitaciones')->with('success', 'Habilitaciones actualizadas por iglesia.');
    }
}
