<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\DiagnosticTicket;
use App\Models\WorkOrder;

class TestDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === USUARIOS ===

        $propietario1 = User::create([
            'name' => 'Carlos Mendoza',
            'email' => 'carlos@test.com',
            'password' => bcrypt('password'),
            'role' => 'propietario',
            'email_verified_at' => now(),
        ]);

        $propietario2 = User::create([
            'name' => 'Ana Rodríguez',
            'email' => 'ana@test.com',
            'password' => bcrypt('password'),
            'role' => 'propietario',
            'email_verified_at' => now(),
        ]);

        $mecanico = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@test.com',
            'password' => bcrypt('password'),
            'role' => 'mecanico',
            'email_verified_at' => now(),
        ]);

        // === VEHÍCULOS USADOS ===

        $v1 = Vehicle::create([
            'user_id' => $propietario1->id,
            'plate' => 'JCV-4521',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2018,
        ]);

        $v2 = Vehicle::create([
            'user_id' => $propietario1->id,
            'plate' => 'FGR-8832',
            'brand' => 'Hyundai',
            'model' => 'Accent',
            'year' => 2016,
        ]);

        $v3 = Vehicle::create([
            'user_id' => $propietario2->id,
            'plate' => 'LMN-2290',
            'brand' => 'Nissan',
            'model' => 'Sentra',
            'year' => 2019,
        ]);

        // === TICKETS DE DIAGNÓSTICO Y ÓRDENES DE TRABAJO ===

        // Ticket 1 — En proceso
        $t1 = DiagnosticTicket::create([
            'vehicle_id' => $v1->id,
            'mechanic_id' => $mecanico->id,
            'reported_fault' => 'Ruido metálico al frenar en bajada',
            'diagnostic' => 'Desgaste total de balatas delanteras y-warpage de discos',
            'status' => 'diagnosing',
        ]);

        WorkOrder::create([
            'diagnostic_ticket_id' => $t1->id,
            'tracking_code' => 'TRK-A1B2C3',
            'description' => 'Reemplazo de balatas delanteras y rectificado de discos',
            'cost' => 180.00,
            'status' => 'en_proceso',
            'current_progress' => '60%',
        ]);

        // Ticket 2 — Recién recibido
        $t2 = DiagnosticTicket::create([
            'vehicle_id' => $v2->id,
            'mechanic_id' => $mecanico->id,
            'reported_fault' => 'El motor falla en ralentí y se apaga intermitentemente',
            'diagnostic' => null,
            'status' => 'reception',
        ]);

        WorkOrder::create([
            'diagnostic_ticket_id' => $t2->id,
            'tracking_code' => 'TRK-D4E5F6',
            'description' => 'Diagnóstico computarizado del sistema de inyección',
            'cost' => 0.00,
            'status' => 'recibido',
            'current_progress' => '10%',
        ]);

        // Ticket 3 — Finalizado
        $t3 = DiagnosticTicket::create([
            'vehicle_id' => $v3->id,
            'mechanic_id' => $mecanico->id,
            'reported_fault' => 'Fuga de aceite por la junta de la tapa de válvulas',
            'diagnostic' => 'Junta de tapa de válvulas deteriorada por calor',
            'status' => 'completed',
        ]);

        WorkOrder::create([
            'diagnostic_ticket_id' => $t3->id,
            'tracking_code' => 'TRK-G7H8I9',
            'description' => 'Reemplazo de junta de tapa de válvulas y ajuste de torque',
            'cost' => 250.00,
            'status' => 'finalizado',
            'current_progress' => '100%',
        ]);
    }
}
