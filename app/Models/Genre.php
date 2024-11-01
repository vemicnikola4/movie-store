<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    ];
    /**
     * The roles that belong to the Genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class,'movie_genres');
    }
}
