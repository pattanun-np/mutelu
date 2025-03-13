@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2">Search Results</h1>
                <p class="text-gray-600">Showing results for: <span
                        class="font-medium">{{ $search }}</span></p>
            </div>

            <div
                id="sacred-places-container"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <!-- Sacred places will be loaded here via AJAX -->
                <div class="col-span-full text-center py-8">
                    <div
                        class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500">
                    </div>
                    <p class="mt-2 text-gray-600">Loading sacred places...</p>
                </div>
            </div>

            <!-- Loading indicator for infinite scroll -->
            <div
                id="loading-more-indicator"
                class="text-center py-8 opacity-0"
            >
                <div
                    class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500">
                </div>
                <p class="mt-2 text-gray-600">Loading more...</p>
            </div>

            <!-- No results message (hidden by default) -->
            <div
                id="no-results-message"
                class="text-center py-12 hidden"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-16 w-16 mx-auto text-gray-400 mb-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <h2 class="text-xl font-semibold mb-2">No sacred places found</h2>
                <p class="text-gray-600 mb-6">We couldn't find any sacred places matching your search.
                </p>
                <a
                    href="{{ route('home') }}"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-3 rounded-lg transition-colors"
                >
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentPage = 1;
            let hasMore = true;
            const perPage = 12;
            const container = document.getElementById('sacred-places-container');
            const loadingIndicator = document.getElementById('loading-more-indicator');
            const noResultsMessage = document.getElementById('no-results-message');
            const searchQuery = "{{ $search }}";

            // Function to load sacred places
            function loadSacredPlaces(page = 1, append = false) {
                if (!hasMore && page > 1) return;

                const url = `/api/sacredplaces?page=${page}&per_page=${perPage}&search=${encodeURIComponent(searchQuery)}`;

                if (page > 1) {
                    loadingIndicator.classList.add('loading');
                    loadingIndicator.style.opacity = '1';
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (page === 1) {
                            container.innerHTML = '';
                        }

                        if (data.data.length === 0 && page === 1) {
                            noResultsMessage.classList.remove('hidden');
                            return;
                        }

                        data.data.forEach(place => {
                            const card = createSacredPlaceCard(place);
                            container.appendChild(card);
                        });

                        hasMore = data.has_more;
                        currentPage = page;

                        if (!hasMore) {
                            loadingIndicator.style.opacity = '0';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading sacred places:', error);
                    })
                    .finally(() => {
                        if (page > 1) {
                            loadingIndicator.classList.remove('loading');
                            setTimeout(() => {
                                loadingIndicator.style.opacity = '0';
                            }, 300);
                        }
                    });
            }

            // Function to create a sacred place card
            function createSacredPlaceCard(place) {
                const card = document.createElement('div');
                card.className = 'bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1';

                card.innerHTML = `
                        <a href="/sacredplaces/${place.id}" class="block">
                            <div class="relative">
                                <img src="${place.image}" alt="${place.name}" class="w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <h2 class="text-lg font-semibold mb-1 truncate">${place.name}</h2>
                                <p class="text-gray-600 text-sm line-clamp-2">${place.description}</p>
                            </div>
                        </a>
                    `;

                return card;
            }

            // Implement infinite scroll
            function handleScroll() {
                if (!hasMore) return;

                const scrollY = window.scrollY;
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight;

                // Load more when user scrolls to bottom
                if (scrollY + windowHeight >= documentHeight - 500 && hasMore) {
                    loadSacredPlaces(currentPage + 1, true);
                }
            }

            // Initial load
            loadSacredPlaces();

            // Add scroll event listener
            window.addEventListener('scroll', handleScroll);
        });
    </script>
@endsection