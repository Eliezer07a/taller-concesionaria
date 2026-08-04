<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. Rutas Públicas de Seguimiento (Cliente)
Route::get('/seguimiento/{tracking_code}', [TrackingController::class, 'show'])->name('tracking.public');
Route::get('/api/seguimiento/{tracking_code}', [TrackingController::class, 'getStatus'])->name('api.tracking.status');

// 2. Rutas Protegidas del Taller (Requieren Autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Panel de control (usa TicketController para cargar vehiculos y tickets)
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    
    // Crear ticket / documentar falla
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    
    // Actualizar progreso por Fetch JS
    Route::patch('/work-orders/{workOrder}/progress', [TicketController::class, 'updateProgress'])->name('work-orders.update-progress');

    // Exportar PDF de orden de trabajo
    Route::get('/work-orders/{workOrder}/pdf', [TicketController::class, 'exportPdf'])->name('work-orders.pdf');

    // Historial de un vehículo
    Route::get('/vehicles/{vehicle}/history', [VehicleController::class, 'history'])->name('vehicles.history');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de mecánico / asesor (solo mecánicos)
    Route::middleware('role:mecanico')->prefix('taller')->name('mechanic.')->group(function () {
        Route::get('/dashboard', [MechanicController::class, 'index'])->name('dashboard');
        Route::post('/tickets', [MechanicController::class, 'storeTicket'])->name('tickets.store');
        Route::put('/orders/{workOrder}', [MechanicController::class, 'updateWorkOrder'])->name('orders.update');
    });

    // CRUD de Vehículos (solo mecánicos)
    Route::middleware('role:mecanico')->resource('vehicles', VehicleController::class)->except('show');

}); // <-- Aquí se cierra el grupo principal de autenticación

require __DIR__.'/auth.php';