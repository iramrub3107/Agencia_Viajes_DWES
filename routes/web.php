<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\AdminVacacionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\ReservaController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Accesibles sin iniciar sesión)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/catalogo', [CatalogController::class, 'index'])->name('vacaciones.index');
Route::get('/vacaciones/{id}', [CatalogController::class, 'show'])->name('detalle');

// 🪂 PARCHE DE SEGURIDAD UX: Si entran a /vacaciones mediante GET, los redirigimos al catálogo
Route::get('/vacaciones', function() {
    return redirect()->route('vacaciones.index');
});

/*
|--------------------------------------------------------------------------
| 2. RUTAS PROTEGIDAS (Requieren inicio de sesión previo)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // CAMBIO CLAVE: Ahora la ruta llama a DashboardController@index para procesar los datos por rol
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reservas.store')->middleware('auth');
    Route::delete('/reservar', [ReservaController::class, 'destroy'])->name('reservas.destroy')->middleware('auth');
    /*
    |--------------------------------------------------------------------------
    | 3. CONTROL DE ACCESOS Y REGLAS DE NEGOCIO POR ROLES
    |--------------------------------------------------------------------------
    */

    // Rol: user, advanced, admin
    Route::middleware(['role:user,advanced,admin'])->group(function () {
        Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    });

    // Rol: advanced, admin
    Route::middleware(['role:advanced,admin'])->group(function () {
        Route::post('/vacaciones', [AdminVacacionController::class, 'store'])->name('vacaciones.store');
        Route::put('/vacaciones/{id}', [AdminVacacionController::class, 'update'])->name('vacaciones.update');
        Route::post('/vacaciones/{id}/fotos', [AdminVacacionController::class, 'uploadFotos'])->name('vacaciones.fotos');
    });

    // Rol: admin
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/usuarios', [AdminUserController::class, 'store'])->name('usuarios.store');
        Route::delete('/vacaciones/{id}', [AdminVacacionController::class, 'destroy'])->name('vacaciones.destroy');
        Route::delete('/usuarios/{id}', [AdminUserController::class, 'destroy'])->name('usuarios.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| 4. ATRACO / FORZAR LOGIN DE PRUEBAS
|--------------------------------------------------------------------------
*/
Route::get('/forzar-login-admin', function () {
    $user = User::where('rol', 'admin')->first();
    
    if ($user) {
        auth()->login($user);
        return '¡Logueado con éxito como Administrador! Ya puedes ir al <a href="'.url('/dashboard').'" style="color:indigo; font-weight:bold; text-decoration:underline;">Panel de Control (Dashboard)</a>';
    }
    
    return 'No se encontró ningún usuario administrador en la tabla de usuarios. Asegúrate de ejecutar: php artisan db:seed';
});

/*
|--------------------------------------------------------------------------
| 5. RUTAS INTERNAS DE LARAVEL BREEZE
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';