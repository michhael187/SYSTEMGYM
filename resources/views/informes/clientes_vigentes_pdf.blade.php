<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Clientes Vigentes</title>
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
            width: 48%;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px;
            box-sizing: border-box;
        }
        .card + .card {
            margin-left: 4%;
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
        $maxClientes = $resumen_por_membresia->max('cantidad_clientes') ?? 0;
    @endphp

    <div class="header">
        <h1>Informe de Clientes Vigentes</h1>
        <div class="muted">
            Fecha de referencia: {{ $fecha_referencia->format('d/m/Y') }} |
            Orden: {{ str_replace('_', ' ', $sort_by) }} ({{ $sort_direction }})
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <div class="label">Fecha de referencia</div>
            <div class="value">{{ $fecha_referencia->format('d/m/Y') }}</div>
        </div>
        <div class="card">
            <div class="label">Clientes vigentes activos</div>
            <div class="value">{{ $total_clientes_vigentes }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Resumen por membresia</h2>

        @if ($resumen_por_membresia->isEmpty())
            <p>No hay datos para mostrar.</p>
        @else
            <table class="chart-table">
                @foreach ($resumen_por_membresia as $fila)
                    @php
                        $porcentaje = $maxClientes > 0 ? ($fila['cantidad_clientes'] / $maxClientes) * 100 : 0;
                    @endphp
                    <tr>
                        <td style="width: 25%;">{{ $fila['membresia'] }}</td>
                        <td style="width: 55%;">
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ number_format($porcentaje, 2, '.', '') }}%;"></div>
                            </div>
                        </td>
                        <td style="width: 20%;" class="text-right">{{ $fila['cantidad_clientes'] }}</td>
                    </tr>
                @endforeach
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>Membresia</th>
                        <th>Cantidad de clientes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumen_por_membresia as $fila)
                        <tr>
                            <td>{{ $fila['membresia'] }}</td>
                            <td class="text-right">{{ $fila['cantidad_clientes'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2>Detalle de clientes vigentes</h2>

        @if ($clientes->isEmpty())
            <p>No se encontraron clientes vigentes.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Membresia actual</th>
                        <th>Fecha vencimiento</th>
                        <th>Telefono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->apellido }}, {{ $cliente->nombre }}</td>
                            <td>{{ $cliente->dni }}</td>
                            <td>{{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresia' }}</td>
                            <td>{{ optional($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>
                            <td>{{ $cliente->telefono ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
