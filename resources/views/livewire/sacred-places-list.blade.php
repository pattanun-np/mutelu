<div>
    <div class="filters-bar mb-6 py-4 flex overflow-x-auto gap-3">
        <button
            wire:click="clearFilters"
            class="filter-pill {{ empty($activeFilters) || !is_array($activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="all"
        >
            All Places
        </button>
        <button
            wire:click="toggleFilter('temple')"
            class="filter-pill {{ is_array($activeFilters) && in_array('temple', $activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="temple"
        >
            Temples
        </button>
        <button
            wire:click="toggleFilter('church')"
            class="filter-pill {{ is_array($activeFilters) && in_array('church', $activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="church"
        >
            Churches
        </button>
        <button
            wire:click="toggleFilter('mosque')"
            class="filter-pill {{ is_array($activeFilters) && in_array('mosque', $activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="mosque"
        >
            Mosques
        </button>
        <button
            wire:click="toggleFilter('shrine')"
            class="filter-pill {{ is_array($activeFilters) && in_array('shrine', $activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="shrine"
        >
            Shrines
        </button>
        <button
            wire:click="toggleFilter('historical')"
            class="filter-pill {{ is_array($activeFilters) && in_array('historical', $activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="historical"
        >
            Historical
        </button>
        <button
            wire:click="toggleFilter('natural')"
            class="filter-pill {{ is_array($activeFilters) && in_array('natural', $activeFilters) ? 'bg-gray-800 text-white' : 'bg-gray-100' }}"
            data-category="natural"
        >
            Natural
        </button>
    </div>

    <div class="sacred-places-grid">
        @foreach($sacredplaces as $place)
            <div class="place-card-wrapper">
                <x-place-card :place="$place" />
            </div>
        @endforeach
    </div>

    <div
        x-data="{
            observe() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            @this.loadMore()
                        }
                    })
                }, {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.5
                })
                
                observer.observe(this.$el)
            }
        }"
        x-init="observe"
        class="loading-indicator flex justify-center py-6"
    >
        @if($loadingMore)
            <div class="flex items-center space-x-2">
                <svg
                    class="animate-spin h-5 w-5 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
                <span>Loading more places...</span>
            </div>
        @elseif(!$hasMorePages)
            <div class="text-gray-500">No more places to show</div>
        @else
            <div class="h-8 w-full"></div>
        @endif
    </div>
</div>