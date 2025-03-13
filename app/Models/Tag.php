<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get all sacred places that have this tag
     */
    public function sacredplaces()
    {
        return Sacredplace::whereJsonContains('tag_ids', $this->id)->get();
    }
}
