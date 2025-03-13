<?php

namespace App\Livewire;

use App\Models\Sacredplace;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

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
        if ($this->hasMorePages && !$this->loadingMore) {
            $this->loadingMore = true;

            // Use a smaller increment to reduce layout shifts
            $this->perPage += 8;

            // Dispatch browser event to refresh the UI
            $this->dispatch('items-loaded');

            // Set loadingMore back to false after a short delay
            $this->dispatch('setLoadingMoreFalse');
        }
    }

    // This method is called by the dispatch above
    #[On('setLoadingMoreFalse')]
    public function setLoadingMoreFalse()
    {
        $this->loadingMore = false;
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
        $query->select('id', 'name', 'description', 'image', 'latitude', 'longitude', 'created_at', 'updated_at', 'tags')
            ->distinct('id');

        $sacredplaces = $query->paginate($this->perPage);

        $this->hasMorePages = $sacredplaces->hasMorePages();

        // Don't set loadingMore to false here, as it will be set by the setLoadingMoreFalse method
        // after a delay to prevent multiple load requests
        // $this->loadingMore = false;

        return view('livewire.sacred-places-list', [
            'sacredplaces' => $sacredplaces
        ]);
    }
}
