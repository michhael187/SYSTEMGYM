<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Financiero</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }
        h1, h2, h3 {
            margin: 0;
        }
        .header {
            margin-bottom: 14px;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 8px;
        }
        .muted {
            color: #6b7280;
            font-size: 10px;
        }
        .cards {
            width: 100%;
            margin: 12px 0 16px;
        }
        .card {
            width: 31%;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px;
            margin-right: 1.5%;
            box-sizing: border-box;
        }
        .card:last-child {
            margin-right: 0;
        }
        .card .label {
            color: #6b7280;
            font-size: 10px;
        }
        .card .value {
            margin-top: 4px;
            font-size: 16px;
            font-weight: bold;
        }
        .section {
            margin-top: 16px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .table th, .table td {
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: left;
        }
        .table th {
            background: #f3f4f6;
            font-size: 10px;
            text-transform: uppercase;
        }
        .table td {
            font-size: 10px;
        }
        .text-right {
            text-align: right;
        }
        .chart-table {
            width: 100%;
            margin-top: 8px;
            border-collapse: collapse;
        }
        .chart-table td {
            padding: 5px 0;
            vertical-align: middle;
            font-size: 10px;
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
            background: #0ea5e9;
        }
    </style>
</head>
<body>
    @php
        $maxMonto = $resumen_por_membresia->max('monto_total') ?? 0;
    @endphp

    <div class="header">
        <h1>Informe Financiero</h1>
        <div class="muted">
            Periodo: {{ $fecha_desde->format('d/m/Y') }} al {{ $fecha_hasta->format('d/m/Y') }}
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <div class="label">Total recaudado</div>
            <div class="value">${{ number_format($total_recaudado, 2, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Cantidad de pagos</div>
            <div class="value">{{ $cantidad_pagos }}</div>
        </div>
        <div class="card">
            <div class="label">Promedio por pago</div>
            <div class="value">${{ number_format($promedio_por_pago, 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Resumen por membresia</h2>

        @if ($resumen_por_membresia->isEmpty())
            <p>No hay datos para el periodo seleccionado.</p>
        @else
            <table class="chart-table">
                @foreach ($resumen_por_membresia as $fila)
                    @php
                        $porcentaje = $maxMonto > 0 ? ($fila['monto_total'] / $maxMonto) * 100 : 0;
                    @endphp
                    <tr>
                        <td style="width: 25%;">{{ $fila['membresia'] }}</td>
                        <td style="width: 55%;">
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ number_format($porcentaje, 2, '.', '') }}%;"></div>
                            </div>
                        </td>
                        <td style="width: 20%;" class="text-right">
                            ${{ number_format((float) $fila['monto_total'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>Membresia</th>
                        <th>Cantidad de pagos</th>
                        <th>Monto total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumen_por_membresia as $fila)
                        <tr>
                            <td>{{ $fila['membresia'] }}</td>
                            <td>{{ $fila['cantidad_pagos'] }}</td>
                            <td class="text-right">${{ number_format((float) $fila['monto_total'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2>Detalle de transacciones</h2>

        @if ($pagos->isEmpty())
            <p>No se encontraron pagos en el periodo seleccionado.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha y hora</th>
                        <th>Cliente</th>
                        <th>Membresia</th>
                        <th>Monto</th>
                        <th>Registrado por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ $pago->cliente?->apellido ?? '-' }}, {{ $pago->cliente?->nombre ?? '' }}</td>
                            <td>{{ $pago->membresia?->nombre_plan ?? '-' }}</td>
                            <td class="text-right">${{ number_format((float) $pago->monto, 2, ',', '.') }}</td>
                            <td>{{ $pago->usuario?->apellido ?? '-' }}, {{ $pago->usuario?->nombre ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
