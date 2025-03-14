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
                            <button class="bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-medium">
                                All Results
                            </button>
                            <button
                                class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                            >
                                Temples
                            </button>
                            <button
                                class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                            >
                                Churches
                            </button>
                            <button
                                class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                            >
                                Mosques
                            </button>
                            <button
                                class="bg-white text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-200"
                            >
                                Shrines
                            </button>
                        </div>
                    </div>

                    <!-- Results Grid -->
                    <div
                        id="sacred-places-container"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-center justify-center"
                    >
                        <script
                            src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"
                            type="module"
                        ></script>
                        <dotlottie-player
                            id="loading-animation"
                            class="mx-auto items-center justify-center flex col-span-full"
                            src="https://lottie.host/a99a0956-d3e4-48bd-b688-bdb73a114e65/wJLftLAmiq.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 300px; height: 300px"
                            loop
                            autoplay
                        ></dotlottie-player>
                </div>

                <!-- Loading indicator for infinite scroll -->
                <div id="loading-more-indicator"
                    class="text-center py-8 opacity-0 transition-opacity duration-300"
                >
                    <div
                        class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-rose-500">
                    </div>
                    <p class="mt-2 text-gray-600">Loading more places...</p>
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
                    <p class="text-gray-600 mb-6">We couldn't find any sacred places matching your
                        search.</p>
                    <a href="{{ route('home') }}"
                        class="inline-block bg-rose-500 hover:bg-rose-600 text-white font-medium px-6 py-3 rounded-lg transition-colors"
                    >
                        Back to Home
                    </a>
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
            let currentPage = 1;
            let hasMore = true;
            const perPage = 12;
            const container = document.getElementById('sacred-places-container');
            const loadingIndicator = document.getElementById('loading-more-indicator');
            const noResultsMessage = document.getElementById('no-results-message');
            const searchQuery = "{{ $search }}";
            const loadingAnimation = document.getElementById('loading-animation');

            // Function to load sacred places
            function loadSacredPlaces(page = 1, append = false) {
                if (!hasMore && page > 1) return;

                const url = `/api/sacredplaces?page=${page}&per_page=${perPage}&search=${encodeURIComponent(searchQuery)}`;

                if (page > 1) {
                    loadingIndicator.style.opacity = '1';
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Remove loading animation on first load
                        if (page === 1) {
                            loadingAnimation.remove();
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
                            setTimeout(() => {
                                loadingIndicator.style.opacity = '0';
                            }, 300);
                        }
                    });
            }

            // Function to create a sacred place card
            function createSacredPlaceCard(place) {
                const card = document.createElement('div');
                card.className = 'group bg-white rounded-xl shadow-sm hover:shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1';

                // Use slug if available, otherwise fall back to ID
                const placeUrl = place.slug ? `/sacredplaces/${place.slug}` : `/sacredplaces/${place.id}`;

                card.innerHTML = `
                    <a href="${placeUrl}" class="block h-full flex flex-col">
                        <div class="relative pt-[75%] overflow-hidden bg-gray-100 rounded-t-xl">
                            <img src="${place.image || '/images/placeholder.png'}" 
                                 alt="${place.name}"  
                                 class="absolute inset-0 w-full h-full object-cover transition duration-300 group-hover:scale-105"
                                 onerror="this.onerror=null; this.src='/images/placeholder.png';">
                            <button class="absolute top-3 right-3 p-2 rounded-full bg-white/80 hover:bg-white shadow-sm">
                                <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-4 flex-grow flex flex-col">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-medium text-lg text-gray-900 line-clamp-1">${place.name}</h3>
                                <div class="flex items-center text-sm">
                                    <svg class="h-4 w-4 text-rose-500 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                    <span>5.0</span>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-1">Sacred Location</p>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-2">${place.description}</p>
                            <div class="mt-auto pt-2 border-t border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-rose-500">Sacred Place</span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">New</div>
                                </div>
                            </div>
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