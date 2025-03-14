<?php

namespace App\Livewire;

use App\Models\Sacredplace;
use App\Models\Tag;
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
    public $search = '';

    protected $listeners = ['loadMore', 'filterChanged', 'searchUpdated'];

    public function mount($search = null)
    {
        // Ensure activeFilters is always an array
        if (!is_array($this->activeFilters)) {
            $this->activeFilters = [];
        }

        // Set search parameter if provided
        if ($search) {
            $this->search = $search;
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
        $this->dispatch('filtersUpdated');
    }

    public function clearFilters()
    {
        $this->activeFilters = [];
        $this->resetPage();
        $this->dispatch('filtersUpdated');
    }

    public function filterChanged($filters)
    {
        $this->activeFilters = $filters;
        $this->resetPage();
        $this->dispatch('filtersUpdated');
    }

    public function searchUpdated($searchTerm)
    {
        $this->search = $searchTerm;
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

        // Apply search filter if provided
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");

                // Instead of using orWhereHas, we'll use a subquery to search tags
                $tagIds = Tag::where('name', 'like', "%{$this->search}%")->pluck('id')->toArray();
                if (!empty($tagIds)) {
                    foreach ($tagIds as $tagId) {
                        $q->orWhereJsonContains('tag_ids', $tagId);
                    }
                }
            });
        }

        // Apply filters if any are active
        if (!empty($this->activeFilters) && is_array($this->activeFilters)) {
            $tagIds = Tag::whereIn('name', $this->activeFilters)->pluck('id')->toArray();

            if (!empty($tagIds)) {
                $query->where(function ($q) use ($tagIds) {
                    foreach ($tagIds as $tagId) {
                        $q->orWhereJsonContains('tag_ids', $tagId);
                    }
                });
            }
        }

        // Prevent duplicates by using groupBy instead of distinct
        $query->select('id', 'name', 'description', 'image', 'latitude', 'longitude', 'created_at', 'updated_at', 'tag_ids', 'slug')
            ->groupBy('id');

        $sacredplaces = $query->paginate($this->perPage);

        $this->hasMorePages = $sacredplaces->hasMorePages();

        return view('livewire.sacred-places-list', [
            'sacredplaces' => $sacredplaces
        ]);
    }
}
