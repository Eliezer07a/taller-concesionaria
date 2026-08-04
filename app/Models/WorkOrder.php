<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    protected $fillable = [
        'diagnostic_ticket_id',
        'tracking_code',
        'description',
        'cost',
        'status',
        'current_progress'
    ];

    // Relación: La orden de trabajo pertenece a un ticket de diagnóstico
    public function diagnosticTicket(): BelongsTo
    {
        return $this->belongsTo(DiagnosticTicket::class);
    }
}