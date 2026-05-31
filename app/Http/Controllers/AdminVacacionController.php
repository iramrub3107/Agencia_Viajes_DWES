<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use Illuminate\Http\Request;

class AdminVacacionController extends Controller
{
    // Registramos un nuevo paquete vacacional desde el dashboard del administrador. También los usuarios avanzados pueden crear estos paquetes
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'pais' => ['required', 'string', 'max:100'],
            'idtipo' => ['required', 'exists:tipo,id'],
        ]);

        Vacacion::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'pais' => $request->pais,
            'idtipo' => $request->idtipo,
        ]);

        return redirect()->route('dashboard')->with('status', 'viaje-creado');
    }

    // Solo los administradores podrán borrar los paquetes desde su dashboard
    public function destroy($id)
    {
        $vacacion = Vacacion::findOrFail($id);

        $vacacion->delete();

        return redirect()->route('dashboard')->with('status', 'viaje-eliminado');
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Actualización en desarrollo.'], 501);
    }

    public function uploadFotos(Request $request, $id)
    {
        return response()->json(['message' => 'Carga de archivos multimedia en desarrollo.'], 501);
    }
}