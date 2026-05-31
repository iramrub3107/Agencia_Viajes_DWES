<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idvacacion' => ['required', 'exists:vacacion,id'],
        ]);

        $userId = auth()->id();

        // Opcionalmente evitamos que un mismo usuario reserve el mismo paquete más de una vez
        $yaReservado = Reserva::where('iduser', $userId)
            ->where('idvacacion', $request->idvacacion)
            ->exists();

        if ($yaReservado) {
            return redirect()->back()->withErrors(['error' => 'Ya tienes una reserva activa para este paquete vacacional.']);
        }

        Reserva::create([
            'iduser' => $userId,
            'idvacacion' => $request->idvacacion,
        ]);

        return redirect()->route('dashboard')->with('status', 'viaje-reservado');
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'idvacacion' => ['required', 'exists:vacacion,id'],
        ]);

        $reserva = Reserva::where('iduser', auth()->id())
            ->where('idvacacion', $request->idvacacion)
            ->first();

        if ($reserva) {
            $reserva->delete();
            return redirect()->back()->with('status', 'reserva-cancelada');
        }

        return redirect()->back()->withErrors(['error' => 'No se encontró ninguna reserva activa para cancelar.']);
    }
}