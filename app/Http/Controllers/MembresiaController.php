<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Membresia;
use App\Services\MembresiaService;
use App\Http\Requests\StoreMembresiaRequest;
use App\Http\Requests\UpdateMembresiaRequest;

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
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where('nombre_plan', 'like', '%' . $busqueda . '%');
            })
            ->when($estado === 'activas', function ($query) {
                $query->where('activo', true);
            })
            ->when($estado === 'inactivas', function ($query) {
                $query->where('activo', false);
            })
            ->orderBy('nombre_plan')
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
    public function store(StoreMembresiaRequest $request)
    {
        $this->authorize('create', Membresia::class);

        $membresia = $this->membresiaService->crearMembresia($request->validated());

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresía creada correctamente.');
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
    public function update(UpdateMembresiaRequest $request, Membresia $membresia)
    {
        $this->authorize('update', $membresia);

        $this->membresiaService->actualizarMembresia($membresia, $request->validated());

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresía actualizada correctamente.');
    }

    /**
     * Realiza la baja logica de una membresia.
     */
    public function darDeBaja(Membresia $membresia)
    {
        $this->authorize('update', $membresia);

        $this->membresiaService->darDeBajaMembresia($membresia);

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresía dada de baja correctamente.');
    }

    /**
     * Reactiva una membresia inactiva.
     */
    public function reactivar(Membresia $membresia)
    {
        $this->authorize('update', $membresia);

        $this->membresiaService->reactivarMembresia($membresia);

        return redirect()
            ->route('membresias.edit', $membresia)
            ->with('success', 'Membresía reactivada correctamente.');
    }

}
