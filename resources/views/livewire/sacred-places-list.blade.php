<div class="w-full">
    <!-- Filters bar -->
    <div
        class="sticky top-0 bg-white py-4 z-10 flex overflow-x-auto gap-3 scrollbar-hide mb-6 border-b border-gray-200">
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

    <!-- Grid layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 min-h-[300px]">
        @foreach($sacredplaces as $place)
            <div class="h-full">
                <!-- Use the static component instead of the regular one -->
                <x-place-card-static :place="$place" />
            </div>
        @endforeach
    </div>

    <!-- Simple loading indicator -->
    <div
        x-data="{
            observe() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !$wire.loadingMore) {
                        console.log('Loading more items...');
                        $wire.loadMore();
                        }
                    });
                }, {
                    root: null,
                    rootMargin: '200px',
                    threshold: 0.1
                    });
                
                observer.observe(this.$el);
            }
        }"
        x-init="observe"
        class="h-20 flex items-center justify-center my-8"
        id="loading-indicator"
    >
        @if($loadingMore)
            <div class="flex items-center space-x-2 bg-white py-2 px-4 rounded-full shadow-sm">
                <svg
                    class="animate-spin h-5 w-5 text-primary"
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
            <div class="text-gray-400">Scroll for more</div>
        @endif
    </div>
</div>