<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ordered_items',
        'created_at',
        'cart_total',
       
    ];
   
   
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'ordered_items', 'cart_id', 'movie_id');
    }
   
    
}
