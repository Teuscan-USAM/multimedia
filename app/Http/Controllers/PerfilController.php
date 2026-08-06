<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil del usuario autenticado
     */
    public function index()
    {
        $usuario = Auth::user();
        $titulo = 'Mi Perfil';
        return view('modules.perfiles.perfil', compact('usuario', 'titulo'));
    }

    /**
     * Actualizar la información del perfil
     */
    public function update(Request $request)
    {
        $usuario = Auth::user();

        // ✅ Validar campos
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🖼️ Si el usuario sube una nueva foto
        if ($request->hasFile('foto')) {

            // 📂 Ruta absoluta donde se guardarán las fotos
            $rutaDestino = public_path('fotos_perfil');

            // 🗑️ Eliminar la foto anterior si existe
            if ($usuario->foto && File::exists($rutaDestino . '/' . $usuario->foto)) {
                File::delete($rutaDestino . '/' . $usuario->foto);
            }

            // 📸 Guardar la nueva imagen
            $archivo = $request->file('foto');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();

            // Mover la imagen al directorio público
            $archivo->move($rutaDestino, $nombreArchivo);

            // Guardar el nombre del archivo en la base de datos
            $usuario->foto = $nombreArchivo;
        }

        // 📝 Actualizar nombre y correo
        $usuario->name  = $request->name;
        $usuario->email = $request->email;
        $usuario->save();

        return redirect()->route('perfil')->with('success', '✅ ¡Perfil actualizado correctamente!');
    }
}
