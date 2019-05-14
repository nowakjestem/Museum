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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}