<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    public function paintings(): HasMany
    {
        return $this->hasMany(Painting::class);
    }

    public function authors(): HasManyThrough
    {
        return $this->hasManyThrough(Author::class, Painting::class, 'course_id', 'id');
    }
}
