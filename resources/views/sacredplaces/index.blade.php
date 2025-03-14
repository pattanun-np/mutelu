@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-7xl mx-auto">
                <!-- Search Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold mb-2">Search Results</h1>
                    <p class="text-gray-600">Showing places for: <span class="font-medium">{{ $search }}</span></p>
                </div>

                <!-- Filter Section -->
                <div class="sticky top-16 z-10 bg-white border-b border-gray-200 py-4 mb-6 -mx-4 px-4 shadow-sm">
                    <div class="flex items-center space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                        <button
                            data-filter="all"
                            class="filter-button bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium"
                        >
                            All Results
                        </button>
                        <button
                            data-filter="Temple"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                        >
                            Temples
                        </button>
                        <button
                            data-filter="Church"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                        >
                            Churches
                        </button>
                        <button
                            data-filter="Mosque"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                        >
                            Mosques
                        </button>
                        <button
                            data-filter="Shrine"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                        >
                            Shrines
                        </button>
                        <button
                            data-filter="Historical"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                        >
                            Historical
                        </button>
                        <button
                            data-filter="Natural"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                        >
                            Natural
                        </button>
                        <button
                            id="clear-filters"
                            class="filter-button bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200 flex items-center"
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
                                class="ml-2 bg-rose-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden"
                            >0</span>
                        </button>
                    </div>
                </div>

                <!-- Results Grid using Livewire component -->
                <div>
                    @livewire('sacred-places-list', ['search' => $search])
                </div>
                </div>
                </div>
                </div>

                <style>
                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }

                    .scrollbar-hide {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Handle filter buttons
                        const filterButtons = document.querySelectorAll('.filter-button');
                        const clearFiltersButton = document.getElementById('clear-filters');
                        const activeFiltersCount = document.getElementById('active-filters-count');

                        // Function to update filter button styles
                        function updateFilterButtonStyles() {
                            // Get active filters from Livewire component
                            const activeFilters = Livewire.find('sacred-places-list').get('activeFilters');
                            let count = 0;

                            filterButtons.forEach(button => {
                                const filter = button.getAttribute('data-filter');

                                // Reset all buttons first
                                button.classList.remove('bg-gray-900', 'text-white');
                                button.classList.add('bg-white', 'text-gray-800', 'hover:bg-gray-100', 'border', 'border-gray-200');

                                // Handle "All Results" button
                                if (filter === 'all') {
                                    if (activeFilters.length === 0) {
                                        button.classList.remove('bg-white', 'text-gray-800', 'hover:bg-gray-100', 'border', 'border-gray-200');
                                        button.classList.add('bg-gray-900', 'text-white');
                                    }
                                }
                                // Handle other filter buttons
                                else if (activeFilters.includes(filter)) {
                                    button.classList.remove('bg-white', 'text-gray-800', 'hover:bg-gray-100', 'border', 'border-gray-200');
                                    button.classList.add('bg-gray-900', 'text-white');
                                    count++;
                                }
                            });

                            // Update active filters count
                            if (count > 0) {
                                activeFiltersCount.textContent = count;
                                activeFiltersCount.classList.remove('hidden');
                            } else {
                                activeFiltersCount.classList.add('hidden');
                            }
                        }

                        // Initialize filter button styles
                        updateFilterButtonStyles();

                        // Add click event listeners to filter buttons
                        filterButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                const filter = this.getAttribute('data-filter');

                                if (filter === 'all') {
                                    Livewire.find('sacred-places-list').call('clearFilters');
                                } else {
                                    Livewire.find('sacred-places-list').call('toggleFilter', filter);
                                }

                                // Update button styles after a short delay
                                setTimeout(updateFilterButtonStyles, 100);
                            });
                        });

                        // Handle clear filters button
                        if (clearFiltersButton) {
                            clearFiltersButton.addEventListener('click', function () {
                                Livewire.find('sacred-places-list').call('clearFilters');
                                setTimeout(updateFilterButtonStyles, 100);
                            });
                        }

                        // Listen for Livewire updates
                        document.addEventListener('livewire:initialized', () => {
                            Livewire.on('filtersUpdated', () => {
                                updateFilterButtonStyles();
                            });
                        });
        });
    </script>
@endsection