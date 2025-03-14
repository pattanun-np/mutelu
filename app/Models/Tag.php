<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get all sacred places that have this tag
     * 
     * @return Collection
     */
    public function sacredplaces()
    {
        return Sacredplace::whereJsonContains('tag_ids', $this->id)->get();
    }

    /**
     * Get the count of sacred places using this tag
     * 
     * @return int
     */
    public function getSacredplacesCountAttribute(): int
    {
        return Sacredplace::whereJsonContains('tag_ids', $this->id)->count();
    }
}
