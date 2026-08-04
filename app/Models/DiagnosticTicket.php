<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DiagnosticTicket extends Model
{
    protected $fillable = [
        'vehicle_id',
        'mechanic_id',
        'reported_fault',
        'diagnostic',
        'status',
        'photos',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    // Relación: El ticket pertenece a un vehículo
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Relación: El ticket pertenece a un mecánico (Usuario)
    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }

    // Relación: Un ticket de diagnóstico tiene una orden de trabajo
    public function workOrder(): HasOne
    {
        return $this->hasOne(WorkOrder::class);
    }
}
