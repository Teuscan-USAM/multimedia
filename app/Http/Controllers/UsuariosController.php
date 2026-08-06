<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index()
    {
        $titulo = 'Usuarios';
        $items = User::orderBy('name')->get();
        return view('modules.usuarios_admin.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Crear usuario';
        $iglesias = Iglesia::orderBy('nombre')->get();
        return view('modules.usuarios_admin.create', compact('titulo', 'iglesias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,pastor,miembro',
            'iglesias' => 'array',
            'iglesias.*' => 'integer|exists:iglesias,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'activo' => true,
            'rol' => $data['rol'],
        ]);

        if ($user->rol === 'pastor' && !empty($data['iglesias'])) {
            $user->iglesiasPastor()->sync($data['iglesias']);
        }

        return to_route('usuarios.index')->with('success', 'Usuario creado con éxito.');
    }

    public function edit(string $id)
    {
        $titulo = 'Editar usuario';
        $item = User::findOrFail($id);
        $iglesias = Iglesia::orderBy('nombre')->get();
        $asignadas = $item->rol === 'pastor' ? $item->iglesiasPastor()->pluck('iglesias.id')->toArray() : [];
        return view('modules.usuarios_admin.edit', compact('titulo', 'item', 'iglesias', 'asignadas'));
    }

    public function update(Request $request, string $id)
    {
        $item = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'rol' => 'required|in:admin,pastor,miembro',
            'iglesias' => 'array',
            'iglesias.*' => 'integer|exists:iglesias,id',
        ]);

        $item->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'rol' => $data['rol'],
        ]);

        if ($item->rol === 'pastor') {
            $item->iglesiasPastor()->sync($data['iglesias'] ?? []);
        } else {
            $item->iglesiasPastor()->detach();
        }

        return to_route('usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function estado($id, $estado)
    {
        $item = User::findOrFail($id);
        $item->activo = (bool) $estado;
        $item->save();
        return to_route('usuarios.index')->with('success', 'Estado de usuario actualizado.');
    }

    public function asignarIglesias(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        if ($user->rol !== 'pastor') {
            return back()->with('error', 'Solo se pueden asignar iglesias a usuarios con rol Pastor.');
        }

        $data = $request->validate([
            'iglesias' => 'required|array',
            'iglesias.*' => 'integer|exists:iglesias,id',
        ]);

        $user->iglesiasPastor()->sync($data['iglesias']);
        return back()->with('success', 'Iglesias asignadas con éxito.');
    }
}

