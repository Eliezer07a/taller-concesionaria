<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticTicket;
use App\Models\WorkOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    // Muestra la lista de tickets y vehículos en el panel
    public function index()
    {
        if (auth()->user()->role === 'propietario') {
            $vehicles = Vehicle::where('user_id', auth()->id())->get();
            $vehicleIds = $vehicles->pluck('id');
            $tickets = DiagnosticTicket::with(['vehicle', 'workOrder'])
                ->whereIn('vehicle_id', $vehicleIds)
                ->latest()->get();

            return view('dashboard-propietario', compact('tickets', 'vehicles'));
        }

        // Mecánico: ve todos los tickets y vehículos
        $tickets = DiagnosticTicket::with(['vehicle', 'workOrder', 'mechanic'])->latest()->get();
        $vehicles = Vehicle::all();

        return view('dashboard', compact('tickets', 'vehicles'));
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
            'photos.*'       => 'image|mimes:jpeg,png,jpg|max:2048',
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