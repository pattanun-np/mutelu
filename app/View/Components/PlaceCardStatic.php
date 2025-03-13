<?php

namespace App\View\Components;

use App\Models\Sacredplace;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlaceCardStatic extends Component
{
    public $place;

    /**
     * Create a new component instance.
     */
    public function __construct(Sacredplace $place)
    {
        $this->place = $place;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.place-card-static');
    }
}
