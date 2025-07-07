<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caller extends Model
{
    protected $fillable = [
        'phone_number',
        'name',
        'email',
        'address',
        'company',
        'notes',
        'is_blocked',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_blocked' => 'boolean',
    ];

    public function callTickets(): HasMany
    {
        return $this->hasMany(CallTicket::class);
    }

    public function callLogs(): HasMany
    {
        return $this->hasMany(CallLog::class);
    }

    public function getCallHistoryAttribute()
    {
        return $this->callLogs()
            ->orderBy('call_started_at', 'desc')
            ->limit(10)
            ->get();
    }
}
