<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    public function index()
    {
        $titulo = 'Departamentos';
        $iglesiaIds = Auth::user()->iglesiasPastor()->pluck('iglesias.id');

        $items = Departamento::habilitados()
            ->whereIn('iglesia_id', $iglesiaIds)
            ->with('iglesia', 'miembro')
            ->get()
            ->sortBy(fn (Departamento $d) => ($d->iglesia?->nombre ?? '').' '.$d->nombre)
            ->values();

        return view('modules.departamentos.index', compact('titulo', 'items'));
    }

    public function edit(string $id)
    {
        $titulo = 'Asignar departamento';
        $item = $this->departamentoDelPastor($id);
        $miembros = User::where('rol', 'miembro')->where('activo', true)->orderBy('name')->get();

        return view('modules.departamentos.edit', compact('titulo', 'item', 'miembros'));
    }

    public function update(Request $request, string $id)
    {
        $item = $this->departamentoDelPastor($id);

        $data = $request->validate([
            'miembro_id' => 'nullable|integer|exists:users,id',
        ]);

        $miembroId = $data['miembro_id'] ?? null;
        if ($miembroId) {
            User::where('rol', 'miembro')->findOrFail($miembroId);
        }

        $item->update([
            'miembro_id' => $miembroId,
            'pastor_id' => Auth::id(),
        ]);

        return to_route('departamentos.index')->with('success', 'Asignación actualizada con éxito.');
    }

    public function asignarMiembro(Request $request, string $id)
    {
        $item = $this->departamentoDelPastor($id);
        $data = $request->validate([
            'miembro_id' => 'required|integer|exists:users,id',
        ]);

        $miembro = User::where('rol', 'miembro')->findOrFail($data['miembro_id']);
        $item->miembro_id = $miembro->id;
        $item->pastor_id = Auth::id();
        $item->save();

        return back()->with('success', 'Miembro asignado con éxito.');
    }

    private function departamentoDelPastor(string $id): Departamento
    {
        $iglesiaIds = Auth::user()->iglesiasPastor()->pluck('iglesias.id');

        return Departamento::habilitados()
            ->whereIn('iglesia_id', $iglesiaIds)
            ->findOrFail($id);
    }
}
