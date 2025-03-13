<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description',];



    // cascade delete
    protected $cascadeDeletes = ['sacredplaces'];
    public function sacredplaces()
    {
        return $this->belongsToMany(Sacredplace::class);
    }
    //
}
