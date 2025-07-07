<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CallTicket extends Model
{
    protected $fillable = [
        'caller_id',
        'agent_id',
        'phone_number',
        'caller_name',
        'description',
        'status',
        'priority',
        'call_started_at',
        'call_ended_at',
        'call_duration',
        'voip_call_id',
        'voip_metadata',
    ];

    protected $casts = [
        'call_started_at' => 'datetime',
        'call_ended_at' => 'datetime',
        'voip_metadata' => 'array',
    ];

    public function caller(): BelongsTo
    {
        return $this->belongsTo(Caller::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(CallNote::class);
    }

    public function getCallDurationFormattedAttribute(): string
    {
        if (!$this->call_duration) {
            return '00:00:00';
        }

        $hours = floor($this->call_duration / 3600);
        $minutes = floor(($this->call_duration % 3600) / 60);
        $seconds = $this->call_duration % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByAgent($query, $agentId)
    {
        return $query->where('agent_id', $agentId);
    }
}
