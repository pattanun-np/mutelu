<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sacredplace extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'description', 'image', 'latitude', 'longitude'];


    // cascade delete
    protected $cascadeDeletes = ['tags', 'reviews'];
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    //
}
