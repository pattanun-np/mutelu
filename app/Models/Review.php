<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model


{
    use HasFactory;
    protected $fillable = ['title', 'body', 'rating'];

    // cascade delete
    protected $cascadeDeletes = ['user', 'sacredplace'];
    public function sacredplace()
    {
        return $this->belongsTo(Sacredplace::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
