<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacacion;
use App\Models\Tipo;
use App\Models\Reserva;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->rol === 'admin') {

            $data['usuarios'] = User::where('id', '!=', $user->id)->get();
            $data['vacaciones'] = Vacacion::with('tipo')->get();
            $data['tipos'] = Tipo::all();
        } 
        elseif ($user->rol === 'advanced') {
            $data['vacaciones'] = Vacacion::with('tipo')->get();
            $data['tipos'] = Tipo::all();
        } 
        else {
            $data['reservas'] = Reserva::with('vacacion')
                ->where('iduser', $user->id)
                ->get();
        }

        return view('dashboard', $data);
    }
}