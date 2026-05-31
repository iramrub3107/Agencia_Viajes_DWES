<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Tipo;
use App\Models\Reserva;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Mostramos el índice en donde se mostrarán todos los paquetes vacacionales
    public function index(Request $request)
    {
        $query = Vacacion::query();

        // Si viene el filtro de país en la URL, lo aplicamos
        if ($request->filled('pais')) {
            $query->where('pais', $request->pais);
        }

        // Si viene el filtro de tipo, lo aplicamos
        if ($request->filled('idtipo')) {
            $query->where('idtipo', $request->idtipo);
        }

        // Si viene el precio máximo, lo aplicamos
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Obtenemos los resultados filtrados
        $vacaciones = $query->get();

        // Si se han usado filtros al hacer una búsqueda, se aplican en la vista
        return view('index', compact('vacaciones'));
    }

    // Muestra la vista detallada de un paquete, con su respectiva galería múltiple y caja de comentarios.
    public function show($id)
    {
        $vacacion = Vacacion::with(['comentarios.user', 'tipo'])->findOrFail($id);

        $usuarioHaReservado = false;
        if (auth()->check()) {
            $usuarioHaReservado = Reserva::where('iduser', auth()->id())
                ->where('idvacacion', $id)
                ->exists();
        }

        return view('detalle', [
            'vacacion' => $vacacion,
            'comentarios' => $vacacion->comentarios,
            'usuarioHaReservado' => $usuarioHaReservado
        ]);
    }
}