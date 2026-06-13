<?php

namespace App\Http\Controllers;

use App\Enums\AccionAuditoria;
use App\Http\Requests\InformeFinancieroRequest;
use App\Services\AuditoriaService;
use App\Services\InformeClientesService;
use App\Services\InformeFinancieroService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class InformeController extends Controller
{
    public function __construct(
        private InformeFinancieroService $informeFinancieroService,
        private InformeClientesService $informeClientesService,
        private AuditoriaService $auditoriaService,
    ) {
    }

    /**
     * Muestra el informe financiero con filtro por rango de fechas.
     */
    public function financiero(InformeFinancieroRequest $request): View
    {
        $this->authorize('viewFinancialReport');

        $informe = $this->informeFinancieroService->generarInforme($request->validated());

        return view('informes.financiero', $informe);
    }

    /**
     * Descarga una version PDF del informe financiero usando el mismo filtro.
     */
    public function descargarFinanciero(InformeFinancieroRequest $request): Response
    {
        $this->authorize('viewFinancialReport');

        $informe = $this->informeFinancieroService->generarInforme($request->validated(), true);
        $nombreArchivo = sprintf(
            'informe_financiero_%s_%s.pdf',
            $informe['fecha_desde']->format('Ymd'),
            $informe['fecha_hasta']->format('Ymd')
        );

        $this->auditoriaService->registrar(
            operador: $request->user(),
            accion: AccionAuditoria::DESCARGA_PDF,
            modulo: 'documentos',
            valoresNuevos: [
                'documento' => 'informe_financiero',
                'nombre_archivo' => $nombreArchivo,
            ],
            direccionIp: $request->ip(),
        );

        return Pdf::loadView('informes.financiero_pdf', $informe)
            ->setPaper('a4', 'landscape')
            ->download($nombreArchivo);
    }

    /**
     * Muestra el informe de clientes vigentes con estado activo.
     */
    public function clientesVigentes(Request $request): View
    {
        $this->authorize('viewActiveClientsReport');

        $informe = $this->informeClientesService->generarInformeClientesVigentes(
            $request->only(['sort_by', 'sort_direction'])
        );

        return view('informes.clientes_vigentes', $informe);
    }

    /**
     * Descarga una version PDF del informe de clientes vigentes.
     */
    public function descargarClientesVigentes(Request $request): Response
    {
        $this->authorize('viewActiveClientsReport');

        $informe = $this->informeClientesService->generarInformeClientesVigentes(
            $request->only(['sort_by', 'sort_direction']),
            true
        );
        $nombreArchivo = sprintf(
            'informe_clientes_vigentes_%s.pdf',
            $informe['fecha_referencia']->format('Ymd')
        );

        $this->auditoriaService->registrar(
            operador: $request->user(),
            accion: AccionAuditoria::DESCARGA_PDF,
            modulo: 'documentos',
            valoresNuevos: [
                'documento' => 'informe_clientes_vigentes',
                'nombre_archivo' => $nombreArchivo,
            ],
            direccionIp: $request->ip(),
        );

        return Pdf::loadView('informes.clientes_vigentes_pdf', $informe)
            ->setPaper('a4')
            ->download($nombreArchivo);
    }

    /**
     * Muestra el informe de clientes deudores.
     */
    public function clientesDeudores(Request $request): View
    {
        $this->authorize('viewOverdueClientsReport');

        $informe = $this->informeClientesService->generarInformeClientesDeudores(
            $request->only(['sort_by', 'sort_direction'])
        );

        return view('informes.clientes_deudores', $informe);
    }

    /**
     * Descarga una version PDF del informe de clientes deudores.
     */
    public function descargarClientesDeudores(Request $request): Response
    {
        $this->authorize('viewOverdueClientsReport');

        $informe = $this->informeClientesService->generarInformeClientesDeudores(
            $request->only(['sort_by', 'sort_direction']),
            true
        );
        $nombreArchivo = sprintf(
            'informe_clientes_deudores_%s.pdf',
            $informe['fecha_referencia']->format('Ymd')
        );

        $this->auditoriaService->registrar(
            operador: $request->user(),
            accion: AccionAuditoria::DESCARGA_PDF,
            modulo: 'documentos',
            valoresNuevos: [
                'documento' => 'informe_clientes_deudores',
                'nombre_archivo' => $nombreArchivo,
            ],
            direccionIp: $request->ip(),
        );

        return Pdf::loadView('informes.clientes_deudores_pdf', $informe)
            ->setPaper('a4')
            ->download($nombreArchivo);
    }
}
