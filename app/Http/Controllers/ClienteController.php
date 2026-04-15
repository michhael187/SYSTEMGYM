<?php

namespace App\Http\Controllers;
use App\Models\Membresia;
use App\Http\Requests\StoreClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Services\ClienteService;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $clienteService)
    {
    }

    /**
     * Muestra el formulario para buscar un cliente por DNI.
     */
    public function buscarForm()
    {
        return view('clientes.buscar');
    }

    /**
     * Muestra el formulario de alta de cliente.
     */
    public function create()
    {
        $membresias = Membresia::where('activo', true)
            ->orderBy('nombre_plan')
            ->get();

        return view('clientes.create', compact('membresias'));
    }

    /**
     * Procesa el alta de un nuevo cliente.
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = $this->clienteService->crearCliente($request->validated());

        return redirect()
            ->route('clientes.edit', $cliente)
            ->with('success', 'Cliente registrado correctamente.');
    }


    /**
     * Busca un cliente por DNI o apellido.
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'tipo_busqueda' => ['required', 'in:dni,apellido'],
            'valor' => ['required', 'string', 'max:255'],
        ]);

        $tipoBusqueda = $request->tipo_busqueda;
        $valor = trim($request->valor);

        if ($tipoBusqueda === 'dni') {
            if (! is_numeric($valor)) {
                return redirect()
                    ->route('clientes.buscar.form')
                    ->withInput()
                    ->with('warning', 'Para buscar por DNI debe ingresar solo números.');
            }

            $cliente = Cliente::where('dni', (int) $valor)->first();

            if (! $cliente) {
                return redirect()
                    ->route('clientes.buscar.form')
                    ->withInput()
                    ->with('warning', 'No se encontró un cliente con ese DNI.');
            }

            return redirect()->route('clientes.edit', $cliente);
        }

        $resultados = Cliente::where('apellido', 'like', '%' . $valor . '%')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        if ($resultados->isEmpty()) {
            return redirect()
                ->route('clientes.buscar.form')
                ->withInput()
                ->with('warning', 'No se encontraron clientes con ese apellido.');
        }

        return view('clientes.buscar', [
            'resultados' => $resultados,
        ]);
    }


    /**
     * Muestra la ficha del cliente para ver o modificar sus datos.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Procesa la modificacion de un cliente existente.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $this->clienteService->actualizarCliente($cliente, $request->validated());

        return redirect()
            ->route('clientes.edit', $cliente)
            ->with('success', 'Cliente actualizado correctamente.');
    }
}
