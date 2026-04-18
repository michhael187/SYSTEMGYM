<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Services\PagoService;
use App\Http\Requests\StorePagoRequest;

class PagoController extends Controller
{
    public function __construct(private PagoService $pagoService)
    {
    }

        /**
     * Muestra el formulario para registrar un nuevo pago.
     */
    public function create(\Illuminate\Http\Request $request)
    {
       $this->authorize('create', Pago::class);

        $membresias = Membresia::where('activo', true)
            ->orderBy('nombre_plan')
            ->get();

        $tipoBusqueda = $request->get('tipo_busqueda', 'dni');
        $valorBusqueda = trim((string) $request->get('valor_busqueda', ''));
        $clientes = collect();

        if ($valorBusqueda !== '') {
            $query = Cliente::orderBy('apellido')
                ->orderBy('nombre');

            if ($tipoBusqueda === 'dni') {
                if (is_numeric($valorBusqueda)) {
                    $query->where('dni', (int) $valorBusqueda);
                } else {
                    $query->whereRaw('1 = 0');
                }
            } else {
                $query->where('apellido', 'like', '%' . $valorBusqueda . '%');
            }

            $clientes = $query->get();
        }

        return view('pagos.create', compact(
            'membresias',
            'clientes',
            'tipoBusqueda',
            'valorBusqueda'
        ));
    }


    /**
     * Procesa el registro de un nuevo pago.
     */
    public function store(StorePagoRequest $request)
    {
        $this->authorize('create', Pago::class);

        $pago = $this->pagoService->registrarPago(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('pagos.create')
            ->with('success', 'Pago registrado correctamente.');
    }
}
