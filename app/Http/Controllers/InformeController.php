<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformeFinancieroRequest;
use App\Services\InformeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class InformeController extends Controller
{
    public function __construct(private InformeService $informeService)
    {
    }

    /**
     * Muestra el informe financiero con filtro por rango de fechas.
     */
    public function financiero(InformeFinancieroRequest $request): View
    {
        $this->authorize('viewFinancialReport');

        $informe = $this->informeService->generarInformeFinanciero($request->validated());

        return view('informes.financiero', $informe);
    }

    /**
     * Descarga una version PDF del informe financiero usando el mismo filtro.
     */
    public function descargarFinanciero(InformeFinancieroRequest $request): Response
    {
        $this->authorize('viewFinancialReport');

        $filtros = $request->validated();
        [$fechaDesde, $fechaHasta] = $this->informeService->resolverRangoFechas($filtros);
        $informe = $this->informeService->generarInformeFinanciero($filtros);

        $nombreArchivo = sprintf(
            'informe_financiero_%s_a_%s.pdf',
            $fechaDesde->format('Ymd'),
            $fechaHasta->format('Ymd')
        );

        return Pdf::loadView('informes.financiero_pdf', $informe)
            ->setPaper('a4')
            ->download($nombreArchivo);
    }

    /**
     * Muestra el informe de clientes vigentes con estado activo.
     */
    public function clientesVigentes(Request $request): View
    {
        $this->authorize('viewActiveClientsReport');

        $informe = $this->informeService->generarInformeClientesVigentes(
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

        $informe = $this->informeService->generarInformeClientesVigentes(
            $request->only(['sort_by', 'sort_direction'])
        );
        $nombreArchivo = sprintf(
            'informe_clientes_vigentes_%s.pdf',
            $informe['fecha_referencia']->format('Ymd')
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

        $informe = $this->informeService->generarInformeClientesDeudores(
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

        $informe = $this->informeService->generarInformeClientesDeudores(
            $request->only(['sort_by', 'sort_direction'])
        );
        $nombreArchivo = sprintf(
            'informe_clientes_deudores_%s.pdf',
            $informe['fecha_referencia']->format('Ymd')
        );

        return Pdf::loadView('informes.clientes_deudores_pdf', $informe)
            ->setPaper('a4')
            ->download($nombreArchivo);
    }
}
