<?php

namespace App\Http\Controllers;

use App\Models\RegistroAuditoria;
use Illuminate\View\View;

class RegistroAuditoriaController extends Controller
{
    /**
     * Muestra el historial de auditoría paginado (solo lectura).
     */
    public function index(): View
    {
        $this->authorize('viewAny', RegistroAuditoria::class);

        $registros = RegistroAuditoria::query()
            ->with('usuario')
            ->orderByDesc('created_at')
            ->paginate(50);

        return view('auditoria.index', compact('registros'));
    }
}
