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

    public function cast(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class,'cast','person_id','movie_id');
    }
    public function crew(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class,'crew','person_id','movie_id');
    }
}
