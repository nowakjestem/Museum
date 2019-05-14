<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    public function paintings(): HasMany
    {
        return $this->hasMany(Painting::class);
    }
}
