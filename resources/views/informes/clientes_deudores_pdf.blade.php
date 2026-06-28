<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Clientes Deudores</title>

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
            border-bottom: 3px solid #dc2626;
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
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
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

        .summary-box {
            border-left: 4px solid #dc2626;
            background: #fef2f2;
            padding: 8px 10px;
            margin-top: 10px;
            font-size: 10px;
            color: #7f1d1d;
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

        .legend-count {
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

        .bar-red { background: #ef4444; }
        .bar-orange { background: #f59e0b; }
        .bar-purple { background: #8b5cf6; }
        .bar-blue { background: #0ea5e9; }
        .bar-green { background: #10b981; }
        .bar-slate { background: #64748b; }

        .dot-red { background: #ef4444; }
        .dot-orange { background: #f59e0b; }
        .dot-purple { background: #8b5cf6; }
        .dot-blue { background: #0ea5e9; }
        .dot-green { background: #10b981; }
        .dot-slate { background: #64748b; }

        .badge-danger {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 999px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-warning {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 999px;
            background: #fef3c7;
            color: #92400e;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-soft {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #374151;
            font-size: 9px;
            font-weight: bold;
        }

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
        $clientesColeccion = collect($clientes instanceof \Illuminate\Pagination\AbstractPaginator ? $clientes->items() : $clientes);

        $resumenOrdenado = collect($resumen_por_membresia)
            ->sortByDesc(fn ($fila) => (int) $fila['cantidad_clientes'])
            ->values();

        $maxClientes = $resumenOrdenado->max('cantidad_clientes') ?? 0;
        $totalResumen = (int) $resumenOrdenado->sum('cantidad_clientes');

        $membresiaPrincipal = $resumenOrdenado->first();
        $nombreMembresiaPrincipal = $membresiaPrincipal['membresia'] ?? '-';
        $cantidadMembresiaPrincipal = (int) ($membresiaPrincipal['cantidad_clientes'] ?? 0);

        $porcentajeMembresiaPrincipal = $totalResumen > 0
            ? ($cantidadMembresiaPrincipal / $totalResumen) * 100
            : 0;

        $clientesConAtraso = $clientesColeccion->map(function ($cliente) use ($fecha_referencia) {
            $cliente->dias_atraso_calculado = $cliente->fecha_vencimiento
                ? $cliente->fecha_vencimiento->diffInDays($fecha_referencia)
                : 0;

            return $cliente;
        });

        $clienteMayorAtraso = $clientesConAtraso
            ->sortByDesc('dias_atraso_calculado')
            ->first();

        $mayorAtraso = $clienteMayorAtraso?->dias_atraso_calculado ?? 0;

        $promedioAtraso = $clientesConAtraso->count() > 0
            ? round($clientesConAtraso->avg('dias_atraso_calculado'))
            : 0;

        $colores = [
            ['nombre' => 'red', 'hex' => '#ef4444'],
            ['nombre' => 'orange', 'hex' => '#f59e0b'],
            ['nombre' => 'purple', 'hex' => '#8b5cf6'],
            ['nombre' => 'blue', 'hex' => '#0ea5e9'],
            ['nombre' => 'green', 'hex' => '#10b981'],
            ['nombre' => 'slate', 'hex' => '#64748b'],
        ];

        $donutOffset = 25;
        $donutStroke = 18;
    @endphp

    <div class="page-footer">
        SystemGym - Informe de clientes deudores |
        Fecha de referencia {{ $fecha_referencia->format('d/m/Y') }}
        <span style="float: right;">Página <span class="page-number"></span></span>
    </div>

    <div class="header">
        <h1 class="brand-title">Informe de Clientes Deudores</h1>

        <div class="brand-subtitle">
            Reporte de clientes activos con membresía vencida.
        </div>

        <div class="period-badge">
            Fecha de referencia: {{ $fecha_referencia->format('d/m/Y') }} |
            Orden: {{ str_replace('_', ' ', $sort_by) }}
            ({{ $sort_direction === 'asc' ? 'ascendente' : 'descendente' }})
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <div class="label">Fecha de referencia</div>
            <div class="value">{{ $fecha_referencia->format('d/m/Y') }}</div>
            <div class="helper">Base del informe</div>
        </div>

        <div class="card">
            <div class="label">Clientes deudores</div>
            <div class="value">{{ $total_clientes_deudores }}</div>
            <div class="helper">Activos con cuota vencida</div>
        </div>

        <div class="card">
            <div class="label">Mayor atraso</div>
            <div class="value">{{ $mayorAtraso }} días</div>
            <div class="helper">
                {{ $clienteMayorAtraso ? $clienteMayorAtraso->apellido . ', ' . $clienteMayorAtraso->nombre : 'Sin datos' }}
            </div>
        </div>

        <div class="card">
            <div class="label">Promedio de atraso</div>
            <div class="value">{{ $promedioAtraso }} días</div>
            <div class="helper">Promedio general</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Resumen ejecutivo</h2>

        <div class="summary-box">
            A la fecha de referencia se registran
            <strong>{{ $total_clientes_deudores }}</strong> clientes activos con membresía vencida.
            La membresía con mayor cantidad de deudores es
            <strong>{{ $nombreMembresiaPrincipal }}</strong>, con
            <strong>{{ $cantidadMembresiaPrincipal }}</strong> clientes.
            El mayor atraso registrado es de
            <strong>{{ $mayorAtraso }}</strong> días.
        </div>
    </div>

    <div class="section">
        <div class="grid-2">
            <div class="col-left">
                <div class="panel">
                    <div class="panel-title">Distribución por membresía</div>

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
                                            ? ((int) $fila['cantidad_clientes'] / $totalResumen) * 100
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

                                <text x="95" y="105" text-anchor="middle" font-size="13" font-weight="bold" fill="#374151">
                                    {{ $totalResumen }}
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
                                        ? ((int) $fila['cantidad_clientes'] / $totalResumen) * 100
                                        : 0;

                                    $color = $colores[$index % count($colores)];
                                @endphp

                                <div class="legend-item">
                                    <span class="legend-dot dot-{{ $color['nombre'] }}"></span>
                                    <span class="legend-name">{{ $fila['membresia'] }}</span>
                                    <span class="legend-percent">{{ number_format($participacion, 1, ',', '.') }}%</span>
                                    <span class="legend-count">{{ $fila['cantidad_clientes'] }} clientes</span>
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
                                $porcentaje = $maxClientes > 0
                                    ? ((int) $fila['cantidad_clientes'] / $maxClientes) * 100
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
                                            {{ $fila['cantidad_clientes'] }} clientes
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
        <h2 class="section-title">Resumen por membresía</h2>

        @if ($resumenOrdenado->isEmpty())
            <p>No hay datos para mostrar.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Membresía</th>
                        <th class="text-center">Cantidad de clientes</th>
                        <th class="text-right">Participación</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($resumenOrdenado as $fila)
                        @php
                            $participacion = $totalResumen > 0
                                ? ((int) $fila['cantidad_clientes'] / $totalResumen) * 100
                                : 0;
                        @endphp

                        <tr>
                            <td>{{ $fila['membresia'] }}</td>
                            <td class="text-center">{{ $fila['cantidad_clientes'] }}</td>
                            <td class="text-right">{{ number_format($participacion, 1, ',', '.') }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2 class="section-title">Detalle de clientes deudores</h2>

        <p class="section-note">
            Listado de clientes activos cuya fecha de vencimiento se encuentra vencida.
        </p>

        @if ($clientesConAtraso->isEmpty())
            <p>No se encontraron clientes deudores.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Membresía actual</th>
                        <th>Fecha vencimiento</th>
                        <th class="text-center">Días de atraso</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($clientesConAtraso as $cliente)
                        <tr>
                            <td>{{ $cliente->apellido }}, {{ $cliente->nombre }}</td>
                            <td>{{ $cliente->dni }}</td>
                            <td>{{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresía' }}</td>
                            <td>{{ optional($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>

                            <td class="text-center">
                                @if ($cliente->dias_atraso_calculado >= 60)
                                    <span class="badge-danger">{{ $cliente->dias_atraso_calculado }} días</span>
                                @elseif ($cliente->dias_atraso_calculado >= 30)
                                    <span class="badge-warning">{{ $cliente->dias_atraso_calculado }} días</span>
                                @else
                                    <span class="badge-soft">{{ $cliente->dias_atraso_calculado }} días</span>
                                @endif
                            </td>

                            <td>{{ $cliente->telefono ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>