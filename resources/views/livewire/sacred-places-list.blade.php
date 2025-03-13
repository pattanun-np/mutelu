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
                    class="animate-spin h-5 w-5 text-rose-500"
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
            <div class="text-gray-500 py-8 text-center">
                <svg
                    class="w-12 h-12 mx-auto text-gray-300 mb-3"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                    />
                </svg>
                <p class="text-lg font-medium">You've seen all sacred places</p>
                <p class="text-sm text-gray-500 mt-1">Check back later for new additions</p>
            </div>
        @else
            <div class="text-gray-400 flex items-center">
                <svg
                    class="w-5 h-5 mr-2 animate-bounce"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3"
                    />
                </svg>
                Scroll for more
            </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('livewire:initialized', () => {
        // Handle filter button clicks from the parent component
        const filterButtons = document.querySelectorAll('[data-filter]');
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                if (filter === 'all') {
                    @this.clearFilters();
                } else {
                    @this.toggleFilter(filter);
                }
            });
        });
    });
</script>