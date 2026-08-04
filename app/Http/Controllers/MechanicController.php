<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticTicket;
use App\Models\WorkOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MechanicController extends Controller
{
    // Panel principal del mecánico/asesor
    public function index() {
        $tickets = DiagnosticTicket::with('vehicle.user', 'workOrder')->latest()->get();
        $vehicles = Vehicle::with('user')->get();
        return view('dashboard', compact('tickets', 'vehicles'));
    }

    // Registrar un nuevo ticket de diagnóstico
    public function storeTicket(Request $request) {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'reported_fault' => 'required|string',
            'diagnostic' => 'required|string',
            'status' => 'required|in:reception,diagnosing,completed',
        ]);

        $ticket = DiagnosticTicket::create([
            'vehicle_id' => $request->vehicle_id,
            'mechanic_id' => auth()->id(),
            'reported_fault' => $request->reported_fault,
            'diagnostic' => $request->diagnostic,
            'status' => $request->status,
        ]);

        // Genera la orden de trabajo automáticamente
        WorkOrder::create([
            'diagnostic_ticket_id' => $ticket->id,
            'tracking_code' => strtoupper(Str::random(8)),
            'status' => 'pending',
            'current_progress' => 'Diagnóstico inicial registrado.',
            'total_cost' => 0.00
        ]);

        return redirect()->back()->with('success', 'Ticket registrado y Orden de Trabajo generada.');
    }

    // Actualizar el progreso de una Orden de Trabajo
    public function updateWorkOrder(Request $request, WorkOrder $workOrder) {
        $request->validate([
            'status' => 'required|in:pending,in_progress,waiting_parts,finished',
            'current_progress' => 'required|string',
            'total_cost' => 'required|numeric|min:0',
        ]);

        $workOrder->update([
            'status' => $request->status,
            'current_progress' => $request->current_progress,
            'total_cost' => $request->total_cost,
        ]);

        return redirect()->back()->with('success', 'Avance actualizado correctamente.');
    }
}