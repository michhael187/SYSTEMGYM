<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago #{{ $pago->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        .header { margin-bottom: 16px; border-bottom: 2px solid #0f172a; padding-bottom: 8px; }
        .muted { color: #6b7280; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #f8fafc; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SystemGym</h1>
        <h2>Comprobante de Pago</h2>
        <p class="muted">Emitido el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <tr>
            <th>N° Comprobante</th>
            <td>{{ $pago->id }}</td>
        </tr>
        <tr>
            <th>Cliente</th>
            <td>{{ $pago->cliente->apellido }}, {{ $pago->cliente->nombre }} (DNI: {{ number_format($pago->cliente->dni, 0, ',', '.') }})</td>
        </tr>
        <tr>
            <th>Plan</th>
            <td>{{ $pago->membresia->nombre_plan }}</td>
        </tr>
        <tr>
            <th>Monto</th>
            <td>$ {{ number_format($pago->monto, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Fecha de pago</th>
            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Vigencia hasta</th>
            <td>{{ $pago->fecha_fin->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Registrado por</th>
            <td>{{ $pago->usuario->apellido }}, {{ $pago->usuario->nombre }}</td>
        </tr>
    </table>
</body>
</html>
