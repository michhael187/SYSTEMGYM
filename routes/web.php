<?php
use App\Http\Controllers\InformeController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RegistroAuditoriaController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProfileController;
use App\Models\Cliente;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Enums\RolUsuario;
use App\Models\User;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    $existeAdministrador = User::query()
        ->where('rol', RolUsuario::ADMINISTRADOR->value)
        ->exists();

    if (! $existeAdministrador) {
        return redirect()->route('setup.index');
    }

    return redirect()->route('login');
});

Route::get('/setup', [SetupController::class, 'index'])
    ->name('setup.index');

Route::post('/setup', [SetupController::class, 'store'])
    ->name('setup.store');

Route::get('/dashboard', function () {
    $cacheKey = 'dashboard.kpis.v2.' . now()->format('Y-m-d');

    $kpis = Cache::remember($cacheKey, now()->addMinutes(5), function () {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        return [
            'sociosActivos' => \App\Models\Cliente::query()
                ->where('estado', true)
                ->whereNotNull('fecha_vencimiento')
                ->where('fecha_vencimiento', '>=', $todayStart)
                ->count(),

            'ingresosMes' => \App\Models\Pago::query()
                ->whereBetween('fecha_pago', [$monthStart, $monthEnd])
                ->sum('monto'),

            'vencenHoy' => \App\Models\Cliente::query()
                ->where('estado', true)
                ->whereBetween('fecha_vencimiento', [$todayStart, $todayEnd])
                ->count(),

            'cuotasAtrasadas' => \App\Models\Cliente::query()
                ->where('estado', true)
                ->where('fecha_vencimiento', '<', $todayStart)
                ->count(),
        ];
    });

    return view('dashboard', $kpis);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/usuarios', [UsuarioController::class, 'index'])
        ->name('usuarios.index');

    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])
        ->name('usuarios.create');

    Route::post('/usuarios', [UsuarioController::class, 'store'])
        ->name('usuarios.store');

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

    Route::get('/clientes', [ClienteController::class, 'index'])
        ->name('clientes.index');

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

    Route::get('/pagos/{pago}/comprobante', [PagoController::class, 'descargarComprobante'])
        ->name('pagos.comprobante.descargar');

    Route::get('/membresias', [MembresiaController::class, 'index'])
        ->name('membresias.index');

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
    Route::get('/informes/clientes-vigentes', [InformeController::class, 'clientesVigentes'])
        ->name('informes.clientes_vigentes');
    Route::get('/informes/clientes-vigentes/descargar', [InformeController::class, 'descargarClientesVigentes'])
        ->name('informes.clientes_vigentes.descargar');
    Route::get('/informes/clientes-deudores', [InformeController::class, 'clientesDeudores'])
        ->name('informes.clientes_deudores');
    Route::get('/informes/clientes-deudores/descargar', [InformeController::class, 'descargarClientesDeudores'])
        ->name('informes.clientes_deudores.descargar');

    Route::get('/auditoria', [RegistroAuditoriaController::class, 'index'])
        ->middleware('can:viewAny,' . \App\Models\RegistroAuditoria::class)
        ->name('auditoria.index');
});

require __DIR__.'/auth.php';
