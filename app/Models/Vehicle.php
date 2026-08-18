<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'plate',
        'brand',
        'model',
        'year',
    ];

    // Relación: Un vehículo pertenece a un usuario (cliente)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un vehículo puede tener muchos tickets de diagnóstico
    public function diagnosticTickets(): HasMany
    {
        return $this->hasMany(DiagnosticTicket::class);
    }
}