<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembresiaRequest;
use App\Http\Requests\UpdateMembresiaRequest;
use App\Models\Membresia;
use App\Services\MembresiaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembresiaController extends Controller
{
    public function __construct(private MembresiaService $membresiaService)
    {
    }

    /**
     * Muestra el listado de membresias para editar, dar de baja o reactivar.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Membresia::class);

        $busqueda = trim((string) $request->query('buscar', ''));
        $estado = (string) $request->query('estado', 'todas');

        $membresias = Membresia::query()
            ->buscarPorNombrePlan($busqueda)
            ->filtrarPorEstado($estado)
            ->ordenadasPorNombre()
            ->paginate(15)
            ->withQueryString();

        return view('membresias.index', compact('membresias', 'busqueda', 'estado'));
    }

    /**
     * Muestra el formulario de alta de membresia.
     */
    public function create(): View
    {
        $this->authorize('create', Membresia::class);

        return view('membresias.create');
    }

    /**
     * Procesa el alta de una nueva membresia.
     */
    public function store(StoreMembresiaRequest $request): RedirectResponse
    {
        $this->authorize('create', Membresia::class);

        $membresia = $this->membresiaService->crearMembresia($request->validated());

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresia creada correctamente.');
    }

    /**
     * Muestra el formulario de edicion de una membresia.
     */
    public function edit(Membresia $membresia): View
    {
        $this->authorize('update', $membresia);

        return view('membresias.edit', compact('membresia'));
    }

    /**
     * Procesa la modificacion de una membresia existente.
     */
    public function update(UpdateMembresiaRequest $request, Membresia $membresia): RedirectResponse
    {
        $this->authorize('update', $membresia);

        $this->membresiaService->actualizarMembresia($membresia, $request->validated());

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresia actualizada correctamente.');
    }

    /**
     * Realiza la baja logica de una membresia.
     */
    public function darDeBaja(Membresia $membresia): RedirectResponse
    {
        $this->authorize('update', $membresia);

        $this->membresiaService->darDeBajaMembresia($membresia);

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresia dada de baja correctamente.');
    }

    /**
     * Reactiva una membresia inactiva.
     */
    public function reactivar(Membresia $membresia): RedirectResponse
    {
        $this->authorize('update', $membresia);

        $this->membresiaService->reactivarMembresia($membresia);

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresia reactivada correctamente.');
    }
}
