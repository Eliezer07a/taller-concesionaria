<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; }
        .header { background: #4f46e5; color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 22px; }
        .header .code { font-size: 14px; opacity: 0.9; }
        .section { padding: 15px 30px; border-bottom: 1px solid #e5e7eb; }
        .section:last-child { border-bottom: none; }
        .section h2 { font-size: 14px; color: #4f46e5; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .grid { display: flex; gap: 20px; flex-wrap: wrap; }
        .field { margin-bottom: 8px; }
        .field .label { font-weight: bold; color: #6b7280; font-size: 10px; text-transform: uppercase; }
        .field .value { font-size: 13px; margin-top: 2px; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; color: white; }
        .status-recibido { background: #9ca3af; }
        .status-en_revision { background: #3b82f6; }
        .status-en_proceso { background: #f59e0b; }
        .status-finalizado { background: #10b981; }
        .progress-bar { width: 100%; height: 14px; background: #e5e7eb; border-radius: 7px; overflow: hidden; margin-top: 5px; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #4f46e5, #10b981); border-radius: 7px; }
        .footer { background: #f9fafb; padding: 15px 30px; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 6px 10px; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        th { background: #f3f4f6; color: #6b7280; text-transform: uppercase; font-size: 9px; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>Concesionaria de Autos Usados</h1>
            <p style="font-size: 12px; opacity: 0.85;">Taller de Diagnóstico — Parte de Trabajo</p>
        </div>
        <div class="code">
            <strong>Código:</strong> {{ $workOrder->tracking_code }}<br>
            <strong>Fecha:</strong> {{ $workOrder->created_at->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="section">
        <h2>Datos del Vehículo</h2>
        <div class="grid">
            <div class="field" style="flex:1">
                <div class="label">Propietario</div>
                <div class="value">{{ $vehicle->user->name ?? '—' }}</div>
            </div>
            <div class="field" style="flex:1">
                <div class="label">Vehículo</div>
                <div class="value">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</div>
            </div>
            <div class="field" style="flex:1">
                <div class="label">Patente</div>
                <div class="value">{{ $vehicle->plate }}</div>
            </div>
            <div class="field" style="flex:1">
                <div class="label">VIN</div>
                <div class="value">{{ $vehicle->vin }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Diagnóstico</h2>
        <div class="field">
            <div class="label">Falla Reportada</div>
            <div class="value">{{ $ticket->reported_fault }}</div>
        </div>
        <div class="field">
            <div class="label">Diagnóstico Técnico</div>
            <div class="value">{{ $ticket->diagnostic ?? 'Pendiente de diagnóstico' }}</div>
        </div>
        <div class="field">
            <div class="label">Mecánico Asignado</div>
            <div class="value">{{ $ticket->mechanic->name ?? '—' }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Orden de Trabajo</h2>
        <div class="field">
            <div class="label">Descripción del Trabajo</div>
            <div class="value">{{ $workOrder->description }}</div>
        </div>
        <div class="grid">
            <div class="field" style="flex:1">
                <div class="label">Estado</div>
                <div class="value">
                    <span class="status-badge status-{{ $workOrder->status }}">
                        {{ ucfirst(str_replace('_', ' ', $workOrder->status)) }}
                    </span>
                </div>
            </div>
            <div class="field" style="flex:1">
                <div class="label">Costo Total</div>
                <div class="value" style="font-size:18px; font-weight:bold; color:#4f46e5;">${{ number_format($workOrder->cost, 2) }}</div>
            </div>
            <div class="field" style="flex:2">
                <div class="label">Progreso: {{ $workOrder->current_progress }}</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $workOrder->current_progress }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Historial de Cambios</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Progreso</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $workOrder->created_at->format('d/m/Y H:i') }}</td>
                    <td>Recibido</td>
                    <td>10%</td>
                </tr>
                <tr>
                    <td>{{ $workOrder->updated_at->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $workOrder->status)) }}</td>
                    <td>{{ $workOrder->current_progress }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        Concesionaria de Autos Usados — Taller de Diagnóstico &bull; Documento generado el {{ now()->format('d/m/Y a las H:i') }}
    </div>

</body>
</html>
