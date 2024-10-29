<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'gender',
        'birthday_date',
        'biography',
        'place_of_birth',
        'known_for_department',
        'media_id'
    ];


    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class,'movie_people');
    }
}
