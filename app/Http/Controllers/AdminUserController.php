<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Registramos un nuevo usuario desde el dashboard del administrador
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8'],
            'rol' => ['required', 'string', 'in:user,advanced,admin'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('dashboard')->with('status', 'usuario-creado');
    }

    // Al ser administrador, también tiene la capacidad de borrar usuarios
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // También evitamos que el administrador se borre a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard')->withErrors(['error' => 'No puedes eliminar tu propia cuenta administrativa.']);
        }

        $user->delete();

        return redirect()->route('dashboard')->with('status', 'usuario-eliminado');
    }
}