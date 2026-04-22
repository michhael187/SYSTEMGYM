<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformeFinancieroRequest;
use App\Services\InformeService;
use Barryvdh\DomPDF\Facade\Pdf;
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
}