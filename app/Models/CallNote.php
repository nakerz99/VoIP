<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallNote extends Model
{
    protected $fillable = [
        'call_ticket_id',
        'user_id',
        'note',
        'type',
        'is_internal',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public function callTicket(): BelongsTo
    {
        return $this->belongsTo(CallTicket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
