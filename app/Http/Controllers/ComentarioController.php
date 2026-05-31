<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idvacacion' => 'required|exists:vacacion,id',
            'texto' => 'required|string|max:1000',
        ]);

        $user = auth()->user();

        // Si NO es admin y tampoco es advanced, entonces OBLIGATORIAMENTE tiene que haber comprado el paquete
        if ($user->rol !== 'admin' && $user->rol !== 'advanced') {
            
            $haComprado = Reserva::where('iduser', $user->id)
                                 ->where('idvacacion', $request->idvacacion)
                                 ->exists();

            if (!$haComprado) {
                return redirect()->back()->withErrors(['error' => 'No tienes autorización para opinar en un viaje que no has reservado.']);
            }
        }

        // Si pasa el filtro anterior, guardamos el comentario
        Comentario::create([
            'iduser' => $user->id,
            'idvacacion' => $request->idvacacion,
            'texto' => $request->texto,
        ]);

        return redirect()->back()->with('status', 'comentario-publicado');
    }
}
