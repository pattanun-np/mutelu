<?php

namespace App\View\Components;

use App\Models\Sacredplace;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlaceCard extends Component
{
    public $place;
    public $imageIndex = 0;
    public $filteredImages = [];

    /**
     * Create a new component instance.
     */
    public function __construct(Sacredplace $place)
    {
        $this->place = $place;

        // Check if the place has an image relationship
        if (method_exists($place, 'images') && $place->images) {
            // If there's an images relationship, use it
            $this->filteredImages = $place->images->pluck('url')->toArray();
        } else if ($place->image) {
            // Otherwise use the single image field
            $this->filteredImages = [$place->image];
        }

        // If no images, use a placeholder
        if (empty($this->filteredImages)) {
            $this->filteredImages = ['/images/placeholder.jpg'];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.place-card');
    }
}
