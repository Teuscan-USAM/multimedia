<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class Usuarios extends Controller
{
    /**
     * Mostrar lista de usuarios.
     */
    public function index()
    {
    $titulo = "Usuarios";
    $usuarios = User::all();
    return view('modules.usuarios.index', compact('usuarios','titulo'));
    }


    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $titulo = 'Usuario nuevo';
        return view('modules.usuarios.create', compact('titulo'));
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,cajero,bodeguero',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'activo' => true,
                'rol' => $request->rol,
            ]);

            return to_route('usuarios')->with('success', 'Usuario guardado con éxito!');
        } catch (Exception $e) {
            return to_route('usuarios')->with('error', 'Error al guardar usuario: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(string $id)
    {
        $item = User::findOrFail($id);
        $titulo = "Editar usuario";
        return view('modules.usuarios.edit', compact('item', 'titulo'));
    }

    /**
     * Actualizar usuario existente.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'rol' => 'required|in:admin,cajero,bodeguero',
        ]);

        try {
            $item = User::findOrFail($id);
            $item->name = $request->name;
            $item->email = $request->email;
            $item->rol = $request->rol;
            $item->save();

            return to_route('usuarios')->with('success', 'Usuario actualizado con éxito!');
        } catch (Exception $e) {
            return to_route('usuarios')->with('error', 'Error al actualizar usuario: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar usuario (opcional).
     */
    public function destroy(string $id)
    {
        try {
            $item = User::findOrFail($id);
            $item->delete();
            return to_route('usuarios')->with('success', 'Usuario eliminado correctamente.');
        } catch (Exception $e) {
            return to_route('usuarios')->with('error', 'Error al eliminar usuario: ' . $e->getMessage());
        }
    }

    /**
     * Recargar el tbody de usuarios (AJAX).
     */
    public function tbody()
    {
        $items = User::all(); // aquí sí usamos $items para mantener el tbody coherente
        return view('modules.usuarios.tbody', compact('items'));
    }

    /**
     * Cambiar estado activo/inactivo de usuario.
     */
    public function estado($id, $estado)
    {
        $item = User::findOrFail($id);
        $item->activo = $estado;
        return $item->save();
    }

    /**
     * Cambiar contraseña de usuario.
     */
    public function cambio_password($id, $password)
    {
        $item = User::findOrFail($id);
        $item->password = Hash::make($password);
        return $item->save();
    }
}
