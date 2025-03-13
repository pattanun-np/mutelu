<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sacredplace extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'latitude', 'longitude', 'tag_ids'];

    // cascade delete
    protected $cascadeDeletes = ['reviews'];

    // Cast the JSON column to an array
    protected $casts = [
        'tag_ids' => 'array',
    ];

    /**
     * Get the tags attribute
     * 
     * @return Collection
     */
    public function getTagsAttribute(): Collection
    {
        if (empty($this->tag_ids)) {
            return collect([]);
        }

        return Tag::whereIn('id', $this->tag_ids)->get();
    }

    /**
     * Define a custom relationship for tags
     * This is a workaround to make Laravel's relationship system work with our JSON array
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        // If tag_ids is empty, return an empty relationship
        if (empty($this->tag_ids)) {
            return $this->hasMany(Tag::class)->whereRaw('1 = 0'); // Always false condition
        }

        // Create a relationship that filters tags based on the tag_ids array
        return $this->hasMany(Tag::class, 'id', 'id')
            ->whereIn('id', $this->tag_ids);
    }

    /**
     * Associate tags with this sacred place
     */
    public function syncTags(array $tagIds)
    {
        $this->tag_ids = $tagIds;
        $this->save();

        return $this;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
