<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sacredplace;

class PlaceCard extends Component
{
    public $place;
    public $imageIndex = 0;
    public $filteredImages = [];

    public function mount(Sacredplace $place)
    {
        $this->place = $place;
    }

    public function loadPlace()
    {
        // Check if the place has an image relationship
        if (method_exists($this->place, 'images') && $this->place->images) {
            // If there's an images relationship, use it
            $this->filteredImages = $this->place->images->pluck('url')->toArray();
        } else if ($this->place->image) {
            // Otherwise use the single image field
            $this->filteredImages = [$this->place->image];
        }

        // If no images, use a placeholder
        if (empty($this->filteredImages)) {
            $this->filteredImages = ['/images/placeholder.jpg'];
        }
    }

    public function previousImage()
    {
        if ($this->imageIndex > 0) {
            $this->imageIndex--;
        }
    }

    public function nextImage()
    {
        if ($this->imageIndex < count($this->filteredImages) - 1) {
            $this->imageIndex++;
        }
    }

    public function setImageIndex($index)
    {
        $this->imageIndex = $index;
    }

    public function toggleFavorite()
    {
        // Implement favorite functionality if needed
    }

    public function render()
    {
        return view('livewire.place-card');
    }
}
