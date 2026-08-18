<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticTicket;
use App\Models\WorkOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    // Muestra la lista de tickets y vehículos en el panel
    public function index()
    {
        if (auth()->user()->role === 'propietario') {
            $vehicles = Vehicle::where('user_id', auth()->id())->get();
            $vehicleIds = $vehicles->pluck('id');
            $tickets = DiagnosticTicket::with(['vehicle', 'workOrder', 'mechanic'])
                ->whereIn('vehicle_id', $vehicleIds)
                ->latest()->get();

            return view('dashboard-propietario', compact('tickets', 'vehicles'));
        }

        // Mecánico: ve todos los tickets y vehículos con su propietario
        $tickets = DiagnosticTicket::with(['vehicle.user', 'workOrder', 'mechanic'])->latest()->get();

        // Todos los vehículos registrados (para el selector con filtro)
        $vehicles = Vehicle::with('user')->get();

        // Vehículos disponibles (sin reparación finalizada o con una activa en curso)
        $disponibles = Vehicle::with('user')
            ->where(function ($query) {
                $query->whereDoesntHave('diagnosticTickets.workOrder')
                      ->orWhereHas('diagnosticTickets.workOrder', fn($q) => $q->where('status', '!=', 'finalizado'));
            })
            ->get();

        return view('dashboard', compact('tickets', 'vehicles', 'disponibles'));
    }

    // Endpoint JSON para auto-refrescar el panel del propietario (Fetch JS)
    public function misReparaciones()
    {
        $vehicleIds = Vehicle::where('user_id', auth()->id())->pluck('id');

        $tickets = DiagnosticTicket::with(['workOrder'])
            ->whereIn('vehicle_id', $vehicleIds)
            ->latest()
            ->get()
            ->filter(fn($t) => $t->workOrder)
            ->map(fn($t) => [
                'id'               => $t->id,
                'status'           => $t->workOrder->status,
                'current_progress' => $t->workOrder->current_progress ?? '0%',
            ]);

        return response()->json($tickets->values());
    }

    // Registra un nuevo ticket de diagnóstico y su orden de trabajo
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'     => 'required|exists:vehicles,id',
            'reported_fault' => 'required|string|max:500',
            'diagnostic'     => 'required|string|max:500',
            'description'    => 'required|string|max:500',
            'cost'           => 'required|numeric|min:0',
            'photos'         => 'nullable|array|max:5',
            'photos.*'       => 'image|mimes:jpeg,png,jpg|max:8192',
        ]);

        // Subir fotos si existen
        $photosPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photosPaths[] = $photo->store('diagnostic-photos', 'public');
            }
        }

        $ticket = DiagnosticTicket::create([
            'vehicle_id'     => $request->vehicle_id,
            'mechanic_id'    => auth()->id(),
            'reported_fault' => $request->reported_fault,
            'diagnostic'     => $request->diagnostic,
            'status'         => 'diagnosing',
            'photos'         => $photosPaths ?: null,
        ]);

        $trackingCode = 'TRK-' . strtoupper(Str::random(6));

        WorkOrder::create([
            'diagnostic_ticket_id' => $ticket->id,
            'tracking_code'        => $trackingCode,
            'description'          => $request->description,
            'cost'                 => $request->cost,
            'status'               => 'recibido',
            'current_progress'     => '10%',
        ]);

        return redirect()->route('dashboard')->with('success', "¡Ticket creado exitosamente! Código de seguimiento: {$trackingCode}");
    }

    // Actualiza el estado y avance desde la tabla por AJAX / Fetch
    public function updateProgress(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'status'           => 'required|string',
            'current_progress' => 'required|string',
        ]);

        $workOrder->update([
            'status'           => $request->status,
            'current_progress' => $request->current_progress,
        ]);

        return response()->json([
            'message'          => 'Avance actualizado correctamente',
            'status'           => $workOrder->status,
            'current_progress' => $workOrder->current_progress
        ]);
    }

    // Elimina un ticket y su orden de trabajo (con sus fotos)
    public function destroy(DiagnosticTicket $ticket)
    {
        if ($ticket->photos) {
            foreach ($ticket->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $ticket->delete();

        return response()->json(['message' => 'Registro eliminado correctamente']);
    }

    // Exporta la orden de trabajo como PDF
    public function exportPdf(WorkOrder $workOrder)
    {
        $workOrder->load('diagnosticTicket.vehicle.user', 'diagnosticTicket.mechanic');
        $ticket = $workOrder->diagnosticTicket;
        $vehicle = $ticket->vehicle;

        $pdf = Pdf::loadView('pdf.work-order', compact('workOrder', 'ticket', 'vehicle'))
            ->setPaper('a4')
            ->setOption('isRemoteEnabled', true);

        return $pdf->download("orden-trabajo-{$workOrder->tracking_code}.pdf");
    }
}