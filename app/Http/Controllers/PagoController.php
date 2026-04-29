<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuscarPagoClienteRequest;
use App\Http\Requests\StorePagoRequest;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Pago;
use App\Services\PagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PagoController extends Controller
{
    public function __construct(private PagoService $pagoService)
    {
    }

    /**
     * Muestra el formulario para registrar un nuevo pago.
     */
    public function create(BuscarPagoClienteRequest $request): View
    {
        $this->authorize('create', Pago::class);

        $membresias = Membresia::where('activo', true)
            ->orderBy('nombre_plan')
            ->get();

        $datosValidados = $request->validated();
        $clientePreseleccionado = null;
        $tipoBusqueda = $datosValidados['tipo_busqueda'] ?? 'dni';
        $valorBusqueda = $datosValidados['valor_busqueda'] ?? '';
        $clientes = collect();

        if (isset($datosValidados['cliente_id'])) {
            $clientePreseleccionado = Cliente::find($datosValidados['cliente_id']);

            if ($clientePreseleccionado) {
                $clientes = collect([$clientePreseleccionado]);
            }
        }

        if ($valorBusqueda !== '') {
            $query = Cliente::orderBy('apellido')
                ->orderBy('nombre');

            if ($tipoBusqueda === 'dni') {
                $query->where('dni', (int) $valorBusqueda);
            } else {
                $query->where('apellido', 'like', '%' . $valorBusqueda . '%');
            }

            $clientes = $query->get();
        }

        return view('pagos.create', compact(
            'membresias',
            'clientes',
            'clientePreseleccionado',
            'tipoBusqueda',
            'valorBusqueda'
        ));
    }

    /**
     * Procesa el registro de un nuevo pago.
     */
    public function store(StorePagoRequest $request): RedirectResponse
    {
        $this->authorize('create', Pago::class);

        $this->pagoService->registrarPago(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('pagos.create')
            ->with('success', 'Pago registrado correctamente.');
    }
}
