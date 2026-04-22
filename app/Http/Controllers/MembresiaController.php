<?php

namespace App\Http\Controllers;

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
     * Muestra el formulario de alta de membresia.
     */
    public function create()
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
    public function edit(Membresia $membresia)
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
