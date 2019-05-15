<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'course_id',
        'quantity',
    ];

    protected $attach = [
        'ticketType',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getTicketTypeAttribute(): string
    {
        if ($this->quantity > 1) {
            return 'multiple';
        } else {
            return 'single';
        }
    }
}
