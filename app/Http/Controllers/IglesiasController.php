<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\DepartamentoCatalogo;
use App\Models\Iglesia;
use App\Models\User;
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
        $catalogo = DepartamentoCatalogo::orderBy('nombre')->get();
        $pastores = User::where('rol', 'pastor')->where('activo', true)->orderBy('name')->get();
        $habilitados = old('catalogo_ids', []);
        return view('modules.iglesias.create', compact('titulo', 'catalogo', 'habilitados', 'pastores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'ciudad' => 'nullable|string|max:100',
            'responsable' => 'nullable|string|max:255',
            'pastor_id' => 'nullable|integer|exists:users,id',
            'direccion_google_maps' => 'nullable|url|max:2048',
            'catalogo_ids' => 'nullable|array',
            'catalogo_ids.*' => 'integer|exists:departamento_catalogo,id',
        ]);

        $iglesia = Iglesia::create(collect($data)->except('catalogo_ids')->all());
        $this->syncPastorResponsable($iglesia, $data['pastor_id'] ?? null);
        Departamento::syncHabilitadosParaIglesia($iglesia, $data['catalogo_ids'] ?? []);
        return to_route('iglesias.index')->with('success', 'Iglesia creada con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar iglesia';
        $item = Iglesia::findOrFail($id);
        $catalogo = DepartamentoCatalogo::orderBy('nombre')->get();
        $pastores = User::where('rol', 'pastor')->where('activo', true)->orderBy('name')->get();
        $habilitados = old(
            'catalogo_ids',
            $item->departamentos()->habilitados()->pluck('catalogo_id')->all()
        );
        return view('modules.iglesias.edit', compact('titulo', 'item', 'catalogo', 'habilitados', 'pastores'));
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
            'pastor_id' => 'nullable|integer|exists:users,id',
            'direccion_google_maps' => 'nullable|url|max:2048',
            'catalogo_ids' => 'nullable|array',
            'catalogo_ids.*' => 'integer|exists:departamento_catalogo,id',
        ]);

        $item->update(collect($data)->except('catalogo_ids')->all());
        $this->syncPastorResponsable($item, $data['pastor_id'] ?? null);
        Departamento::syncHabilitadosParaIglesia($item, $data['catalogo_ids'] ?? []);
        return to_route('iglesias.index')->with('success', 'Iglesia actualizada con éxito.');
    }

    public function destroy(string $id)
    {
        $item = Iglesia::findOrFail($id);
        $item->delete();
        return to_route('iglesias.index')->with('success', 'Iglesia eliminada con éxito.');
    }

    private function syncPastorResponsable(Iglesia $iglesia, ?int $pastorId): void
    {
        if ($pastorId) {
            User::where('id', $pastorId)->where('rol', 'pastor')->firstOrFail();
            $iglesia->pastores()->syncWithoutDetaching([$pastorId]);
        }

        $iglesia->update(['pastor_id' => $pastorId]);
    }
}

