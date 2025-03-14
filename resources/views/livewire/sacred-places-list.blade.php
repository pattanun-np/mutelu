<div class="w-full">
    {{-- <!-- Debug section (only visible in development) -->
    @if(config('app.debug'))
    <div class="bg-gray-100 p-4 mb-4 rounded-lg">
        <h3 class="font-semibold text-gray-700">Debug Info:</h3>
        <p>Active Filters: {{ implode(', ', $activeFilters) }}</p>
    </div>
    @endif --}}

    <!-- Dynamic Tags Filter Section -->
    <div
        class="sticky top-16 z-10 bg-white border-b border-gray-200 py-4 mb-6 -mx-4 px-4 shadow-sm">
        <div class="flex items-center space-x-4 overflow-x-auto pb-2 scrollbar-hide">
            <button
                data-filter="all"
                class="filter-button bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium text-nowrap"
            >
                All Results
            </button>
            @foreach($tags as $tag)
                <button
                    data-filter="{{ $tag->name }}"
                    class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200 text-nowrap"
                >
                    {{ $tag->name }}
                </button>
            @endforeach
            
            <button
                id="clear-filters"
                class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200 flex items-center text-nowrap"
            >
                <svg
                    class="w-4 h-4 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                    ></path>
                </svg>
                Clear Filters
                <span
                    id="active-filters-count"
                    class="ml-2 bg-rose-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden p-0.5"
                >0</span>
                </button>
        </div>
    </div>

    <!-- Grid layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 min-h-[300px]">
        @foreach($sacredplaces as $place)
            <div class="h-full">
                <!-- Use the static component instead of the regular one -->
                <x-place-card-static :place="$place" />
            </div>
        @endforeach
        <!-- Skeleton loaders for upcoming items -->
        @if($loadingMore)
            @for($i = 0; $i < 4; $i++)
                <div class="h-full">
                    <div class="group h-full rounded-xl overflow-hidden shadow-sm bg-white">
                        <div class="relative pt-[75%] overflow-hidden bg-gray-100 rounded-t-xl">
                            <div class="skeleton-loader absolute inset-0 w-full h-full bg-gray-200 animate-pulse">
                                <div class="h-full w-full flex items-center justify-center">
                                    <svg
                                        class="w-12 h-12 text-gray-300"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 flex-grow flex flex-col">
                            <div class="flex justify-between items-start mb-1">
                                <div class="h-6 w-3/4 bg-gray-200 animate-pulse rounded"></div>
                                <div class="h-4 w-10 bg-gray-200 animate-pulse rounded"></div>
                            </div>
                            <div class="h-4 w-1/2 bg-gray-200 animate-pulse rounded mb-2 mt-1"></div>
                            <div class="h-4 w-full bg-gray-200 animate-pulse rounded mb-1"></div>
                            <div class="h-4 w-2/3 bg-gray-200 animate-pulse rounded mb-2"></div>
                            <div class="mt-auto pt-2 border-t border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="h-4 w-1/3 bg-gray-200 animate-pulse rounded"></div>
                                    <div class="h-4 w-1/4 bg-gray-200 animate-pulse rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
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
        const filterButtons = document.querySelectorAll('.filter-button');
        const activeFiltersCount = document.getElementById('active-filters-count');

        // Function to update button styles based on active filters
        function updateFilterButtonStyles() {
            filterButtons.forEach(button => {
                const filter = button.getAttribute('data-filter');

                // Reset all buttons to default style
                button.classList.remove('bg-gray-900', 'text-white');
                button.classList.add('bg-white', 'text-gray-800');

                // Handle the "All Places" button
                if (filter === 'all' && @this.activeFilters.length === 0) {
                    button.classList.remove('bg-white', 'text-gray-800');
                    button.classList.add('bg-gray-900', 'text-white');
                }
                // Handle tag filter buttons
                else if (filter !== 'all' && @this.activeFilters.includes(filter)) {
                    button.classList.remove('bg-white', 'text-gray-800');
                    button.classList.add('bg-gray-900', 'text-white');
                }
            });

            // Update active filters count
            if (activeFiltersCount) {
                if (@this.activeFilters.length > 0) {
                    activeFiltersCount.textContent = @this.activeFilters.length;
                    activeFiltersCount.classList.remove('hidden');
                } else {
                    activeFiltersCount.classList.add('hidden');
                }
            }
        }

        // Initial update of button styles
        updateFilterButtonStyles();

        // Listen for filter changes
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');

                if (filter === 'all') {
                    @this.clearFilters();
                } else {
                    @this.toggleFilter(filter);
                }

                // Update button styles after a short delay to allow Livewire to update
                setTimeout(updateFilterButtonStyles, 100);
            });
        });

        // Handle the clear filters button
        const clearFiltersButton = document.getElementById('clear-filters');
        if (clearFiltersButton) {
            clearFiltersButton.addEventListener('click', () => {
                @this.clearFilters();
                setTimeout(updateFilterButtonStyles, 100);
            });
        }

        // Listen for Livewire updates
        Livewire.on('filtersUpdated', () => {
            updateFilterButtonStyles();
        });

        // Handle image loading
        function initializeImageLoaders() {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                if (img.complete) {
                    img.classList.remove('opacity-0');
                    const skeletonLoader = img.previousElementSibling;
                    if (skeletonLoader && skeletonLoader.classList.contains('skeleton-loader')) {
                        skeletonLoader.classList.add('hidden');
                    }
                }
            });
        }

        // Initialize image loaders on page load
        initializeImageLoaders();

        // Initialize image loaders when new items are loaded
        Livewire.on('items-loaded', () => {
            setTimeout(initializeImageLoaders, 100);
        });
    });
</script>