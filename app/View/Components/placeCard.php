<?php

namespace App\View\Components;

use App\Models\Sacredplace;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlaceCard extends Component
{
    public $place;
    public $filteredImages = [];

    /**
     * Create a new component instance.
     */
    public function __construct(Sacredplace $place)
    {
        $this->place = $place;

        // Process images immediately instead of deferring
        if (method_exists($place, 'images') && $place->images) {
            $this->filteredImages = $place->images->pluck('url')->toArray();
        } elseif ($place->image) {
            $this->filteredImages = [$place->image];
        }

        if (empty($this->filteredImages)) {
            $this->filteredImages = ['/images/placeholder.png'];
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
