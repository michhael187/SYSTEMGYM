<?php
use App\Http\Controllers\InformeController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])
        ->name('usuarios.create');

    Route::post('/usuarios', [UsuarioController::class, 'store'])
        ->name('usuarios.store');

    Route::get('/usuarios/reactivar', [UsuarioController::class, 'showReactivarForm'])
        ->name('usuarios.reactivar.form');

    Route::post('/usuarios/reactivar', [UsuarioController::class, 'reactivar'])
        ->name('usuarios.reactivar');

    Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])
        ->name('usuarios.edit');

    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])
        ->name('usuarios.update');

    Route::patch('/usuarios/{usuario}/baja', [UsuarioController::class, 'darDeBaja'])
        ->name('usuarios.baja');
    
    Route::get('/clientes/buscar', [ClienteController::class, 'buscarForm'])
        ->name('clientes.buscar.form');

    Route::post('/clientes/buscar', [ClienteController::class, 'buscar'])
        ->name('clientes.buscar');

    Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])
        ->name('clientes.edit');

    Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])
        ->name('clientes.update');

    Route::get('/clientes/crear', [ClienteController::class, 'create'])
        ->name('clientes.create');

    Route::post('/clientes', [ClienteController::class, 'store'])
        ->name('clientes.store');
    
        Route::get('/pagos/crear', [PagoController::class, 'create'])
        ->name('pagos.create');

    Route::post('/pagos', [PagoController::class, 'store'])
        ->name('pagos.store');

        Route::get('/membresias/crear', [MembresiaController::class, 'create'])
        ->name('membresias.create');

    Route::post('/membresias', [MembresiaController::class, 'store'])
        ->name('membresias.store');

    Route::get('/membresias/{membresia}/editar', [MembresiaController::class, 'edit'])
        ->name('membresias.edit');

    Route::put('/membresias/{membresia}', [MembresiaController::class, 'update'])
        ->name('membresias.update');

    Route::patch('/membresias/{membresia}/baja', [MembresiaController::class, 'darDeBaja'])
        ->name('membresias.baja');

    Route::patch('/membresias/{membresia}/reactivar', [MembresiaController::class, 'reactivar'])
        ->name('membresias.reactivar');

    Route::get('/informes/financiero', [InformeController::class, 'financiero'])
        ->name('informes.financiero');
    Route::get('/informes/financiero/descargar', [InformeController::class, 'descargarFinanciero'])
        ->name('informes.financiero.descargar');
});

require __DIR__.'/auth.php';
