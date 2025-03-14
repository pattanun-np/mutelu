<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'rating', 'sacredplace_id', 'user_id'];

    // cascade delete
    protected $cascadeDeletes = ['user', 'sacredplace'];

    /**
     * Get the sacred place that this review belongs to.
     */
    public function sacredplace()
    {
        return $this->belongsTo(Sacredplace::class);
    }

    /**
     * Get the user that wrote this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
