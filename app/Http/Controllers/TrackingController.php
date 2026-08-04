<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    // Renderiza la vista principal del cliente
    public function show($tracking_code) {
        $workOrder = WorkOrder::where('tracking_code', $tracking_code)->firstOrFail();
        return view('public.tracking', compact('tracking_code'));
    }

    // Endpoint consultado por Fetch JS
    public function getStatus($tracking_code) {
    $workOrder = WorkOrder::with('diagnosticTicket.vehicle')
        ->where('tracking_code', $tracking_code)
        ->firstOrFail();

    return response()->json([
        'status' => $workOrder->status,
        // Garantiza que lea current_progress o progress, y si es nulo envía 0
        'progress' => $workOrder->current_progress ?? $workOrder->progress ?? 0,
        'reported_fault' => $workOrder->diagnosticTicket->reported_fault ?? 'En revisión técnica',
        'vehicle' => trim(($workOrder->diagnosticTicket->vehicle->brand ?? '') . ' ' . ($workOrder->diagnosticTicket->vehicle->model ?? '')),
        'updated_at' => $workOrder->updated_at ? $workOrder->updated_at->diffForHumans() : 'Recientemente'
    ]);
}
}