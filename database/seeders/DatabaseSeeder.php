<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tipo;
use App\Models\Vacacion;
use App\Models\Foto;
use App\Models\Reserva;
use App\Models\Comentario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Tester',
            'email' => 'admin@travel.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);

        $cliente1 = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@mail.com',
            'password' => Hash::make('user123'),
            'rol' => 'user',
        ]);

        $cliente2 = User::create([
            'name' => 'María Gámez',
            'email' => 'maria@mail.com',
            'password' => Hash::make('user123'),
            'rol' => 'user',
        ]);

        $playa = Tipo::create(['nombre' => 'Playa']);
        $aventura = Tipo::create(['nombre' => 'Aventura']);
        $cultural = Tipo::create(['nombre' => 'Cultural']);

        $viajeCancun = Vacacion::create([
            'titulo' => 'Escapada Paradise Cancún',
            'descripcion' => 'Disfruta de 7 días todo incluido en las mejores playas del Caribe.',
            'precio' => 1250.00,
            'idtipo' => $playa->id,
            'pais' => 'México'
        ]);

        $viajeInca = Vacacion::create([
            'titulo' => 'Camino Inca y Machu Picchu',
            'descripcion' => 'Trekking guiado por los senderos históricos de los Andes.',
            'precio' => 1890.50,
            'idtipo' => $aventura->id,
            'pais' => 'Perú'
        ]);

        Foto::create(['idvacacion' => $viajeCancun->id, 'ruta' => 'vacaciones/cancun1.jpg']);
        Foto::create(['idvacacion' => $viajeCancun->id, 'ruta' => 'vacaciones/cancun2.jpg']);
        Foto::create(['idvacacion' => $viajeCancun->id, 'ruta' => 'vacaciones/cancun3.jpg']);

        Foto::create(['idvacacion' => $viajeInca->id, 'ruta' => 'vacaciones/peru1.jpg']);
        Foto::create(['idvacacion' => $viajeInca->id, 'ruta' => 'vacaciones/peru2.jpg']);
        Foto::create(['idvacacion' => $viajeInca->id, 'ruta' => 'vacaciones/peru3.jpg']);
        Foto::create(['idvacacion' => $viajeInca->id, 'ruta' => 'vacaciones/peru4.jpg']);

        Reserva::create([
            'iduser' => $cliente1->id,
            'idvacacion' => $viajeCancun->id
        ]);

        Reserva::create([
            'iduser' => $cliente2->id,
            'idvacacion' => $viajeInca->id
        ]);

        Comentario::create([
            'iduser' => $cliente1->id,
            'idvacacion' => $viajeCancun->id,
            'texto' => 'El hotel estuvo increíble y las playas lucían espectaculares. Totalmente recomendado.'
        ]);

        Comentario::create([
            'iduser' => $cliente2->id,
            'idvacacion' => $viajeInca->id,
            'texto' => 'Una experiencia exigente físicamente pero los paisajes son inolvidables.'
        ]);
    }
}