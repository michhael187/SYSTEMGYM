<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuscarClienteRequest;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $clienteService)
    {
    }

    /**
     * Muestra el listado principal de clientes con buscador integrado.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Cliente::class);

        $busqueda = trim((string) $request->query('buscar', ''));

        $clientes = Cliente::query()
            ->with('membresiaActual')
            ->buscarTexto($busqueda)
            ->ordenadosPorNombre()
            ->paginate(15)
            ->withQueryString();

        return view('clientes.index', compact('clientes', 'busqueda'));
    }

    /**
     * Mantiene compatibilidad con la ruta anterior y redirige al listado principal.
     */
    public function buscarForm(): RedirectResponse
    {
        $this->authorize('viewAny', Cliente::class);

        return redirect()->route('clientes.index');
    }

    /**
     * Muestra el formulario de alta de cliente.
     */
    public function create(): View
    {
        $this->authorize('create', Cliente::class);

        return view('clientes.create');
    }

    /**
     * Procesa el alta de un nuevo cliente.
     */
    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $this->authorize('create', Cliente::class);

        $cliente = $this->clienteService->crearCliente($request->validated());

        return redirect()
            ->route('clientes.create')
            ->with('success', 'Cliente registrado correctamente.')
            ->with('cliente_creado_id', $cliente->id)
            ->with('cliente_creado_nombre', $cliente->apellido . ', ' . $cliente->nombre);
    }

    /**
     * Busca un cliente por DNI o apellido.
     */
    public function buscar(BuscarClienteRequest $request): View|RedirectResponse
    {
        $this->authorize('viewAny', Cliente::class);

        $datosValidados = $request->validated();
        $tipoBusqueda = $datosValidados['tipo_busqueda'];
        $valor = $datosValidados['valor'];

        if ($tipoBusqueda === 'dni') {
            $cliente = Cliente::query()
                ->buscar($tipoBusqueda, $valor)
                ->first();

            if (! $cliente) {
                return redirect()
                    ->route('clientes.index')
                    ->withInput()
                    ->with('warning', 'No se encontro un cliente con ese DNI.');
            }

            return redirect()->route('clientes.edit', $cliente);
        }

        $resultados = Cliente::query()
            ->buscar($tipoBusqueda, $valor)
            ->ordenadosPorNombre()
            ->get();

        if ($resultados->isEmpty()) {
            return redirect()
                ->route('clientes.index')
                ->withInput()
                ->with('warning', 'No se encontraron clientes con ese apellido.');
        }

        return redirect()
            ->route('clientes.index', ['buscar' => $valor])
            ->with('warning', 'Se encontraron clientes con ese criterio. Usa la tabla para abrir la ficha.');
    }

    /**
     * Muestra la ficha del cliente para ver o modificar sus datos.
     */
    public function edit(Cliente $cliente): View
    {
        $this->authorize('update', $cliente);

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Procesa la modificacion de un cliente existente.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $this->authorize('update', $cliente);

        $this->clienteService->actualizarCliente($cliente, $request->validated());

        return redirect()
            ->route('clientes.edit', $cliente)
            ->with('success', 'Cliente actualizado correctamente.');
    }
}
