<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('user')->latest()->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vin'     => 'required|string|max:17|unique:vehicles,vin',
            'plate'   => 'required|string|max:10|unique:vehicles,plate',
            'brand'   => 'required|string|max:50',
            'model'   => 'required|string|max:50',
            'year'    => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        Vehicle::create($request->only(['user_id', 'vin', 'plate', 'brand', 'model', 'year']));

        return redirect()->route('vehicles.index')->with('success', 'Vehículo registrado exitosamente.');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vin'     => 'required|string|max:17|unique:vehicles,vin,' . $vehicle->id,
            'plate'   => 'required|string|max:10|unique:vehicles,plate,' . $vehicle->id,
            'brand'   => 'required|string|max:50',
            'model'   => 'required|string|max:50',
            'year'    => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $vehicle->update($request->only(['user_id', 'vin', 'plate', 'brand', 'model', 'year']));

        return redirect()->route('vehicles.index')->with('success', 'Vehículo actualizado exitosamente.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehículo eliminado.');
    }

    public function history(Vehicle $vehicle)
    {
        $vehicle->load('user', 'diagnosticTickets.workOrder', 'diagnosticTickets.mechanic');
        $tickets = $vehicle->diagnosticTickets()->latest()->get();

        return view('vehicles.history', compact('vehicle', 'tickets'));
    }
}
