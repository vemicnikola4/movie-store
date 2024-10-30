<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'overview',
        'original_language',
        'release_date',
        'api_id',
        'media_id',
        'price'
    ];
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'movie_genres');
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class,'movie_people');
    }
}
