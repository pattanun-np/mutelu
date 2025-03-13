<?php

namespace App\Livewire;

use App\Models\Sacredplace;
use Livewire\Component;
use Livewire\WithPagination;

class SacredPlacesList extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $hasMorePages = true;
    public $loadingMore = false;
    public $activeFilters = [];

    protected $listeners = ['loadMore', 'filterChanged'];

    public function mount()
    {
        // Ensure activeFilters is always an array
        if (!is_array($this->activeFilters)) {
            $this->activeFilters = [];
        }
    }

    public function toggleFilter($filter)
    {
        // Ensure activeFilters is an array
        if (!is_array($this->activeFilters)) {
            $this->activeFilters = [];
        }

        // Toggle the filter
        if (in_array($filter, $this->activeFilters)) {
            $this->activeFilters = array_diff($this->activeFilters, [$filter]);
        } else {
            $this->activeFilters[] = $filter;
        }

        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->activeFilters = [];
        $this->resetPage();
    }

    public function filterChanged($filters)
    {
        $this->activeFilters = $filters;
        $this->resetPage();
    }

    public function loadMore()
    {
        if ($this->hasMorePages) {
            $this->loadingMore = true;
            $this->perPage += 12;

            // Reset the page to 1 to ensure we get a fresh query with the new perPage
            // This prevents duplicates that can occur when paginating
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Sacredplace::orderBy('created_at', 'desc');

        // Apply filters if any are active
        if (!empty($this->activeFilters) && is_array($this->activeFilters)) {
            $query->whereHas('tags', function ($q) {
                $q->whereIn('name', $this->activeFilters);
            });
        }

        // Prevent duplicates by using distinct on id
        $query->select('id', 'name', 'description', 'image', 'latitude', 'longitude', 'created_at')
            ->distinct('id');

        $sacredplaces = $query->paginate($this->perPage);

        $this->hasMorePages = $sacredplaces->hasMorePages();
        $this->loadingMore = false;

        return view('livewire.sacred-places-list', [
            'sacredplaces' => $sacredplaces
        ]);
    }
}
