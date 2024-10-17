<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Movie extends Model
{
    use HasFactory;
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'genre_movies');
    }
}
