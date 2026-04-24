<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Clientes Deudores</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        h1, h2 {
            margin-bottom: 8px;
        }

        .resumen {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <h1>Informe de Clientes Deudores</h1>
    <div class="resumen">
        <p><strong>Fecha de referencia:</strong> {{ $fecha_referencia->format('d/m/Y') }}</p>
        <p><strong>Total de clientes activos con membresia vencida:</strong> {{ $total_clientes_deudores }}</p>
    </div>

    <h2>Resumen por membresia</h2>
    <table>
        <thead>
            <tr>
                <th>Membresia</th>
                <th>Cantidad de clientes</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resumen_por_membresia as $fila)
                <tr>
                    <td>{{ $fila['membresia'] }}</td>
                    <td>{{ $fila['cantidad_clientes'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay datos para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Detalle de clientes deudores</h2>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>DNI</th>
                <th>Membresia actual</th>
                <th>Fecha vencimiento</th>
                <th>Dias de atraso</th>
                <th>Telefono</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->apellido }}, {{ $cliente->nombre }}</td>
                    <td>{{ $cliente->dni }}</td>
                    <td>{{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresia' }}</td>
                    <td>{{ optional($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>
                    <td>{{ $cliente->fecha_vencimiento?->diffInDays($fecha_referencia) ?? 0 }}</td>
                    <td>{{ $cliente->telefono ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No se encontraron clientes deudores.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
