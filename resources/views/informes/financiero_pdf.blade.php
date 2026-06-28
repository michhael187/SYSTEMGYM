<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Financiero</title>

    <style>
        @page {
            margin: 28px 28px 42px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1f2937;
            background: #ffffff;
        }

        h1, h2, h3, p {
            margin: 0;
        }

        .page-footer {
            position: fixed;
            bottom: -24px;
            left: 0;
            right: 0;
            height: 24px;
            border-top: 1px solid #d1d5db;
            color: #6b7280;
            font-size: 9px;
            padding-top: 6px;
        }

        .page-number:after {
            content: counter(page);
        }

        .header {
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 3px solid #0f766e;
        }

        .brand-title {
            font-size: 26px;
            font-weight: bold;
            color: #111827;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: #6b7280;
            font-size: 10px;
        }

        .period-badge {
            margin-top: 8px;
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            font-size: 10px;
            font-weight: bold;
        }

        .section {
            margin-top: 16px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 17px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 7px;
        }

        .section-note {
            color: #6b7280;
            font-size: 10px;
            margin-bottom: 8px;
        }

        .cards {
            width: 100%;
            margin: 12px 0 16px;
        }

        .card {
            width: 23.4%;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 9px;
            margin-right: 1%;
            box-sizing: border-box;
            background: #ffffff;
            min-height: 62px;
        }

        .card:last-child {
            margin-right: 0;
        }

        .card .label {
            color: #6b7280;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .card .value {
            margin-top: 5px;
            font-size: 15px;
            font-weight: bold;
            color: #111827;
        }

        .card .helper {
            margin-top: 3px;
            color: #6b7280;
            font-size: 9px;
        }

        .grid-2 {
            width: 100%;
        }

        .col-left {
            display: inline-block;
            vertical-align: top;
            width: 34%;
            margin-right: 2%;
        }

        .col-right {
            display: inline-block;
            vertical-align: top;
            width: 63%;
        }

        .panel {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            background: #ffffff;
            page-break-inside: avoid;
        }

        .panel-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #111827;
        }

        .summary-box {
            border-left: 4px solid #0f766e;
            background: #f0fdfa;
            padding: 8px 10px;
            margin-top: 10px;
            font-size: 10px;
            color: #115e59;
        }

        .donut-wrap {
            width: 100%;
            text-align: center;
            margin-top: 6px;
        }

        .donut-center-title {
            font-size: 11px;
            font-weight: bold;
            color: #111827;
            margin-top: 4px;
        }

        .donut-center-value {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }

        .legend {
            margin-top: 10px;
            text-align: left;
        }

        .legend-item {
            margin-bottom: 5px;
            font-size: 9px;
            color: #374151;
        }

        .legend-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .legend-name {
            display: inline-block;
            width: 42%;
        }

        .legend-percent {
            display: inline-block;
            width: 20%;
            text-align: right;
            font-weight: bold;
        }

        .legend-money {
            display: inline-block;
            width: 32%;
            text-align: right;
            font-weight: bold;
            color: #111827;
        }

        .bar-row {
            margin-bottom: 8px;
        }

        .bar-head-table {
            width: 100%;
            margin-bottom: 3px;
            border-collapse: collapse;
        }

        .bar-head-table td {
            border: none;
            padding: 0 0 3px 0;
            font-size: 9.5px;
        }

        .bar-label-cell {
            width: 55%;
            color: #374151;
            text-align: left;
        }

        .bar-value-cell {
            width: 45%;
            color: #111827;
            font-weight: bold;
            text-align: right;
        }

        .bar-wrap {
            width: 100%;
            background: #e5e7eb;
            height: 12px;
            border-radius: 10px;
            overflow: hidden;
        }

        .bar {
            height: 12px;
            border-radius: 10px;
        }

        .bar-blue { background: #0ea5e9; }
        .bar-green { background: #10b981; }
        .bar-purple { background: #8b5cf6; }
        .bar-orange { background: #f59e0b; }
        .bar-red { background: #ef4444; }
        .bar-slate { background: #64748b; }

        .dot-blue { background: #0ea5e9; }
        .dot-green { background: #10b981; }
        .dot-purple { background: #8b5cf6; }
        .dot-orange { background: #f59e0b; }
        .dot-red { background: #ef4444; }
        .dot-slate { background: #64748b; }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .table th,
        .table td {
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background: #f3f4f6;
            font-size: 9px;
            text-transform: uppercase;
            color: #374151;
        }

        .table td {
            font-size: 9.5px;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .muted {
            color: #6b7280;
        }
    </style>
</head>

<body>
    @php
        $pagosColeccion = collect($pagos instanceof \Illuminate\Pagination\AbstractPaginator ? $pagos->items() : $pagos);

        $resumenOrdenado = collect($resumen_por_membresia)
            ->sortByDesc(fn ($fila) => (float) $fila['monto_total'])
            ->values();

        $maxMonto = $resumenOrdenado->max('monto_total') ?? 0;
        $totalResumen = (float) $resumenOrdenado->sum('monto_total');

        $membresiaPrincipal = $resumenOrdenado->first();
        $nombreMembresiaPrincipal = $membresiaPrincipal['membresia'] ?? '-';
        $montoMembresiaPrincipal = (float) ($membresiaPrincipal['monto_total'] ?? 0);

        $porcentajeMembresiaPrincipal = $total_recaudado > 0
            ? ($montoMembresiaPrincipal / $total_recaudado) * 100
            : 0;

        $colores = [
            ['nombre' => 'blue', 'hex' => '#0ea5e9'],
            ['nombre' => 'green', 'hex' => '#10b981'],
            ['nombre' => 'purple', 'hex' => '#8b5cf6'],
            ['nombre' => 'orange', 'hex' => '#f59e0b'],
            ['nombre' => 'red', 'hex' => '#ef4444'],
            ['nombre' => 'slate', 'hex' => '#64748b'],
        ];

        $resumenPorUsuario = $pagosColeccion
            ->groupBy(function ($pago) {
                $apellido = $pago->usuario?->apellido ?? '';
                $nombre = $pago->usuario?->nombre ?? '';

                $operador = trim($apellido . ', ' . $nombre, ' ,');

                return $operador !== '' ? $operador : 'Sin operador';
            })
            ->map(function ($items, $operador) {
                return [
                    'operador' => $operador,
                    'cantidad_pagos' => $items->count(),
                    'monto_total' => $items->sum('monto'),
                ];
            })
            ->sortByDesc('monto_total')
            ->values();

        $maxMontoOperador = $resumenPorUsuario->max('monto_total') ?? 0;

        $donutOffset = 25;
        $donutStroke = 18;
    @endphp

    <div class="page-footer">
        SystemGym - Informe financiero |
        Periodo {{ $fecha_desde->format('d/m/Y') }} al {{ $fecha_hasta->format('d/m/Y') }}
        <span style="float: right;">Página <span class="page-number"></span></span>
    </div>

    <div class="header">
        <h1 class="brand-title">Informe Financiero</h1>

        <div class="brand-subtitle">
            Reporte de ingresos, pagos registrados y rendimiento por membresía.
        </div>

        <div class="period-badge">
            Periodo: {{ $fecha_desde->format('d/m/Y') }} al {{ $fecha_hasta->format('d/m/Y') }}
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <div class="label">Total recaudado</div>
            <div class="value">${{ number_format($total_recaudado, 2, ',', '.') }}</div>
            <div class="helper">Ingresos del periodo</div>
        </div>

        <div class="card">
            <div class="label">Cantidad de pagos</div>
            <div class="value">{{ $cantidad_pagos }}</div>
            <div class="helper">Cobros registrados</div>
        </div>

        <div class="card">
            <div class="label">Promedio por pago</div>
            <div class="value">${{ number_format($promedio_por_pago, 2, ',', '.') }}</div>
            <div class="helper">Ticket promedio</div>
        </div>

        <div class="card">
            <div class="label">Membresía principal</div>
            <div class="value" style="font-size: 12px;">
                {{ $nombreMembresiaPrincipal }}
            </div>
            <div class="helper">
                {{ number_format($porcentajeMembresiaPrincipal, 1, ',', '.') }}% del total
            </div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Resumen ejecutivo</h2>

        <div class="summary-box">
            Durante el periodo seleccionado se registraron
            <strong>{{ $cantidad_pagos }}</strong> pagos, con una recaudación total de
            <strong>${{ number_format($total_recaudado, 2, ',', '.') }}</strong>.
            El promedio por pago fue de
            <strong>${{ number_format($promedio_por_pago, 2, ',', '.') }}</strong>.
            La membresía con mayor participación fue
            <strong>{{ $nombreMembresiaPrincipal }}</strong>.
        </div>
    </div>

    <div class="section">
        <div class="grid-2">
            <div class="col-left">
                <div class="panel">
                    <div class="panel-title">Distribución de ingresos por membresía</div>

                    @if ($resumenOrdenado->isEmpty() || $totalResumen <= 0)
                        <p>No hay datos para mostrar.</p>
                    @else
                        <div class="donut-wrap">
                            <svg width="190" height="190" viewBox="0 0 190 190">
                                <circle
                                    cx="95"
                                    cy="95"
                                    r="65"
                                    fill="none"
                                    stroke="#e5e7eb"
                                    stroke-width="{{ $donutStroke }}"
                                />

                                @foreach ($resumenOrdenado as $index => $fila)
                                    @php
                                        $porcentajeTotal = $totalResumen > 0
                                            ? ((float) $fila['monto_total'] / $totalResumen) * 100
                                            : 0;

                                        $color = $colores[$index % count($colores)];
                                        $dashArray = number_format($porcentajeTotal, 2, '.', '') . ' ' . number_format(100 - $porcentajeTotal, 2, '.', '');
                                        $dashOffset = -$donutOffset;
                                        $donutOffset += $porcentajeTotal;
                                    @endphp

                                    <circle
                                        cx="95"
                                        cy="95"
                                        r="65"
                                        fill="none"
                                        stroke="{{ $color['hex'] }}"
                                        stroke-width="{{ $donutStroke }}"
                                        stroke-dasharray="{{ $dashArray }}"
                                        stroke-dashoffset="{{ number_format($dashOffset, 2, '.', '') }}"
                                        pathLength="100"
                                        transform="rotate(-90 95 95)"
                                    />
                                @endforeach

                                <circle cx="95" cy="95" r="46" fill="#ffffff" />

                                <text x="95" y="88" text-anchor="middle" font-size="12" font-weight="bold" fill="#111827">
                                    Total
                                </text>

                                <text x="95" y="105" text-anchor="middle" font-size="11" fill="#374151">
                                    ${{ number_format($totalResumen, 0, ',', '.') }}
                                </text>
                            </svg>

                            <div class="donut-center-title">
                                Participación por plan
                            </div>

                            <div class="donut-center-value">
                                {{ $resumenOrdenado->count() }} membresías registradas
                            </div>
                        </div>

                        <div class="legend">
                            @foreach ($resumenOrdenado as $index => $fila)
                                @php
                                    $participacion = $totalResumen > 0
                                        ? ((float) $fila['monto_total'] / $totalResumen) * 100
                                        : 0;

                                    $color = $colores[$index % count($colores)];
                                @endphp

                                <div class="legend-item">
                                    <span class="legend-dot dot-{{ $color['nombre'] }}"></span>
                                    <span class="legend-name">{{ $fila['membresia'] }}</span>
                                    <span class="legend-percent">{{ number_format($participacion, 1, ',', '.') }}%</span>
                                    <span class="legend-money">${{ number_format((float) $fila['monto_total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-right">
                <div class="panel">
                    <div class="panel-title">Ranking visual por membresía</div>

                    @if ($resumenOrdenado->isEmpty())
                        <p>No hay datos para mostrar.</p>
                    @else
                        @foreach ($resumenOrdenado as $index => $fila)
                            @php
                                $porcentaje = $maxMonto > 0
                                    ? ((float) $fila['monto_total'] / $maxMonto) * 100
                                    : 0;

                                $color = $colores[$index % count($colores)];
                            @endphp

                            <div class="bar-row">
                                <table class="bar-head-table">
                                    <tr>
                                        <td class="bar-label-cell">
                                            {{ $fila['membresia'] }}
                                        </td>

                                        <td class="bar-value-cell">
                                            ${{ number_format((float) $fila['monto_total'], 2, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>

                                <div class="bar-wrap">
                                    <div
                                        class="bar bar-{{ $color['nombre'] }}"
                                        style="width: {{ number_format($porcentaje, 2, '.', '') }}%;"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="panel">
            <div class="panel-title">Recaudación por operador</div>

            @if ($resumenPorUsuario->isEmpty())
                <p>No hay operadores para mostrar.</p>
            @else
                @foreach ($resumenPorUsuario as $index => $fila)
                    @php
                        $porcentajeOperador = $maxMontoOperador > 0
                            ? ((float) $fila['monto_total'] / $maxMontoOperador) * 100
                            : 0;

                        $color = $colores[$index % count($colores)];
                    @endphp

                    <div class="bar-row">
                        <table class="bar-head-table">
                            <tr>
                                <td class="bar-label-cell">
                                    {{ $fila['operador'] }}
                                </td>

                                <td class="bar-value-cell">
                                    ${{ number_format((float) $fila['monto_total'], 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>

                        <div class="bar-wrap">
                            <div
                                class="bar bar-{{ $color['nombre'] }}"
                                style="width: {{ number_format($porcentajeOperador, 2, '.', '') }}%;"
                            ></div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Resumen por membresía</h2>

        @if ($resumenOrdenado->isEmpty())
            <p>No hay datos para el periodo seleccionado.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Membresía</th>
                        <th class="text-center">Cantidad de pagos</th>
                        <th class="text-right">Monto total</th>
                        <th class="text-right">Participación</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($resumenOrdenado as $fila)
                        @php
                            $participacion = $totalResumen > 0
                                ? ((float) $fila['monto_total'] / $totalResumen) * 100
                                : 0;
                        @endphp

                        <tr>
                            <td>{{ $fila['membresia'] }}</td>
                            <td class="text-center">{{ $fila['cantidad_pagos'] }}</td>
                            <td class="text-right">${{ number_format((float) $fila['monto_total'], 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($participacion, 1, ',', '.') }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2 class="section-title">Detalle de transacciones</h2>

        <p class="section-note">
            Listado de pagos registrados dentro del periodo seleccionado.
        </p>

        @if ($pagosColeccion->isEmpty())
            <p>No se encontraron pagos en el periodo seleccionado.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha y hora</th>
                        <th>Cliente</th>
                        <th>Membresía</th>
                        <th class="text-right">Monto</th>
                        <th>Registrado por</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pagosColeccion as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago?->format('d/m/Y H:i') ?? '-' }}</td>

                            <td>
                                {{ $pago->cliente?->apellido ?? '-' }},
                                {{ $pago->cliente?->nombre ?? '' }}
                            </td>

                            <td>{{ $pago->membresia?->nombre_plan ?? '-' }}</td>

                            <td class="text-right">
                                ${{ number_format((float) $pago->monto, 2, ',', '.') }}
                            </td>

                            <td>
                                @php
                                    $operadorApellido = $pago->usuario?->apellido ?? '';
                                    $operadorNombre = $pago->usuario?->nombre ?? '';
                                    $operador = trim($operadorApellido . ', ' . $operadorNombre, ' ,');
                                @endphp

                                {{ $operador !== '' ? $operador : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>