<?php

namespace App\Http\Controllers;

use App\Enums\AccionAuditoria;
use App\Http\Requests\BuscarPagoClienteRequest;
use App\Http\Requests\StorePagoRequest;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Pago;
use App\Services\AuditoriaService;
use App\Services\PagoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PagoController extends Controller
{
    public function __construct(
        private PagoService $pagoService,
        private AuditoriaService $auditoriaService,
    ) {
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
        
        // EL CAMBIO ESTÁ AQUÍ: Reemplazamos 'dni' por 'apellido'
        $tipoBusqueda = $datosValidados['tipo_busqueda'] ?? 'apellido';
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

    /**
     * Genera y descarga el comprobante PDF de un pago, registrando la operación en auditoría.
     */
    public function descargarComprobante(Request $request, Pago $pago): Response
    {
        $this->authorize('download', $pago);

        $pago->load(['cliente', 'membresia', 'usuario']);

        $nombreArchivo = sprintf('comprobante_pago_%s.pdf', $pago->id);

        $this->auditoriaService->registrar(
            operador: $request->user(),
            accion: AccionAuditoria::DESCARGA_PDF,
            modulo: 'pagos',
            auditable: $pago,
            valoresNuevos: [
                'documento' => 'recibo_pago',
                'pago_id' => $pago->id,
                'cliente_id' => $pago->cliente_id,
                'nombre_archivo' => $nombreArchivo,
            ],
            direccionIp: $request->ip(),
        );

        return Pdf::loadView('pagos.comprobante_pdf', compact('pago'))
            ->setPaper('a4')
            ->download($nombreArchivo);
    }
}
